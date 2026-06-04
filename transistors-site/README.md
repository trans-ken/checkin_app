# transistors サイト — 静的ソース & WordPressテーマ化

Google Drive `TRANS_HP/` にある静的サイト（Claude Designで作成）を WordPress テーマ化し、
ConoHa WING へデプロイするためのプロジェクトです。

## ディレクトリ構成

```
transistors-site/
├ src/                     静的サイトの正本（デザイン確定版・Driveから復元）
│  ├ index.html            トップ
│  ├ education/sports/business/appdev.html   事業内容LP
│  ├ about.html / blog.html / contact.html
│  └ assets/
│     ├ styles.css         デザイントークン（色・フォント・余白）
│     ├ site.css           共通スタイル
│     ├ transistors-mark.svg / -white.svg / transistors-badge.svg
│     └ illust/            イラストPNG（MANIFEST.json 参照・別途配置）
├ theme/                   WordPressテーマ "transistors"（src を WP 化）
└ deploy/                  ConoHa WING へのデプロイ（WP-CLI/SSH）
```

## イラストPNGについて

イラスト（hero/mission/education/sports/business/appdev.png）は各約1MBあり、
Web実行環境のコンテキスト制約のためリポジトリに含めていません。
`src/assets/illust/MANIFEST.json` にDriveのファイルIDを記載しています。
デプロイ時に `deploy/fetch-illust.sh` または手動でDriveからダウンロードし、
`theme/assets/illust/` に配置してください。

## 仕様（Drive の CLAUDE_CODE_HANDOFF.md より）

- テーマ名 `transistors`（クラシックテーマ・自作）
- フロントページ = index、固定ページ `/education /sports /business /appdev /about /contact`
- ブログ = 投稿アーカイブ（カテゴリ: 教育/スポーツ/ビジネス）
- お問い合わせ = Contact Form 7（送信先 `info@transistors.co.jp`）
- ドメイン `transistors.co.jp`、無料独自SSLで https 化
- フォント = Google Fonts、アイコン = Lucide（CDN）
