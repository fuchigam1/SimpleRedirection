<?php
/**
 * [Controller] SimpleRedirectionsController
 *
 * @link http://www.materializing.net/
 * @author arata
 * @package SimpleRedirection
 * @license MIT
 */
class SimpleRedirectionsController extends AppController {

	public $uses = ['SiteConfig'];

	public $components = ['BcAuth', 'Cookie', 'BcAuthConfigure'];

	public $crumbs = [
		[
			'name' => 'シンプルリダイレクト設定',
			'url' => ['plugin' => 'simple_redirection', 'controller' => 'simple_redirections', 'action' => 'index']
		],
	];

	/**
	 * contructer
	 */
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		// 利用設定値の追加・更新: uses に設定するとテーブルを探しに行くためこのタイミングでモデルを取る
		$this->SimpleRedirectionModel = ClassRegistry::init('SimpleRedirection.SimpleRedirection');
	}

	/**
	 * [ADMIN] 設定一覧
	 */
	public function admin_index() {
		$this->pageTitle = 'シンプルリダイレクト設定';
		$this->help = 'simple_redirections_index';

		if ($this->request->is(['post', 'put'])) {
			if ($this->request->data) {
				// 「削除する」指定行を削除する
				$counter = 1;
				$convertedArray = [];
				foreach ($this->request->data as $key => $dataRow) {
					if ($dataRow['SimpleRedirection']['delete']) {
						unset($this->request->data[$key]);
					} else {
						$convertedArray[$counter] = $dataRow;
						$counter++;
					}
				}
				$this->request->data = $convertedArray;
			}

			$this->SimpleRedirectionModel->set($this->request->data);
			if (!$this->SimpleRedirectionModel->validates()) {
				// 入力チェックのエラーを持っているデータと入れ替える: errorキー
				$this->request->data = $this->SimpleRedirectionModel->data['SimpleRedirection'];

				$errorMessage = $this->SimpleRedirectionModel->validationErrors;
				$errorMessage[] = '入力エラーです。内容を修正してください。';

				$this->BcMessage->setError(implode(' ', $errorMessage));
				$this->render('index');
				return;
			} else {
				$encoded = json_encode($this->request->data, JSON_UNESCAPED_UNICODE);
				if (JSON_ERROR_NONE !== json_last_error()) {
					$errorList['json_error'] = json_last_error_msg();
					$message = '保存できない文字列が含まれています。内容を修正してください。';
					$message .= $errorList['json_error'];
					$this->BcMessage->setError($message);

					CakeLog::write(LOG_SIMPLE_REDIRECTION, $errorList['json_error']);
					CakeLog::write(LOG_SIMPLE_REDIRECTION, print_r($this->request->data, true));

					$this->render('index');
					return;
				}

				if ($this->SiteConfig->saveKeyValue(['simple_redirection' => $encoded])) {
					// 保存時のスナップショットとしてログに取っておく
					CakeLog::write(LOG_SIMPLE_REDIRECTION, '[SAVE SUCCESS]');
					CakeLog::write(LOG_SIMPLE_REDIRECTION, $encoded, true);
					$this->BcMessage->setSuccess('シンプルリダイレクト設定を保存しました。');
					clearAllCache();
				} else {
					CakeLog::write(LOG_SIMPLE_REDIRECTION, '[SAVE FALSE]');
					CakeLog::write(LOG_SIMPLE_REDIRECTION, print_r($this->request->data, true));
					$this->BcMessage->setError('シンプルリダイレクト設定の保存に失敗しました。');
				}

				$this->redirect(['action' => 'index']);
			}
		} else {
			$data = $this->SiteConfig->findByName('simple_redirection');
			if ($data) {
				$decoded = json_decode($data['SiteConfig']['value'], true);
				if (JSON_ERROR_NONE !== json_last_error()) {
					$errorList['json_error'] = json_last_error_msg();
					$message = 'フォーム用の文字列に変換できない文字列が含まれています。内容を修正してください。';
					$message .= $errorList['json_error'];
					$this->BcMessage->setError($message);

					CakeLog::write(LOG_EXAMPLE_PLUGIN, $errorList['json_error']);
					CakeLog::write(LOG_EXAMPLE_PLUGIN, $decoded);
				} else {
					$this->request->data = $decoded;
				}
			}
		}
	}

}
