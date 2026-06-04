<?php
/**
 * 固定ページ「お問い合わせ」 /contact （静的版 contact.html を踏襲）
 * Contact Form 7 が有効でフォームが存在すればそれを表示。
 * 無ければ静的フォーム（デモ）にフォールバックする。
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$cf7 = transistors_cf7_shortcode();
?>
<section class="phead"><div class="wrap"><div class="k2">// CONTACT</div><h1>お問い合わせ</h1><p>ご質問・ご相談はこちらのフォームから承ります。担当者より折り返しご連絡いたします。</p></div></section>
<section class="sec"><div class="wrap">
<?php if ( $cf7 ) : ?>
  <div class="form">
    <?php echo do_shortcode( $cf7 ); ?>
  </div>
<?php else : ?>
  <form class="form" onsubmit="this.style.display='none';document.getElementById('sent').style.display='block';return false;">
    <div class="field two">
      <div><label>お名前</label><input type="text" name="お名前" placeholder="山田 太郎" required></div>
      <div><label>メールアドレス</label><input type="email" name="メールアドレス" placeholder="you@example.com" required></div>
    </div>
    <div class="field"><label>お問い合わせ種別</label><select name="種別"><option>教育について</option><option>スポーツについて</option><option>ビジネス・アプリ開発について</option><option>その他</option></select></div>
    <div class="field"><label>お問い合わせ内容</label><textarea name="内容" rows="6" required></textarea></div>
    <button class="btn btn-pri btn-lg" type="submit" style="width:100%">送信する</button>
    <p style="font-size:12.5px;color:var(--color-fg-subtle);text-align:center;margin:0">※ これはデモ表示です。Contact Form 7 を有効化しフォームを作成すると、自動でこの欄が本番フォームに切り替わり、<code>info@transistors.co.jp</code> 宛に送信されます。</p>
  </form>
  <div id="sent" style="display:none;text-align:center;padding:40px;background:var(--azure-50);border:1px solid var(--azure-200);border-radius:18px;margin-top:20px"><h3 style="font-family:var(--font-display);color:var(--navy-800);margin:0 0 8px">送信しました</h3><p style="color:var(--color-fg-muted);margin:0">お問い合わせありがとうございます。担当者より折り返しご連絡いたします。</p></div>
<?php endif; ?>
</div></section>
<?php
get_footer();
