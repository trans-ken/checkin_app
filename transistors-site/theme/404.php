<?php
/**
 * 404 ページ
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<section class="phead"><div class="wrap"><div class="k2">// 404</div><h1>ページが見つかりません</h1><p>お探しのページは移動または削除された可能性があります。</p></div></section>
<section class="sec"><div class="wrap"><p><a class="btn btn-pri btn-lg" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップへ戻る</a></p></div></section>
<?php
get_footer();
