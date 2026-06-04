<?php
/**
 * 全ページ共通フッター（静的版 site.css の footer .top / .bar を踏襲）
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$tpl = get_template_directory_uri();
?>
<footer>
  <div class="top"><div class="wrap cols">
    <div class="brandcol"><div class="bl"><img src="<?php echo esc_url( $tpl . '/assets/transistors-mark-white.svg' ); ?>" alt=""><b>transistors</b></div>
      <p>教育・スポーツ・ビジネスをスイッチする。プロフェッショナルが集うトランジスターズ。</p></div>
    <div class="fcol"><h4>事業内容</h4><a href="<?php echo esc_url( home_url( '/education/' ) ); ?>">教育</a><a href="<?php echo esc_url( home_url( '/sports/' ) ); ?>">スポーツ</a><a href="<?php echo esc_url( home_url( '/business/' ) ); ?>">ビジネス</a><a href="<?php echo esc_url( home_url( '/appdev/' ) ); ?>">アプリ開発</a></div>
    <div class="fcol"><h4>会社</h4><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About Us</a><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Blog</a><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">お問い合わせ</a></div>
  </div></div>
  <div class="bar"><div class="wrap">© transistors Co., Ltd.</div></div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
