# デプロイ手順 — ConoHa WING（SSH + WP-CLI）

ローカルの Claude Code（または手元のターミナル）で実行します。
このWeb実行環境からは ConoHa へ直接SSHできない場合があるため、**ローカルでの実行**を前提としています。

## 0. 事前準備（ConoHa WING 管理画面）

1. **WordPress がインストール済み**であること（済）。
2. **SSH を有効化**：サーバー管理 > SSH で鍵を作成し、秘密鍵をダウンロード。
   - ホスト名（例 `www123.conoha.ne.jp`）、ユーザー名、ポート `8022` を控える。
3. **無料独自SSL** を「利用設定 ON」にする（サイト設定）。
4. ドキュメントルート（`wp-config.php` のある場所）のパスを控える。
   - 例: `/home/c1234567/public_html/transistors.co.jp`

## 1. イラストPNGを配置

```bash
cd transistors-site/deploy
./fetch-illust.sh          # gdown があれば自動DL。無ければ手動DL手順を表示
```
`theme/assets/illust/` に hero/mission/education/sports/business/appdev.png が揃えばOK。

## 2. 接続情報を設定

```bash
cp config.example.sh config.sh
vi config.sh               # ホスト/ユーザー/鍵/WP_PATH/SITE_URL を記入
```
`config.sh` は `.gitignore` 済み（コミットされません）。認証情報をリポジトリに入れないでください。

## 3. デプロイ実行

```bash
./deploy.sh
```
スクリプトが行うこと:

- テーマを `wp-content/themes/transistors/` へ転送（rsync）
- テーマを有効化
- 固定ページ作成（`home`/`blog`/`education`/`sports`/`business`/`appdev`/`about`/`contact`）
- フロントページ=ホーム、投稿ページ=Blog に設定
- パーマリンクを `/%postname%/` に設定
- カテゴリ作成（教育/スポーツ/ビジネス）
- Contact Form 7 を導入し、送信先 `info@transistors.co.jp` のフォームを作成
- サイトURLを `https://transistors.co.jp` に統一

## 4. 受け入れチェック

- [ ] 全ページが静的版と同じ見た目（配色・余白・フォント・イラスト位置）
- [ ] スマホ表示（ヘッダー折りたたみ、グリッド1列化）
- [ ] お問い合わせ送信 → `info@transistors.co.jp` に届く
- [ ] https 表示（混在コンテンツなし）
- [ ] パーマリンク（`/education` など）が機能

## 補足

- ヘッダー/フッターのグローバルメニューは、デザイン一致のため `header.php`/`footer.php` に
  直接記述しています（WordPressメニュー機能ではなくテーマ管理）。リンク先は固定ページの
  スラッグ（/education 等）に追従します。
- お問い合わせフォームは、CF7フォームが存在すれば `page-contact.php` が自動でそれを表示します。
  フォーム未作成時は体裁のみのデモフォームにフォールバックします。
