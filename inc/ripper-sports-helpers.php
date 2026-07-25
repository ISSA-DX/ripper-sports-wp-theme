<?php
/**
 * Ripper Sports — Query Helpers
 *
 * Centralizes every WP_Query used by the front-end so templates stay
 * declarative. Wraps the existing `ripper_sports_get_sport_posts()`
 * from functions.php and adds the new curated queries (breaking,
 * featured, editor's picks, active matches).
 *
 * @package Ripper_Sports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get the active breaking post.
 *
 * Returns the single post that is marked as breaking with the lowest
 * priority number (most important). Falls back to a sticky post or
 * the most recent post if no curated breaking post is set.
 *
 * @return WP_Post|null
 */
function ripper_sports_get_breaking_post() {
	$query = new WP_Query(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'no_found_rows'  => true,
			'meta_query'     => array(
				array(
					'key'     => '_rs_is_breaking',
					'value'   => '1',
					'compare' => '=',
				),
			),
			'orderby'        => array(
				'meta_value_num' => 'ASC',
				'date'           => 'DESC',
			),
		)
	);

	if ( $query->have_posts() ) {
		return $query->posts[0];
	}
	wp_reset_postdata();

	// Fallback: most recent post.
	$fallback = new WP_Query(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'no_found_rows'  => true,
		)
	);
	if ( $fallback->have_posts() ) {
		return $fallback->posts[0];
	}
	wp_reset_postdata();

	return null;
}

/**
 * Get the post featured on the front page hero.
 *
 * Prefers posts marked `_rs_feature_on_front=1`, falls back to the
 * latest published post.
 *
 * @return WP_Post|null
 */
function ripper_sports_get_featured_post() {
	$query = new WP_Query(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'no_found_rows'  => true,
			'meta_query'     => array(
				array(
					'key'     => '_rs_feature_on_front',
					'value'   => '1',
					'compare' => '=',
				),
			),
		)
	);

	if ( $query->have_posts() ) {
		return $query->posts[0];
	}
	wp_reset_postdata();

	$fallback = new WP_Query(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'no_found_rows'  => true,
		)
	);
	if ( $fallback->have_posts() ) {
		return $fallback->posts[0];
	}
	wp_reset_postdata();

	return null;
}

/**
 * Get curated editor's picks.
 *
 * @param int $n Number of picks to return.
 * @return WP_Post[]
 */
function ripper_sports_get_editor_picks( $n = 3 ) {
	$query = new WP_Query(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => $n,
			'no_found_rows'  => true,
			'meta_query'     => array(
				array(
					'key'     => '_rs_editor_pick',
					'value'   => '1',
					'compare' => '=',
				),
			),
			'orderby'        => array(
				'meta_value_num' => 'ASC',
				'date'           => 'DESC',
			),
		)
	);

	$posts = $query->have_posts() ? $query->posts : array();
	wp_reset_postdata();

	// If not enough curated picks, top up with latest posts.
	if ( count( $posts ) < $n ) {
		$existing_ids = wp_list_pluck( $posts, 'ID' );
		$top_up       = new WP_Query(
			array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => $n - count( $posts ),
				'no_found_rows'  => true,
				'post__not_in'   => $existing_ids,
			)
		);
		if ( $top_up->have_posts() ) {
			$posts = array_merge( $posts, $top_up->posts );
		}
		wp_reset_postdata();
	}

	return $posts;
}

/**
 * Get the active matches for the live score ticker.
 *
 * Returns live matches first, then upcoming matches (ordered by
 * `_rs_match_starts_at` ascending). Falls back to the most recent
 * 4 matches if nothing is marked as live or upcoming.
 *
 * @param int $n Maximum number of matches.
 * @return WP_Post[]
 */
function ripper_sports_get_active_matches( $n = 4 ) {
	$live = new WP_Query(
		array(
			'post_type'      => 'match',
			'post_status'    => 'publish',
			'posts_per_page' => $n,
			'no_found_rows'  => true,
			'meta_query'     => array(
				array(
					'key'     => '_rs_match_is_live',
					'value'   => '1',
					'compare' => '=',
				),
			),
		)
	);

	$matches = $live->have_posts() ? $live->posts : array();
	wp_reset_postdata();

	if ( count( $matches ) < $n ) {
		$existing = wp_list_pluck( $matches, 'ID' );
		$top_up   = new WP_Query(
			array(
				'post_type'      => 'match',
				'post_status'    => 'publish',
				'posts_per_page' => $n - count( $matches ),
				'no_found_rows'  => true,
				'post__not_in'   => $existing,
			)
		);
		if ( $top_up->have_posts() ) {
			$matches = array_merge( $matches, $top_up->posts );
		}
		wp_reset_postdata();
	}

	return $matches;
}

