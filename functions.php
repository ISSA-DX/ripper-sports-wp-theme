<?php
/**
 * Ripper Sports Theme Functions
 *
 * @package Ripper_Sports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme version for cache busting.
 */
define( 'RIPPER_SPORTS_VERSION', '1.4.8' );

/**
 * Load theme-specific infrastructure (CPT, meta, helpers, shortcodes).
 */
require_once get_template_directory() . '/inc/ripper-sports-cpt.php';
require_once get_template_directory() . '/inc/ripper-sports-meta.php';
require_once get_template_directory() . '/inc/ripper-sports-helpers.php';
require_once get_template_directory() . '/inc/ripper-sports-shortcodes.php';

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function ripper_sports_setup() {
	load_theme_textdomain( 'ripper-sports', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' )
	);
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Featured image sizes.
	set_post_thumbnail_size( 800, 600, true );
	add_image_size( 'ripper-card', 800, 600, true );
	add_image_size( 'ripper-hero', 1600, 900, true );
	add_image_size( 'ripper-large', 1200, 675, true );

	// Navigation menus.
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'ripper-sports' ),
			'mobile'  => __( 'Mobile Menu', 'ripper-sports' ),
			'footer'  => __( 'Footer Links', 'ripper-sports' ),
		)
	);

	// Widget sidebar.
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'ripper-sports' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in article sidebars.', 'ripper-sports' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'after_setup_theme', 'ripper_sports_setup' );

/**
 * Enqueue scripts and styles.
 */
