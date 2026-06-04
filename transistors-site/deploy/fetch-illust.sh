#!/usr/bin/env bash
# Google Drive からイラストPNGを取得して theme/assets/illust/ に配置する。
# 容量の都合でリポジトリに含めていないPNGをデプロイ前に揃えるためのスクリプト。
#
# 使い方:
#   ./fetch-illust.sh
#
# gdown（pip install gdown）があればそれを使って自動DLします。
# 無い場合は、ご自身のGoogle Driveから手動でDLして配置する手順を表示します。
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ILLUST_DIR="$SCRIPT_DIR/../theme/assets/illust"
mkdir -p "$ILLUST_DIR"

# ファイル名 => Drive File ID
declare -A FILES=(
  ["hero.png"]="12SXJ-zc6cl5RZFmacahNmBwtl-MZ-WUv"
  ["mission.png"]="1vekom__0bLJLsqHEMA9fiFUbhjB9xm62"
  ["education.png"]="1gVtRaqEcldg_PIlGulFjrdL-FpCYk9kX"
  ["sports.png"]="1zpXxDOJAVROLqZytI-K8FbobOUJFwd3s"
  ["business.png"]="1ypEDJv-mYh34VuI_U9n8WMkysuypBPse"
  ["appdev.png"]="1z74aIj3IVUddYKcLte7YbX-jJrcFc7DM"
)

if command -v gdown >/dev/null 2>&1; then
  echo "gdown を使ってダウンロードします..."
  for name in "${!FILES[@]}"; do
    echo "  - $name"
    gdown --id "${FILES[$name]}" -O "$ILLUST_DIR/$name" --quiet || {
      echo "    ⚠ $name のDLに失敗（権限/ネットワークを確認）"; }
  done
  echo "完了: $ILLUST_DIR"
  ls -la "$ILLUST_DIR"
else
  echo "gdown が見つかりません。次のいずれかで取得してください:"
  echo
  echo "  方式A) gdown を入れて再実行:"
  echo "         pip install gdown && ./fetch-illust.sh"
  echo
  echo "  方式B) ブラウザでご自身のDriveから 'TRANS_HP/assets/illust' フォルダを"
  echo "         ダウンロードし、次のファイルを $ILLUST_DIR に配置:"
  for name in "${!FILES[@]}"; do
    echo "         - $name  (https://drive.google.com/file/d/${FILES[$name]}/view)"
  done
  exit 1
fi