/**
 * Render a homepage sport section (AFL / NRL / Cricket / etc.) using the
 * shared `.section-title-accent` + `.three-column-layout` markup.
 *
 * Pulls the latest `$count` posts from the `sport` taxonomy term whose
 * slug matches `$slug`. Outputs a section header with an optional
 * "View All" link to the term archive.
 *
 * @param string $slug           Sport taxonomy term slug (e.g. 'afl').
 * @param string $title          Section title (e.g. 'AFL: The Footy Report').
 * @param string $view_all_label Label for the "View All" link (default 'View All').
 * @param string $accent_color   CSS color value for the title's left border.
 * @param int    $count          Number of posts to show.
 */
function ripper_sports_render_sport_section( $slug, $title, $view_all_label = '', $accent_color = '', $count = 3 ) {
	$term = get_term_by( 'slug', $slug, 'sport' );
	if ( ! $term ) {
		return;
	}

	$posts = ripper_sports_get_sport_posts( $slug, $count );
	if ( ! $posts->have_posts() ) {
		wp_reset_postdata();
		return;
	}

	$view_all_label = $view_all_label ? $view_all_label : __( 'View All', 'ripper-sports' );
	$style_attr     = $accent_color ? ' style="border-left-color: ' . esc_attr( $accent_color ) . ';"' : '';
	$view_all_url   = get_term_link( $term );
	?>
	<section class="section">
		<div class="container">
			<?php if ( $view_all_url && ! is_wp_error( $view_all_url ) ) : ?>
				<div class="section-header">
					<h2 class="section-title section-title-accent mb-8"<?php echo $style_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $title ); ?></h2>
					<a href="<?php echo esc_url( $view_all_url ); ?>" class="section-link"><?php echo esc_html( $view_all_label ); ?> &rarr;</a>
				</div>
			<?php else : ?>
				<h2 class="section-title section-title-accent mb-8"<?php echo $style_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>

			<div class="three-column-layout">
				<?php
				while ( $posts->have_posts() ) :
					$posts->the_post();
					get_template_part( 'template-parts/content', 'card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Render breadcrumbs.
 *
 * Outputs the breadcrumb trail for the current view. Uses a static
 * fallback if Yoast / Rank Math is not installed. Renders as
 * `<nav class="breadcrumb" aria-label="Breadcrumb">` with `<ol>`
 * semantics. Reusable by every non-front-page template.
 */
function ripper_sports_breadcrumb() {
	if ( is_front_page() ) {
		return;
	}

	// Prefer Yoast breadcrumbs if available.
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<nav class="breadcrumb" aria-label="Breadcrumb">', '</nav>' );
		return;
	}

	$items   = array();
	$items[] = array(
		'url'   => home_url( '/' ),
		'label' => __( 'Home', 'ripper-sports' ),
	);

	if ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		if ( $term && ! is_wp_error( $term ) ) {
			$items[] = array(
				'url'   => '',
				'label' => single_term_title( '', false ),
			);
		}
	} elseif ( is_singular( 'post' ) ) {
		$post_id  = get_queried_object_id();
		$sports   = get_the_terms( $post_id, 'sport' );
		if ( ! empty( $sports ) && ! is_wp_error( $sports ) ) {
			$items[] = array(
				'url'   => get_term_link( $sports[0] ),
				'label' => $sports[0]->name,
			);
		}
		$items[] = array(
			'url'   => '',
			'label' => get_the_title( $post_id ),
		);
	} elseif ( is_page() ) {
		$items[] = array(
			'url'   => '',
			'label' => get_the_title(),
		);
	} elseif ( is_search() ) {
		$items[] = array(
			'url'   => '',
			'label' => sprintf( /* translators: %s: search query */ __( 'Search: %s', 'ripper-sports' ), get_search_query() ),
		);
	} elseif ( is_author() ) {
		$items[] = array(
			'url'   => '',
			'label' => get_the_author(),
		);
	} elseif ( is_404() ) {
		$items[] = array(
			'url'   => '',
			'label' => __( 'Page not found', 'ripper-sports' ),
		);
	}

	echo '<nav class="breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'ripper-sports' ) . '">';
	echo '<ol class="breadcrumb-list">';
	foreach ( $items as $i => $item ) {
		$is_last = ( $i === count( $items ) - 1 );
		echo '<li class="breadcrumb-item">';
		if ( ! empty( $item['url'] ) && ! $is_last ) {
			echo '<a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['label'] ) . '</a>';
		} else {
			echo '<span aria-current="page">' . esc_html( $item['label'] ) . '</span>';
		}
		echo '</li>';
		if ( ! $is_last ) {
			echo '<li class="breadcrumb-separator" aria-hidden="true">/</li>';
		}
	}
	echo '</ol>';
	echo '</nav>';
}
