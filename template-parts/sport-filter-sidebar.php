<?php
/**
 * Sport Filter Sidebar
 *
 * Chip-based filter used on the sport archive (`taxonomy-sport.php`).
 * Three groups, single-select within each, instant client-side filtering
 * via `initArchiveFilters()` in main.js.
 *
 * Data source: existing WP Categories + post Tags (auto-computed from
 * posts in the current sport's archive).
 *
 * @package Ripper_Sports
 */

$queried = get_queried_object();
$term_id = ( $queried && ! is_wp_error( $queried ) && isset( $queried->term_id ) ) ? (int) $queried->term_id : 0;
$term_name = ( $queried && ! is_wp_error( $queried ) && isset( $queried->name ) ) ? $queried->name : __( 'Sport', 'ripper-sports' );

/* ────── Pull the post IDs in this sport's archive ──────
   Used to compute the top categories + tags the user can filter by. */
$archive_post_ids = array();
if ( $term_id ) {
	$archive_post_ids = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 200,           // bound the scan; sports rarely exceed this
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'tax_query'      => array(
				array(
					'taxonomy' => 'sport',
					'field'    => 'term_id',
					'terms'    => $term_id,
				),
			),
		)
	);
}

/* ────── Tally categories ──────
   Top 5 categories, ordered by usage. Empty if no posts or no categories. */
$used_cats = array();
if ( ! empty( $archive_post_ids ) ) {
	$cat_terms = wp_get_object_terms(
		$archive_post_ids,
		'category',
		array( 'orderby' => 'count', 'order' => 'DESC' )
	);
	if ( ! is_wp_error( $cat_terms ) ) {
		$used_cats = array_slice( $cat_terms, 0, 5 );
	}
}

/* ────── Tally tags ──────
   Top 8 tags. Same approach. */
$used_tags = array();
if ( ! empty( $archive_post_ids ) ) {
	$tag_terms = wp_get_object_terms(
		$archive_post_ids,
		'post_tag',
		array( 'orderby' => 'count', 'order' => 'DESC' )
	);
	if ( ! is_wp_error( $tag_terms ) ) {
		$used_tags = array_slice( $tag_terms, 0, 8 );
	}
}

$has_content_filters = ( ! empty( $used_cats ) || ! empty( $used_tags ) );
?>

<aside class="filter-sidebar sticky-sidebar" aria-label="<?php esc_attr_e( 'Filter stories', 'ripper-sports' ); ?>">
	<button type="button" class="filter-sidebar-toggle js-filter-sidebar-toggle" aria-expanded="false" aria-controls="sport-filter">
		<span>
			<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" style="vertical-align: -3px; margin-right: 6px;"><path d="M3 4h18v2H3V4zm3 7h12v2H6v-2zm4 7h4v2h-4v-2z"/></svg>
			<?php
			/* translators: %s: sport name */
			echo esc_html( sprintf( __( 'Filter %s Stories', 'ripper-sports' ), $term_name ) );
			?>
		</span>
	</button>
	<div class="widget filter-widget">
		<header class="filter-widget-header">
			<h3 class="filter-title"><?php
				/* translators: %s: sport name */
				echo esc_html( sprintf( __( 'Filter %s Stories', 'ripper-sports' ), $term_name ) );
			?></h3>
			<div class="filter-group-meta">
				<span class="filter-count js-visible-count" aria-live="polite" aria-atomic="true">
					<?php
					$initial_count = is_tax( 'sport' ) ? $GLOBALS['wp_query']->post_count : 0;
					/* translators: 1: visible count, 2: total count */
					echo esc_html( sprintf( _n( '%1$d of %2$d story', '%1$d of %2$d stories', $initial_count, 'ripper-sports' ), $initial_count, $initial_count ) );
					?>
				</span>
				<button type="button" class="filter-clear js-filter-clear" hidden>
					<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
					<?php esc_html_e( 'Clear all', 'ripper-sports' ); ?>
				</button>
			</div>
		</header>

		<form id="sport-filter" class="filter-form" onsubmit="return false;">
			<?php if ( ! empty( $used_cats ) ) : ?>
				<fieldset class="filter-group" data-filter-group="category">
					<legend class="filter-group-title"><?php esc_html_e( 'Category', 'ripper-sports' ); ?></legend>
					<div class="filter-chips">
						<button type="button" class="filter-chip is-active" data-filter-cat="" data-filter-group="category">
							<?php esc_html_e( 'All', 'ripper-sports' ); ?>
						</button>
						<?php foreach ( $used_cats as $cat ) : ?>
							<button type="button" class="filter-chip" data-filter-cat="<?php echo esc_attr( (string) $cat->term_id ); ?>" data-filter-group="category">
								<?php echo esc_html( $cat->name ); ?>
							</button>
						<?php endforeach; ?>
					</div>
				</fieldset>
			<?php endif; ?>

			<?php if ( ! empty( $used_tags ) ) : ?>
				<fieldset class="filter-group" data-filter-group="tag">
					<legend class="filter-group-title"><?php esc_html_e( 'Tags', 'ripper-sports' ); ?></legend>
					<div class="filter-chips">
						<button type="button" class="filter-chip is-active" data-filter-tag="" data-filter-group="tag">
							<?php esc_html_e( 'All', 'ripper-sports' ); ?>
						</button>
						<?php foreach ( $used_tags as $tag_term ) : ?>
							<button type="button" class="filter-chip" data-filter-tag="<?php echo esc_attr( $tag_term->slug ); ?>" data-filter-group="tag">
								<?php echo esc_html( $tag_term->name ); ?>
							</button>
						<?php endforeach; ?>
					</div>
				</fieldset>
			<?php endif; ?>

			<fieldset class="filter-group" data-filter-group="date">
				<legend class="filter-group-title"><?php esc_html_e( 'Date', 'ripper-sports' ); ?></legend>
				<div class="filter-chips">
					<button type="button" class="filter-chip is-active" data-filter-date="all" data-filter-group="date">
						<?php esc_html_e( 'All Time', 'ripper-sports' ); ?>
					</button>
					<button type="button" class="filter-chip" data-filter-date="week" data-filter-group="date">
						<?php esc_html_e( 'This Week', 'ripper-sports' ); ?>
					</button>
					<button type="button" class="filter-chip" data-filter-date="month" data-filter-group="date">
						<?php esc_html_e( 'This Month', 'ripper-sports' ); ?>
					</button>
					<button type="button" class="filter-chip" data-filter-date="season" data-filter-group="date">
						<?php esc_html_e( 'This Season', 'ripper-sports' ); ?>
					</button>
				</div>
			</fieldset>

			<?php if ( ! $has_content_filters ) : ?>
				<p class="filter-empty">
					<?php esc_html_e( 'No categories or tags yet. Filter by date above.', 'ripper-sports' ); ?>
				</p>
			<?php endif; ?>
		</form>
	</div>
</aside>