function ripper_sports_scripts() {
	// Google Fonts used by the design system.
	wp_enqueue_style(
		'ripper-sports-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=JetBrains+Mono:wght@700&family=Oswald:wght@600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'ripper-sports-style',
		get_template_directory_uri() . '/assets/css/style.css',
		array(),
		RIPPER_SPORTS_VERSION
	);

	wp_enqueue_style(
		'ripper-sports-utilities',
		get_template_directory_uri() . '/assets/css/utilities.css',
		array( 'ripper-sports-style' ),
		RIPPER_SPORTS_VERSION
	);

	wp_enqueue_script(
		'ripper-sports-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		RIPPER_SPORTS_VERSION,
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Pass dynamic data to JS.
	wp_localize_script(
		'ripper-sports-main',
		'ripperSportsData',
		array(
			'themeUri' => get_template_directory_uri(),
			'homeUrl'  => home_url(),
			'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
			'restUrl'  => esc_url_raw( rest_url() ),
			'nonce'    => wp_create_nonce( 'ripper_sports_ajax' ),
			'reactionNonce' => wp_create_nonce( 'ripper_sports_reaction' ),
			'isLoggedIn'    => is_user_logged_in(),
			'bodyClasses'   => get_body_class(),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'ripper_sports_scripts' );

/**
 * Newsletter subscription handler.
 */
function ripper_sports_newsletter_handler() {
	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

	if ( ! $email || ! is_email( $email ) ) {
		wp_send_json_error( __( 'Please enter a valid email address.', 'ripper-sports' ) );
	}

	// In production this should connect to a provider or create a subscriber post type.
	$subscribers = get_option( 'ripper_sports_newsletter_subscribers', array() );
	if ( ! in_array( $email, $subscribers, true ) ) {
		$subscribers[] = $email;
		update_option( 'ripper_sports_newsletter_subscribers', $subscribers, false );
	}

	wp_send_json_success( __( 'You\'re on the team. Welcome aboard!', 'ripper-sports' ) );
}
add_action( 'wp_ajax_ripper_sports_newsletter', 'ripper_sports_newsletter_handler' );
add_action( 'wp_ajax_nopriv_ripper_sports_newsletter', 'ripper_sports_newsletter_handler' );

/**
 * Contact form handler.
 */
function ripper_sports_contact_handler() {
	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$subject = isset( $_POST['subject'] ) ? sanitize_text_field( wp_unslash( $_POST['subject'] ) ) : '';
	$topic   = isset( $_POST['topic'] ) ? sanitize_text_field( wp_unslash( $_POST['topic'] ) ) : '';
	if ( ! $subject && $topic ) {
		$subject = ucfirst( $topic );
	}
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( ! $name || ! $email || ! $message ) {
		wp_send_json_error( __( 'Please fill in all required fields.', 'ripper-sports' ) );
	}

	if ( ! is_email( $email ) ) {
		wp_send_json_error( __( 'Please enter a valid email address.', 'ripper-sports' ) );
	}

	$to      = get_option( 'admin_email' );
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );
	$body    = "Name: $name\nEmail: $email\nSubject: $subject\n\n$message";

	wp_mail( $to, __( 'Ripper Sports Contact Form', 'ripper-sports' ), $body, $headers );

	wp_send_json_success( __( 'Message sent. We\'ll be in touch soon.', 'ripper-sports' ) );
}
add_action( 'wp_ajax_ripper_sports_contact', 'ripper_sports_contact_handler' );
add_action( 'wp_ajax_nopriv_ripper_sports_contact', 'ripper_sports_contact_handler' );

/**
 * Card reaction handler.
 *
 * Accepts a post ID and reaction type (like, comment, share) and
 * increments the corresponding post meta counter. Returns the new
 * count so the front-end can update without a refresh.
 *
 * Uses a transient-based per-user rate limit so a single browser
 * can't double-click to inflate the count. Reactions are also
 * anonymous-friendly: we don't require login to count them, just to
 * prevent double-counts from the same browser session.
 */
function ripper_sports_reaction_handler() {
	// Verify nonce.
	$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'ripper_sports_reaction' ) ) {
		wp_send_json_error( __( 'Security check failed. Please refresh and try again.', 'ripper-sports' ), 403 );
	}

	$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
	$type    = isset( $_POST['type'] ) ? sanitize_key( wp_unslash( $_POST['type'] ) ) : '';

	if ( ! $post_id || ! get_post( $post_id ) ) {
		wp_send_json_error( __( 'Invalid post.', 'ripper-sports' ), 400 );
	}

	// Whitelist reaction types.
	$allowed_types = array( 'like', 'share', 'comment' );
	if ( ! in_array( $type, $allowed_types, true ) ) {
		wp_send_json_error( __( 'Invalid reaction type.', 'ripper-sports' ), 400 );
	}

	// Per-session rate limit: a single browser can't double-count.
	// Key by session token if present, otherwise by IP + post + type.
	$rate_key = 'rs_react_' . md5( $type . '|' . $post_id . '|' . ( isset( $_COOKIE['rs_rid'] ) ? $_COOKIE['rs_rid'] : ( $_SERVER['REMOTE_ADDR'] ?? '' ) ) );
	if ( get_transient( $rate_key ) ) {
		wp_send_json_error( __( 'You already reacted to this.', 'ripper-sports' ), 429 );
	}
	set_transient( $rate_key, 1, 12 * HOUR_IN_SECONDS );

	// Increment the corresponding meta key.
	$meta_key = '_rs_' . $type . '_count';
	$current  = (int) get_post_meta( $post_id, $meta_key, true );
	$new      = $current + 1;
	update_post_meta( $post_id, $meta_key, $new );

	wp_send_json_success(
		array(
			'type'  => $type,
			'count' => $new,
		)
	);
}
add_action( 'wp_ajax_ripper_sports_reaction', 'ripper_sports_reaction_handler' );
add_action( 'wp_ajax_nopriv_ripper_sports_reaction', 'ripper_sports_reaction_handler' );

/**
 * Estimate reading time for the current post.
 *
 * @return string Reading time label.
 */
function ripper_sports_reading_time() {
	$content = get_post_field( 'post_content', get_the_ID() );
	$words   = str_word_count( wp_strip_all_tags( $content ) );
	$minutes = max( 1, ceil( $words / 200 ) );
	/* translators: %d: reading time in minutes */
	return sprintf( _n( '%d min read', '%d min read', $minutes, 'ripper-sports' ), $minutes );
}

/**
 * Fetch posts for a given sport taxonomy slug.
 *
 * @param string $sport_slug Sport taxonomy slug.
 * @param int    $count      Number of posts to fetch.
 * @return WP_Query
 */
function ripper_sports_get_sport_posts( $sport_slug, $count = 3 ) {
	return new WP_Query(
		array(
			'posts_per_page'      => $count,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'tax_query'           => array(
				array(
					'taxonomy' => 'sport',
					'field'    => 'slug',
					'terms'    => $sport_slug,
				),
			),
		)
	);
}

/**
 * Register sports taxonomy.
 */
function ripper_sports_register_taxonomies() {
	$labels = array(
		'name'          => __( 'Sports', 'ripper-sports' ),
		'singular_name' => __( 'Sport', 'ripper-sports' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'sport' ),
	);

	register_taxonomy( 'sport', array( 'post' ), $args );
}
add_action( 'init', 'ripper_sports_register_taxonomies', 0 );
