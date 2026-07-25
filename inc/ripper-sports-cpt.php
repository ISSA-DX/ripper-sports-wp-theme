<?php
/**
 * Ripper Sports — Custom Post Types
 *
 * Registers the `match` CPT used by the live score ticker. The architecture
 * is designed so a future API integration (cron + remote provider) can
 * update match posts via `wp_update_post` + `update_post_meta` without
 * touching the front-end template.
 *
 * @package Ripper_Sports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the `match` Custom Post Type.
 *
 * Fields live as post meta (see inc/ripper-sports-meta.php):
 *   _rs_match_team_home, _rs_match_team_away
 *   _rs_match_score_home, _rs_match_score_away
 *   _rs_match_status (live|full-time|upcoming)
 *   _rs_match_clock, _rs_match_competition
 *   _rs_match_starts_at (datetime, ISO 8601)
 *   _rs_match_is_live (bool)
 */
function ripper_sports_register_match_cpt() {
	$labels = array(
		'name'                  => _x( 'Matches', 'post type general name', 'ripper-sports' ),
		'singular_name'         => _x( 'Match', 'post type singular name', 'ripper-sports' ),
		'menu_name'             => _x( 'Matches', 'admin menu', 'ripper-sports' ),
		'name_admin_bar'        => _x( 'Match', 'add new on admin bar', 'ripper-sports' ),
		'add_new'               => __( 'Add New', 'ripper-sports' ),
		'add_new_item'          => __( 'Add New Match', 'ripper-sports' ),
		'new_item'              => __( 'New Match', 'ripper-sports' ),
		'edit_item'             => __( 'Edit Match', 'ripper-sports' ),
		'view_item'             => __( 'View Match', 'ripper-sports' ),
		'all_items'             => __( 'All Matches', 'ripper-sports' ),
		'search_items'          => __( 'Search Matches', 'ripper-sports' ),
		'not_found'             => __( 'No matches found.', 'ripper-sports' ),
		'not_found_in_trash'    => __( 'No matches found in Trash.', 'ripper-sports' ),
		'featured_image'        => __( 'Match Cover', 'ripper-sports' ),
		'set_featured_image'    => __( 'Set match cover image', 'ripper-sports' ),
		'remove_featured_image' => __( 'Remove match cover image', 'ripper-sports' ),
		'use_featured_image'    => __( 'Use as match cover image', 'ripper-sports' ),
	);

	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'show_in_rest'        => true,           // Gutenberg + REST API.
		'rest_base'           => 'matches',
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-chart-line',
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
		'taxonomies'          => array( 'sport' ),
		'has_archive'         => true,
		'rewrite'             => array( 'slug' => 'match', 'with_front' => false ),
		'capability_type'     => 'post',
		'show_in_nav_menus'   => false,          // Matches are not top-level nav.
		'show_in_admin_bar'   => true,
	);

	register_post_type( 'match', $args );
}
add_action( 'init', 'ripper_sports_register_match_cpt' );
