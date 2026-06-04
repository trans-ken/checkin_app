<?php
/**
 * 全ページ共通ヘッダー（静的版 site.css の .topbar / nav.main を踏襲）
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$tpl = get_template_directory_uri();
$is_service = is_page( array( 'education', 'sports', 'business', 'appdev' ) );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="<?php echo esc_url( $tpl . '/assets/transistors-badge.svg' ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header>
  <div class="topbar"></div>
  <nav class="main">
    <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $tpl . '/assets/transistors-mark.svg' ); ?>" alt=""><b>transistors</b></a>
    <div class="has-menu hidem"><a class="lnk<?php echo $is_service ? ' on' : ''; ?>" href="<?php echo esc_url( home_url( '/#services' ) ); ?>">事業内容 ▾</a>
      <div class="menu">
        <a href="<?php echo esc_url( home_url( '/education/' ) ); ?>"><span class="dot" style="background:var(--azure-500)"></span><span class="mn">教育</span><span class="mp">/education</span></a>
        <a href="<?php echo esc_url( home_url( '/sports/' ) ); ?>"><span class="dot" style="background:var(--navy-800)"></span><span class="mn">スポーツ</span><span class="mp">/sports</span></a>
        <a href="<?php echo esc_url( home_url( '/business/' ) ); ?>"><span class="dot" style="background:var(--navy-800)"></span><span class="mn">ビジネス</span><span class="mp">/business</span></a>
        <a href="<?php echo esc_url( home_url( '/appdev/' ) ); ?>"><span class="dot" style="background:var(--navy-800)"></span><span class="mn">アプリ開発</span><span class="mp">/appdev</span></a>
      </div>
    </div>
    <a class="lnk hidem<?php echo is_page( 'about' ) ? ' on' : ''; ?>" href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About Us</a>
    <a class="lnk hidem<?php echo ( is_home() || is_singular( 'post' ) || is_category() ) ? ' on' : ''; ?>" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Blog</a>
    <a class="btn btn-pri" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">お問い合わせ</a>
  </nav>
</header>
