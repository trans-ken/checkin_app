# イラスト入り QR コード生成 (Google Apps Script Web App)

中央にロゴ・イラストを配置した QR コードを生成し、Google Drive に保存できる
GAS Web アプリです。

## 主な機能

- URL / テキストから QR コードを生成 (誤り訂正レベル L / M / Q / H)
- 任意のロゴ画像 (PNG / JPG / SVG) を中央に重ねて配置
- ロゴサイズ・形状 (角丸 / 四角 / 円)・下地の有無を調整
- 前景色・背景色・サイズ・余白をカスタマイズ
- PNG ダウンロード
- Google Drive (フォルダ「QRコード生成」) への保存と一覧表示

## ファイル構成

| ファイル | 役割 |
| --- | --- |
| `appsscript.json` | マニフェスト (タイムゾーン、OAuth スコープ、Web アプリ設定) |
| `Code.gs` | サーバーサイド: `doGet`、Drive 保存、一覧取得 |
| `index.html` | UI 本体 |
| `style.html` | CSS (`<?!= include('style') ?>` で読み込み) |
| `javascript.html` | クライアント JS。`qrcode.js` を CDN から読み込み Canvas に描画 |

## セットアップ手順

### A. ブラウザから手動でデプロイ

1. <https://script.google.com/> を開き、新しいプロジェクトを作成
2. 既定の `Code.gs` を本リポジトリの `Code.gs` の内容で置き換え
3. 「ファイル」→「新規」→「HTML ファイル」で次の名前で 3 つ作成し、それぞれ
   このリポジトリの同名ファイルの中身を貼り付け:
   - `index`
   - `style`
   - `javascript`
4. 左メニュー「プロジェクト設定」→「`appsscript.json` マニフェスト ファイルを
   エディタで表示する」を ON にしてから、`appsscript.json` を本リポジトリの
   内容で置き換え
5. 「デプロイ」→「新しいデプロイ」→ 種類で **ウェブアプリ** を選択
   - 実行するユーザー: 自分
   - アクセスできるユーザー: 自分のみ (必要に応じて変更)
6. 表示された Web アプリ URL を開いて利用

### B. clasp を使う場合

```bash
npm install -g @google/clasp
clasp login
clasp create --type webapp --title "QR Code Illustrator"
# 生成された .clasp.json があるディレクトリへ本リポジトリのファイルをコピー
clasp push
clasp deploy
```

## 使い方

1. **QR コードの内容**: URL またはテキストを入力
2. **イラスト / ロゴ**: 画像を選択し、サイズ・形状・下地を調整
   - ロゴで一部が隠れるため、誤り訂正レベルは **H** 推奨 (約 30% 復元可)
   - ロゴ割合は 30% 前後が上限の目安
3. **生成 / 更新** ボタンで描画
4. **PNG ダウンロード** または **Google Drive に保存**
5. 「保存済み QR コード」セクションで Drive 内の一覧を確認

## OAuth スコープ

- `drive.file`: このアプリ自身が作成 / 開いたファイルのみアクセス可能
- `script.container.ui`: Web UI 表示用

## 技術メモ

- QR 生成は [`qrcode`](https://github.com/soldair/node-qrcode) ライブラリを
  jsDelivr CDN から読み込み、ブラウザ Canvas 上で完結
- 生成された PNG を `toDataURL` で取り出し、`google.script.run` 経由で GAS に
  送信して `DriveApp.createFolder` / `createFile` で保存
- 完成イメージはチェック柄プレビューで透過確認可能
