#!/usr/bin/env bash
# サーバー側で実行される WordPress セットアップ（WP-CLI）。
# deploy.sh から SSH 経由で実行される。手動実行も可。
# 必要な環境変数: WP_PATH, SITE_URL, CONTACT_EMAIL, WP_CLI
set -euo pipefail

WP_CLI="${WP_CLI:-wp}"
WP="$WP_CLI --path=$WP_PATH"

echo "==> テーマ 'transistors' を有効化"
$WP theme activate transistors

# 固定ページを slug 指定で作成（既存ならそのID再利用）。page-{slug}.php が自動適用される。
ensure_page() { # $1=title $2=slug
  local id
  id=$($WP post list --post_type=page --name="$2" --field=ID --posts_per_page=1 2>/dev/null | head -n1 || true)
  if [ -z "$id" ]; then
    id=$($WP post create --post_type=page --post_status=publish --post_title="$1" --post_name="$2" --porcelain)
  fi
  echo "$id"
}

echo "==> 固定ページを作成"
HOME_ID=$(ensure_page "ホーム" "home")
BLOG_ID=$(ensure_page "Blog" "blog")
ensure_page "教育" "education"        >/dev/null
ensure_page "スポーツ" "sports"        >/dev/null
ensure_page "ビジネス" "business"      >/dev/null
ensure_page "アプリ開発" "appdev"      >/dev/null
ensure_page "About Us" "about"        >/dev/null
ensure_page "お問い合わせ" "contact"  >/dev/null

echo "==> フロントページ/投稿ページ設定"
$WP option update show_on_front page
$WP option update page_on_front "$HOME_ID"
$WP option update page_for_posts "$BLOG_ID"

echo "==> パーマリンクを /%postname%/ に設定"
$WP rewrite structure '/%postname%/' --hard
$WP rewrite flush --hard

echo "==> ブログ用カテゴリを作成（教育/スポーツ/ビジネス）"
for c in "教育" "スポーツ" "ビジネス"; do
  $WP term create category "$c" >/dev/null 2>&1 || true
done

echo "==> Contact Form 7 を導入"
$WP plugin install contact-form-7 --activate || echo "  ⚠ CF7 導入に失敗（手動で導入してください）"

# CF7 フォームが無ければ1つ作成し、送信先を CONTACT_EMAIL に設定。
CF7_EXISTING=$($WP post list --post_type=wpcf7_contact_form --field=ID --posts_per_page=1 2>/dev/null | head -n1 || true)
if [ -z "$CF7_EXISTING" ]; then
  echo "==> CF7 フォームを作成（送信先: $CONTACT_EMAIL）"
  CF7_FORM='<label>お名前
    [text* your-name placeholder "山田 太郎"]</label>

<label>メールアドレス
    [email* your-email placeholder "you@example.com"]</label>

<label>お問い合わせ種別
    [select your-subject "教育について" "スポーツについて" "ビジネス・アプリ開発について" "その他"]</label>

<label>お問い合わせ内容
    [textarea* your-message]</label>

[submit "送信する"]'

  CF7_ID=$($WP post create --post_type=wpcf7_contact_form --post_status=publish --post_title="お問い合わせ" --porcelain) || CF7_ID=""
  if [ -n "$CF7_ID" ]; then
    $WP post meta update "$CF7_ID" _form "$CF7_FORM" >/dev/null || true
    $WP post meta update "$CF7_ID" _mail '{"active":true,"subject":"[お問い合わせ] [your-subject]","sender":"[your-name] <wordpress@'"$(echo "$SITE_URL" | sed -E 's#https?://##')"'>","recipient":"'"$CONTACT_EMAIL"'","body":"差出人: [your-name] <[your-email]>\n種別: [your-subject]\n\n[your-message]","additional_headers":"Reply-To: [your-email]","attachments":"","use_html":false,"exclude_blank":false}' --format=json >/dev/null || echo "  ⚠ CF7 メール設定は管理画面で確認してください"
    echo "  CF7 フォーム作成 ID=$CF7_ID"
  fi
else
  echo "==> 既存の CF7 フォームを利用 (ID=$CF7_EXISTING)。送信先は管理画面で $CONTACT_EMAIL を確認"
fi

echo "==> サイトURLを $SITE_URL に統一（SSLはConoHa管理画面で有効化済みであること）"
$WP option update home "$SITE_URL"
$WP option update siteurl "$SITE_URL"

echo "==> 完了"
