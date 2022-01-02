<?php
/**
 * [Config] SimpleRedirection
 *
 * @link http://www.materializing.net/
 * @author arata
 * @package SimpleRedirection
 * @license MIT
 */
/**
 * システムナビ
 */
$config['BcApp.adminNavigation'] = [
	'Plugins' => [
		'menus' => [
			'SimpleRedirections' => [
				'title' => __d('baser', 'シンプルリダイレクト設定'),
				'url' => ['admin' => true, 'plugin' => 'simple_redirection', 'controller' => 'simple_redirections', 'action' => 'index'],
			],
		]
	],
];
// admin-second用
$config['BcApp.adminNavi.simple_redirection'] = [
	'name' => __d('baser', 'シンプルリダイレクト設定'),
	'contents' => [
		[
			'name' => __d('baser', 'シンプルリダイレクト設定'),
			'url' => ['admin' => true, 'plugin' => 'simple_redirection', 'controller' => 'simple_redirections', 'action' => 'index']
		],
	]
];

// 専用ログ: リダイレクト設定内容
if (!defined('LOG_SIMPLE_REDIRECTION')) {
	define('LOG_SIMPLE_REDIRECTION', 'log_simple_redirection');
	CakeLog::config('log_simple_redirection', [
		'engine' => 'FileLog',
		'types' => ['log_simple_redirection'],
		'file' => 'log_simple_redirection',
		'size' => '5MB',
		'rotate' => 5,
	]);
}
// 専用ログ: リダイレクト実行内容
if (!defined('LOG_SIMPLE_REDIRECTION_EXEC')) {
	define('LOG_SIMPLE_REDIRECTION_EXEC', 'log_simple_redirection_exec');
	CakeLog::config('log_simple_redirection_exec', [
		'engine' => 'FileLog',
		'types' => ['log_simple_redirection_exec'],
		'file' => 'log_simple_redirection_exec',
		'size' => '5MB',
		'rotate' => 5,
	]);
}
