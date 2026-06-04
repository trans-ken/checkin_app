<?php
/**
 * 汎用固定ページ（専用テンプレートを持たない固定ページ用フォールバック）
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<?php while ( have_posts() ) : the_post(); ?>
<section class="phead"><div class="wrap" style="max-width:880px;margin:0 auto"><div class="k2">// <?php echo esc_html( strtoupper( get_post_field( 'post_name' ) ) ); ?></div><h1><?php the_title(); ?></h1></div></section>
<section class="sec"><div class="wrap" style="max-width:880px;margin:0 auto">
  <div class="entry-content"><?php the_content(); ?></div>
</div></section>
<?php endwhile; ?>
<?php
get_footer();
