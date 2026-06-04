#!/usr/bin/env bash
# ConoHa WING へ transistors テーマをデプロイする（SSH + WP-CLI）。
#
# 前提:
#   - ConoHa WING に WordPress がインストール済み
#   - SSH（公開鍵認証）が有効（管理画面 > サーバー管理 > SSH）
#   - deploy/config.sh に接続情報を記入済み（config.example.sh をコピーして作成）
#   - theme/assets/illust/ にイラストPNGを配置済み（fetch-illust.sh 参照）
#
# 使い方:
#   cd deploy && cp config.example.sh config.sh && vi config.sh
#   ./deploy.sh
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
THEME_DIR="$SCRIPT_DIR/../theme"

# --- 設定読み込み ---
if [ ! -f "$SCRIPT_DIR/config.sh" ]; then
  echo "エラー: config.sh がありません。'cp config.example.sh config.sh' して編集してください。" >&2
  exit 1
fi
# shellcheck disable=SC1091
source "$SCRIPT_DIR/config.sh"

: "${CONOHA_SSH_HOST:?config.sh に CONOHA_SSH_HOST を設定してください}"
: "${CONOHA_SSH_USER:?config.sh に CONOHA_SSH_USER を設定してください}"
: "${CONOHA_SSH_PORT:=8022}"
: "${CONOHA_SSH_KEY:?config.sh に CONOHA_SSH_KEY を設定してください}"
: "${WP_PATH:?config.sh に WP_PATH を設定してください}"
: "${SITE_URL:?config.sh に SITE_URL を設定してください}"
: "${CONTACT_EMAIL:=info@transistors.co.jp}"
: "${WP_CLI:=wp}"

SSH_OPTS=(-p "$CONOHA_SSH_PORT" -i "$CONOHA_SSH_KEY" -o StrictHostKeyChecking=accept-new)
REMOTE="$CONOHA_SSH_USER@$CONOHA_SSH_HOST"
REMOTE_THEME="$WP_PATH/wp-content/themes/transistors"

# --- イラストPNGの存在チェック（無くてもデプロイは継続） ---
MISSING=0
for png in hero mission education sports business appdev; do
  [ -f "$THEME_DIR/assets/illust/$png.png" ] || { echo "  ⚠ 未配置: assets/illust/$png.png"; MISSING=1; }
done
if [ "$MISSING" = "1" ]; then
  echo "イラストPNGが未配置です。先に ./fetch-illust.sh を実行することを推奨します。"
  read -r -p "このまま続けますか？ [y/N] " ans
  [ "$ans" = "y" ] || [ "$ans" = "Y" ] || { echo "中止しました。"; exit 1; }
fi

echo "==> 接続確認: $REMOTE:$CONOHA_SSH_PORT"
ssh "${SSH_OPTS[@]}" "$REMOTE" "echo OK && $WP_CLI --version --path=$WP_PATH >/dev/null 2>&1 && echo 'wp-cli OK' || echo 'wp-cli が見つかりません（WP_CLI を確認）'"

echo "==> テーマを転送: $REMOTE_THEME"
ssh "${SSH_OPTS[@]}" "$REMOTE" "mkdir -p $REMOTE_THEME"
if command -v rsync >/dev/null 2>&1; then
  rsync -az --delete \
    --exclude '.DS_Store' \
    -e "ssh ${SSH_OPTS[*]}" \
    "$THEME_DIR/" "$REMOTE:$REMOTE_THEME/"
else
  echo "  rsync が無いため scp で転送します"
  scp -P "$CONOHA_SSH_PORT" -i "$CONOHA_SSH_KEY" -r "$THEME_DIR/." "$REMOTE:$REMOTE_THEME/"
fi

echo "==> WordPress セットアップを実行"
ssh "${SSH_OPTS[@]}" "$REMOTE" \
  "WP_PATH='$WP_PATH' SITE_URL='$SITE_URL' CONTACT_EMAIL='$CONTACT_EMAIL' WP_CLI='$WP_CLI' bash -s" \
  < "$SCRIPT_DIR/wp-setup.sh"

echo
echo "==> デプロイ完了: $SITE_URL"
echo "    確認: 全ページの表示 / スマホ表示 / お問い合わせ送信 / https / パーマリンク(/education など)"
