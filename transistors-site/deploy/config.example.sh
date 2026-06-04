#!/usr/bin/env bash
# ConoHa WING デプロイ設定のサンプル。
# cp config.example.sh config.sh して config.sh を編集してください（config.sh は .gitignore 済み）。
# 認証情報はここに書き、リポジトリにはコミットしないこと。

# --- SSH 接続（ConoHa WING 管理画面 > サーバー管理 > SSH で発行） ---
export CONOHA_SSH_HOST="www123.conoha.ne.jp"     # 接続先ホスト名 or IP
export CONOHA_SSH_USER="c1234567"                # SSHユーザー名
export CONOHA_SSH_PORT="8022"                    # ConoHa WING の SSH ポート（通常 8022）
export CONOHA_SSH_KEY="$HOME/.ssh/conoha_key"    # 秘密鍵ファイルのパス

# --- WordPress（ConoHa にインストール済み） ---
# wp-config.php があるディレクトリ（ドキュメントルート）
export WP_PATH="/home/c1234567/public_html/transistors.co.jp"
# 公開URL（無料独自SSLを有効化後は https に）
export SITE_URL="https://transistors.co.jp"

# --- 連絡先（Contact Form 7 の送信先） ---
export CONTACT_EMAIL="info@transistors.co.jp"

# wp-cli のパス（サーバー側）。ConoHa は通常 'wp' で利用可。無ければ phar を配置。
export WP_CLI="wp"
