<?php
/**
 * 固定ページ「教育」 /education （静的版 education.html を踏襲）
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$tpl = get_template_directory_uri();
?>
<section class="lphero azure"><div class="wrap lphero-grid"><div class="lpcontent">
  <div class="eyebrow">// ICT · STEAM · PBL</div><h1>子どもの「問い」を、<br>未来の力に。</h1><p class="lead">ICT・STEAM教育の推進から、PBLを中心としたカリキュラム設計、教員研修・授業支援まで。複雑な社会課題に向き合う資質能力を育てます。</p>
  <div class="stats"><div><div class="v">STEAM</div><div class="l">探究型学習</div></div><div><div class="v">PBL</div><div class="l">一貫設計</div></div><div><div class="v">伴走</div><div class="l">研修・授業支援</div></div></div>
</div><img class="lpimg" src="<?php echo esc_url( $tpl . '/assets/illust/education.png' ); ?>" alt=""></div></section>
<section class="sec"><div class="wrap">
  <div class="k2" style="color:var(--azure-600)">// WHAT WE OFFER</div><h2 class="t" style="margin-bottom:40px">教育領域の支援メニュー</h2>
  <div class="grid2"><div class="feat"><div class="fi" style="background:var(--azure-50);color:var(--azure-600)"><i data-lucide="flask-conical"></i></div><div><h3>STEAM教育の推進</h3><p>教科横断の探究学習を、現場に合わせて設計・導入します。</p></div></div><div class="feat"><div class="fi" style="background:var(--azure-50);color:var(--azure-600)"><i data-lucide="lightbulb"></i></div><div><h3>PBLカリキュラム設計</h3><p>問いから評価まで一貫した、プロジェクト型学習をデザイン。</p></div></div><div class="feat"><div class="fi" style="background:var(--azure-50);color:var(--azure-600)"><i data-lucide="users"></i></div><div><h3>教員研修・授業支援</h3><p>指導・評価の手法を、伴走しながら定着させます。</p></div></div><div class="feat"><div class="fi" style="background:var(--azure-50);color:var(--azure-600)"><i data-lucide="bar-chart-3"></i></div><div><h3>情報活用能力の育成</h3><p>ICTを活用し、子どもたちの情報リテラシーを高めます。</p></div></div></div>
</div></section>
<section style="padding:0 0 80px"><div class="wrap"><div class="lpcta" style="background:var(--azure-50)"><h2>教育を、いっしょにスイッチしませんか。</h2><p>ご相談・お見積もりは無料です。お気軽にお問い合わせください。</p><a class="btn btn-lg" style="background:var(--azure-500);color:#fff" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">教育支援について相談する</a></div></div></section>
<?php
get_footer();
