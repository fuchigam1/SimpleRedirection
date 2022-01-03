# SimpleRedirection

リダイレクト機能を追加できる[baserCMS](https://basercms.net/)専用のプラグインです。


## Setup, Installation

1. 圧縮ファイルを解凍後、BASERCMS/app/Plugin/SimpleRedirection に配置します。
2. 管理システムのプラグイン管理に入って、表示されている シンプルリダイレクションプラグイン を有効化して下さい。


## Usage

- シンプルリダイレクト設定画面にアクセスします。
- 画面下部の「設定追加」よりリダイレクト設定を追加します。

### Redirection

以下のアクセスは、リダイレクト実施判定から除外します。

- POST動作によるアクセス。GETアクセス動作のみ判定
- コンソールによるアクセス
- 管理側URLへのアクセス
- ajax処理によるアクセス（例: ajax_get_token）
- requestActionによるアクセス（例: /blog/blog/get_recent_entries/〜）
- アイキャッチ画像のfilesアクセス（例: /files/blog/1/blog_posts/〜）
- 静的ファイルに対するアクセス（例: /example/example.php として設置した実体ファイルへのアクセス）

### Data

- シンプルリダイレクト設定値の保存先
    - site_configs テーブル内の name値が simple_redirection 内にjson形式で保存します。
    - プラグインの無効化・削除の際は、手動でデータを削除してください。残っていても本体動作に問題はありません。

```sql
DELETE FROM `mysite_site_configs`
WHERE `name` = 'simple_redirection';
```

### Logs

ログファイルに動作を書き出す仕組みがあります。

- app/tmp/logs/log_simple_redirection.log
    - リダイレクト設定保存時のjson形式をスナップショットとして記録
    - リダイレクト設定保存時のjson形式にエラーがある場合に記録
    - リダイレクト設定読出時のjson形式にエラーがある場合に記録
- app/tmp/logs/log_simple_redirection_exec.log
    - リダイレクト設定によるリダイレクトが実行された際の遷移元と遷移先を記録


## Dependency

- baserCMSの管理画面で利用される各種ライブラリ
    - jQuery

### Version Info

対応するbaserCMSのバージョン: baserCMS4系

| Version | baserCMS | admin-second | admin-thrid |
|:--|:--|:--|:--|
| 1.0.0 | 4.5.4 | 対応 | 対応 |

### Development Rules

開発ブランチの規則は以下です。

- main
- dev-4・・・開発版 (Pull Request Target)

### NoDevelopmentPlan

以下対応予定はありません。

- サブサイト別のリダイレクト設定
- 遷移元URLの正規表現による指定
- リダイレクト設定一覧の並び替え


## Support, Reports

- GitHub Issues: https://github.com/materializing/SimpleRedirection/issues


## License
This software is released under the MIT License, see [LICENSE](https://choosealicense.com/licenses/mit/).


## Thanks, References

- [https://basercms.net/](https://basercms.net/)
- [https://wiki.basercms.net/](https://wiki.basercms.net/)
- [https://cakephp.jp](https://cakephp.jp)
- [Semantic Versioning 2.0.0](https://semver.org/lang/ja/)
