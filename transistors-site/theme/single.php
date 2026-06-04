<?php
/**
 * 個別投稿（ブログ記事）
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<?php while ( have_posts() ) : the_post(); $cat = transistors_primary_category(); ?>
<article>
  <section class="phead"><div class="wrap" style="max-width:880px;margin:0 auto">
    <div class="k2"><?php echo $cat ? '// ' . esc_html( $cat ) : '// BLOG'; ?></div>
    <h1><?php the_title(); ?></h1>
    <p style="font-family:var(--font-mono);font-size:13px;color:var(--color-fg-subtle)"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></p>
  </div></section>
  <section class="sec"><div class="wrap" style="max-width:880px;margin:0 auto">
    <?php if ( has_post_thumbnail() ) : ?>
      <div style="margin-bottom:32px"><?php the_post_thumbnail( 'large', array( 'style' => 'width:100%;height:auto;border-radius:18px;display:block' ) ); ?></div>
    <?php endif; ?>
    <div class="entry-content"><?php the_content(); ?></div>
    <p style="margin-top:48px"><a class="btn btn-out" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">← 記事一覧へ</a></p>
  </div></section>
</article>
<?php endwhile; ?>
<?php
get_footer();
