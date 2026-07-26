<?php
/**
 * Search Results
 *
 * Two-column layout with hero (pre-filled query + result count),
 * a sort selector, and horizontal result cards. JS reads `?orderby=`
 * to switch the query.
 *
 * @package Ripper_Sports
 */

get_header();

$query       = get_search_query();
$result_count = (int) $GLOBALS['wp_query']->found_posts;
$orderby     = isset( $_GET['orderby'] ) ? sanitize_key( wp_unslash( $_GET['orderby'] ) ) : 'date'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>
<main id="main-content">
	<section class="section" data-drift="0.04">
		<div class="container">
			<?php /* Breadcrumbs removed per UX: keep the hero clean. */ ?>

			<header class="page-header page-header--accent search-hero reveal">
				<span class="tag"><?php esc_html_e( 'Search', 'ripper-sports' ); ?></span>
				<h1 class="text-display text-cream">
					<?php if ( $query ) : ?>
						<?php
						printf(
							/* translators: %s: search query. */
							esc_html__( 'Results for "%s"', 'ripper-sports' ),
							esc_html( $query )
						);
						?>
					<?php else : ?>
						<?php esc_html_e( 'Search the newsroom', 'ripper-sports' ); ?>
					<?php endif; ?>
				</h1>
				<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form mt-6">
					<label for="s" class="screen-reader-text"><?php esc_html_e( 'Search', 'ripper-sports' ); ?></label>
					<div class="search-input-wrap">
						<input id="s" type="search" name="s" class="form-input" value="<?php echo esc_attr( $query ); ?>" placeholder="<?php esc_attr_e( 'Search articles, sports, players…', 'ripper-sports' ); ?>">
						<button type="submit" class="btn btn-primary"><?php esc_html_e( 'Search', 'ripper-sports' ); ?></button>
					</div>
				</form>
			</header>

			<div class="search-toolbar flex flex-wrap items-center justify-between gap-3 mt-6 mb-8 reveal">
				<p class="text-body-md text-muted">
					<?php
					if ( $query ) {
						printf(
							/* translators: %s: result count */
							esc_html( _n( '%s result found', '%s results found', $result_count, 'ripper-sports' ) ),
							esc_html( number_format_i18n( $result_count ) )
						);
					} else {
						esc_html_e( 'Type a query above to search the archive.', 'ripper-sports' );
					}
					?>
				</p>
				<form method="get" class="search-sort" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label for="orderby" class="screen-reader-text"><?php esc_html_e( 'Sort by', 'ripper-sports' ); ?></label>
					<input type="hidden" name="s" value="<?php echo esc_attr( $query ); ?>">
					<select id="orderby" name="orderby" class="form-select" onchange="this.form.submit()">
						<option value="date"     <?php selected( $orderby, 'date' ); ?>><?php esc_html_e( 'Newest first', 'ripper-sports' ); ?></option>
						<option value="popular"  <?php selected( $orderby, 'popular' ); ?>><?php esc_html_e( 'Most read', 'ripper-sports' ); ?></option>
						<option value="relevance"<?php selected( $orderby, 'relevance' ); ?>><?php esc_html_e( 'Most relevant', 'ripper-sports' ); ?></option>
					</select>
				</form>
			</div>

			<div class="grid-2 reveal-stagger">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'card-horizontal' );
					endwhile;
					the_posts_pagination();
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif;
				?>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
