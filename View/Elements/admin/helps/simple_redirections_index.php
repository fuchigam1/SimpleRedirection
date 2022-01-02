<?php
/**
 * [ADMIN] SimpleRedirection
 *
 * @link http://www.materializing.net/
 * @author arata
 * @package SimpleRedirection
 * @license MIT
 */
?>
<h4>リダイレクト設定の追加方法</h4>
<p>
	画面下部の「設定追加」ボタンよりリダイレクト設定を追加できます。
</p>

<h4>遷移元、遷移先に入力するURLについて</h4>
<p>
	日本語部分はURLエンコード化した文字列を入力してください。（UTF-8）
	<br>
	・例: /example/サンプル ＝ /example/<?php echo urlencode('サンプル'); ?>
</p>
<p>
	遷移元URLが、パラメータ付きURLも含めて合致した場合に、遷移先にリダイレクトします。
	<br>
	・例: 遷移元に「/news/archives/1?example=1」と入力しているとき、「/news/archives/1」でアクセスしてもリダイレクトされません。
</p>

<h4>HTTPステータスコードについて</h4>
<p>
	選択できるHTTPステータスコードの意味は以下です。
</p>
<ul>
	<li>302 - Found（Temporary Redirect）＝ 一時的な移動</li>
	<li>301 - Moved Permanently ＝ 恒久的な移動</li>
</ul>

<h4>リダイレクト設定の削除について</h4>
<p>
	「この設定を削除する」にチェックを入れて保存すると、該当行のリダイレクト設定を削除します。
</p>

<h4>確認について</h4>
<p>
	「遷移元URL」の入力、「遷移先URL」の入力、「利用する」にチェック指定がある場合に、遷移元URLにアクセスして確認できます。
</p>
