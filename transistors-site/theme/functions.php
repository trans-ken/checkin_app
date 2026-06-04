<?php
/**
 * transistors theme functions
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'transistors_setup' ) ) {
	function transistors_setup() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
		register_nav_menus( array(
			'primary' => 'グローバルメニュー',
		) );
	}
}
add_action( 'after_setup_theme', 'transistors_setup' );

/**
 * スタイル・スクリプトの読み込み。
 * styles.css がデザイントークン(:root変数)を定義し、site.css がそれを利用するため
 * 読み込み順を styles.css -> site.css に固定する。
 */
function transistors_assets() {
	$uri = get_template_directory_uri();
	$ver = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'transistors-tokens', $uri . '/assets/styles.css', array(), $ver );
	wp_enqueue_style( 'transistors-site', $uri . '/assets/site.css', array( 'transistors-tokens' ), $ver );
	wp_enqueue_style( 'transistors-theme', get_stylesheet_uri(), array( 'transistors-site' ), $ver );

	// Lucide アイコン（CDN）。読み込み後に createIcons() を実行。
	wp_enqueue_script( 'lucide', 'https://unpkg.com/lucide@latest', array(), null, true );
	wp_add_inline_script( 'lucide', 'window.addEventListener("load",function(){if(window.lucide){lucide.createIcons();}});' );
}
add_action( 'wp_enqueue_scripts', 'transistors_assets' );

/**
 * 投稿カテゴリ（教育/スポーツ/ビジネス 等）に応じたサムネイル用グラデーション。
 * 静的版のブログカードの見た目を踏襲する。
 */
function transistors_thumb_gradient( $cat_name = '' ) {
	$map = array(
		'教育'     => 'linear-gradient(135deg,var(--azure-100),var(--azure-300))',
		'スポーツ' => 'linear-gradient(135deg,var(--azure-200),var(--azure-400))',
		'ビジネス' => 'linear-gradient(135deg,var(--azure-50),var(--azure-200))',
	);
	if ( isset( $map[ $cat_name ] ) ) {
		return $map[ $cat_name ];
	}
	return 'linear-gradient(135deg,var(--azure-100),var(--azure-300))';
}

/**
 * 投稿の主カテゴリ名を返す（なければ空文字）。
 */
function transistors_primary_category( $post_id = null ) {
	$cats = get_the_category( $post_id );
	if ( ! empty( $cats ) ) {
		return $cats[0]->name;
	}
	return '';
}

/**
 * Contact Form 7 のショートコード（最初に見つかったフォーム）を返す。
 * フォーム未作成時は空文字。page-contact.php で静的フォームにフォールバックする。
 */
function transistors_cf7_shortcode() {
	if ( ! post_type_exists( 'wpcf7_contact_form' ) ) {
		return '';
	}
	$forms = get_posts( array(
		'post_type'      => 'wpcf7_contact_form',
		'posts_per_page' => 1,
		'orderby'        => 'date',
		'order'          => 'ASC',
	) );
	if ( empty( $forms ) ) {
		return '';
	}
	return '[contact-form-7 id="' . intval( $forms[0]->ID ) . '"]';
}
