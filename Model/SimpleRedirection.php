<?php
/**
 * [Model] SimpleRedirection
 *
 * @link http://www.materializing.net/
 * @author arata
 * @package SimpleRedirection
 * @license MIT
 */
class SimpleRedirection extends AppModel {

	public $useTable = false;

	public function beforeValidate($options = []) {
		if ($this->data) {
			$errorCount = 0;
			$sourceList = []; // 遷移元重複チェック用のリスト

			foreach ($this->data['SimpleRedirection'] as $key => $data) {
				// 遷移元の未入力チェック
				if (Validation::blank($data['SimpleRedirection']['source'])) {
					$this->data['SimpleRedirection'][$key]['SimpleRedirection']['error'][] = '遷移元は必須入力です。';
					$errorCount++;
				}
				// 遷移先の未入力チェック
				if (Validation::blank($data['SimpleRedirection']['target'])) {
					$this->data['SimpleRedirection'][$key]['SimpleRedirection']['error'][] = '遷移先は必須入力です。';
					$errorCount++;
				}
				// 遷移元と先の同一値チェック
				if ($data['SimpleRedirection']['source'] === $data['SimpleRedirection']['target']) {
					$this->data['SimpleRedirection'][$key]['SimpleRedirection']['error'][] = '遷移元と遷移先は同一にできません。';
					$errorCount++;
				}

				$sourceList[$key] = $data['SimpleRedirection']['source'];
			}

			// 遷移元の重複チェック
			foreach ($this->data['SimpleRedirection'] as $key => $data) {
				$result = array_search($data['SimpleRedirection']['source'], $sourceList, true);
				// チェックする遷移元値のkeyと同じkeyは自身のデータなのでスルーし、異なるkeyは自身以外と重複している
				if ($result !== $key) {
					$this->data['SimpleRedirection'][$key]['SimpleRedirection']['error'][] = '遷移元に重複が存在します。';
					$errorCount++;
				}
			}

			if ($errorCount) {
				return false;
			}

			// 設定値の容量チェック
			$sizeOfJson = strlen( json_encode($this->data['SimpleRedirection'], JSON_UNESCAPED_UNICODE) );
			if ($sizeOfJson > 65000) {
				$this->validationErrors[] = 'リダイレクト設定が65000文字を超えているので減らしてください。';
				return false;
			}
		}

		return true;
	}

}
