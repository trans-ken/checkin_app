<?php
/**
 * 固定ページ「ビジネス」 /business （静的版 business.html を踏襲）
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$tpl = get_template_directory_uri();
?>
<section class="lphero navy"><div class="wrap lphero-grid"><div class="lpcontent">
  <div class="eyebrow">// CONSULTING · TRAINING</div><h1>課題解決を、<br>スイッチする。</h1><p class="lead">コンサルティングと研修で、企業の課題解決と人材育成を支援します。DX推進からプロジェクトマネジメントまで、現場に伴走します。</p>
  <div class="stats"><div><div class="v">DX</div><div class="l">推進支援</div></div><div><div class="v">研修</div><div class="l">人材開発</div></div><div><div class="v">PM</div><div class="l">伴走支援</div></div></div>
</div><img class="lpimg" src="<?php echo esc_url( $tpl . '/assets/illust/business.png' ); ?>" alt=""></div></section>
<section class="sec"><div class="wrap">
  <div class="k2" style="color:var(--navy-700)">// WHAT WE OFFER</div><h2 class="t" style="margin-bottom:40px">ビジネス領域の支援メニュー</h2>
  <div class="grid2"><div class="feat"><div class="fi" style="background:rgba(5,44,73,.07);color:var(--navy-700)"><i data-lucide="trending-up"></i></div><div><h3>コンサルティング</h3><p>DXやプロジェクトマネジメントを、現場目線で伴走支援。</p></div></div><div class="feat"><div class="fi" style="background:rgba(5,44,73,.07);color:var(--navy-700)"><i data-lucide="graduation-cap"></i></div><div><h3>研修・人材開発</h3><p>課題解決とリーダーシップを育む実践的な研修を提供。</p></div></div><div class="feat"><div class="fi" style="background:rgba(5,44,73,.07);color:var(--navy-700)"><i data-lucide="workflow"></i></div><div><h3>プロジェクトマネジメント</h3><p>計画から実行まで、プロジェクトの推進を伴走支援します。</p></div></div><div class="feat"><div class="fi" style="background:rgba(5,44,73,.07);color:var(--navy-700)"><i data-lucide="users"></i></div><div><h3>組織・人材開発</h3><p>チームの力を引き出す研修と、組織づくりを支援します。</p></div></div></div>
</div></section>
<section style="padding:0 0 80px"><div class="wrap"><div class="lpcta" style="background:rgba(5,44,73,.07)"><h2>ビジネスを、いっしょにスイッチしませんか。</h2><p>ご相談・お見積もりは無料です。お気軽にお問い合わせください。</p><a class="btn btn-lg" style="background:var(--navy-800);color:#fff" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">ビジネス支援を相談する</a></div></div></section>
<?php
get_footer();
