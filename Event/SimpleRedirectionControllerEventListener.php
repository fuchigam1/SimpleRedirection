<?php
/**
 * [ControllerEventListener] SimpleRedirection
 *
 * @link http://www.materializing.net/
 * @author arata
 * @package SimpleRedirection
 * @license MIT
 */
class SimpleRedirectionControllerEventListener extends BcControllerEventListener {

	public $events = ['startup'];

	public function startup(CakeEvent $event) {
		if (isConsole()) {
			return;
		}

		if (BcUtil::isAdminSystem()) {
			return;
		}

		$Controller = $event->subject();

		// ajax系処理はスルー。ajax_get_token避け
		if ($Controller->request->is('ajax')) {
			return;
		}

		if ($Controller->request->is('get')) {
			$SiteConfigModel = ClassRegistry::init('SiteConfig');
			$data = $SiteConfigModel->findByName('simple_redirection');
			if (Hash::get($data, 'SiteConfig.value')) {
				$decoded = json_decode($data['SiteConfig']['value'], true);
				if ($decoded) {
					foreach ($decoded as $redirection) {
						if ($redirection['SimpleRedirection']['status']) {
							$queryString = '';
							$query = $Controller->request->query;
							if ($query) {
								// 日本語文字列はurlencode化される
								$queryString = http_build_query($query);
								$queryString = '?'. $queryString;
							}
							// hereはURLエンコードされたURLが入ってくる
							if ($redirection['SimpleRedirection']['source'] === $Controller->request->here . $queryString) {
								CakeLog::write(LOG_SIMPLE_REDIRECTION_EXEC,
									'[EXEC_REDIRECT '. intval($redirection['SimpleRedirection']['status_code']) .'] '
									. $Controller->request->here . $queryString
									.' → '. $redirection['SimpleRedirection']['target']
								);
								$Controller->redirect(
									$redirection['SimpleRedirection']['target'],
									intval($redirection['SimpleRedirection']['status_code'])
								);
							}
						}
					}
				}
			}
		}

	}

}
