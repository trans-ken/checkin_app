<?php
/**
 * 固定ページ「スポーツ」 /sports （静的版 sports.html を踏襲）
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$tpl = get_template_directory_uri();
?>
<section class="lphero navy"><div class="wrap lphero-grid"><div class="lpcontent">
  <div class="eyebrow">// SPORTS BUSINESS CONSULTING</div><h1>スポーツの価値を、<br>事業に変える。</h1><p class="lead">競技団体・クラブの運営から、育成、そして事業化まで。スポーツビジネスのコンサルティングで、現場の挑戦を伴走支援します。</p>
  <div class="stats"><div><div class="v">運営</div><div class="l">体制づくり</div></div><div><div class="v">育成</div><div class="l">人材開発</div></div><div><div class="v">事業化</div><div class="l">収益基盤</div></div></div>
</div><img class="lpimg" src="<?php echo esc_url( $tpl . '/assets/illust/sports.png' ); ?>" alt=""></div></section>
<section class="sec"><div class="wrap">
  <div class="k2" style="color:var(--navy-700)">// WHAT WE OFFER</div><h2 class="t" style="margin-bottom:40px">スポーツ領域の支援メニュー</h2>
  <div class="grid2"><div class="feat"><div class="fi" style="background:rgba(5,44,73,.07);color:var(--navy-700)"><i data-lucide="trophy"></i></div><div><h3>クラブ・団体運営支援</h3><p>組織づくりと運営体制の整備を、戦略から支援します。</p></div></div><div class="feat"><div class="fi" style="background:rgba(5,44,73,.07);color:var(--navy-700)"><i data-lucide="line-chart"></i></div><div><h3>事業化・収益化</h3><p>スポンサー・チケット・データ活用で収益基盤を構築。</p></div></div><div class="feat"><div class="fi" style="background:rgba(5,44,73,.07);color:var(--navy-700)"><i data-lucide="users"></i></div><div><h3>育成・人材開発</h3><p>選手・指導者・スタッフの育成プログラムを設計します。</p></div></div><div class="feat"><div class="fi" style="background:rgba(5,44,73,.07);color:var(--navy-700)"><i data-lucide="activity"></i></div><div><h3>データ・AI活用・アプリ開発</h3><p>試合・練習などのデータ分析やAI活用、アプリ開発で、現場での意思決定を支えます。</p></div></div></div>
</div></section>
<section style="padding:0 0 80px"><div class="wrap"><div class="lpcta" style="background:rgba(5,44,73,.07)"><h2>スポーツを、いっしょにスイッチしませんか。</h2><p>ご相談・お見積もりは無料です。お気軽にお問い合わせください。</p><a class="btn btn-lg" style="background:var(--navy-800);color:#fff" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">スポーツ事業を相談する</a></div></div></section>
<?php
get_footer();
