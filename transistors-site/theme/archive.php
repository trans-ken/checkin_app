<?php
/**
 * アーカイブ（カテゴリ・タグ・日付など）。ブログ一覧と同じカードグリッドで表示。
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>
<section class="phead"><div class="wrap"><div class="k2">// BLOG</div><h1><?php echo esc_html( wp_strip_all_tags( get_the_archive_title() ) ); ?></h1><?php the_archive_description( '<p>', '</p>' ); ?></div></section>
<section class="sec"><div class="wrap"><div class="grid3">
  <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
      <?php
      $cat   = transistors_primary_category();
      $thumb = has_post_thumbnail()
        ? 'background-image:url(' . esc_url( get_the_post_thumbnail_url( null, 'medium_large' ) ) . ');background-size:cover;background-position:center'
        : 'background:' . transistors_thumb_gradient( $cat );
      ?>
      <a class="card" href="<?php the_permalink(); ?>" style="padding:0;overflow:hidden"><div class="thumb" style="<?php echo esc_attr( $thumb ); ?>"><?php if ( $cat ) : ?><span class="cat"><?php echo esc_html( $cat ); ?></span><?php endif; ?></div><div class="pad"><div class="d"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></div><h3><?php the_title(); ?></h3></div></a>
    <?php endwhile; ?>
  <?php else : ?>
    <p style="color:var(--color-fg-muted)">該当する記事がありません。</p>
  <?php endif; ?>
</div>
<?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '←', 'next_text' => '→', 'class' => 'pagination' ) ); ?>
</div></section>
<?php
get_footer();
