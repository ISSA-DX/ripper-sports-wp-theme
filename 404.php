<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * Editorial 404 — full-bleed hero with a sports-themed graphic, recent
 * posts the user might actually want to read, and a quick way back to
 * the homepage or to search.
 *
 * @package Ripper_Sports
 */

get_header();

/* Surface a few recent posts so the page is useful, not dead. */
$ripper_404_recent = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => 1,
		'no_found_rows'       => true,
	)
);
?>

<main id="main-content">
	<!-- Editorial 404 hero -->
	<section class="error-hero">
		<div class="container error-hero-inner">
			<span class="error-kicker"><?php esc_html_e( '404 · Bench warmer', 'ripper-sports' ); ?></span>
			<h1 class="error-headline">
				<span class="error-headline-line"><?php esc_html_e( 'This play', 'ripper-sports' ); ?></span>
				<span class="error-headline-line text-gold"><?php esc_html_e( 'didn’t come off.', 'ripper-sports' ); ?></span>
			</h1>
			<p class="error-lede">
				<?php esc_html_e( 'The page you’re looking for has been red-flagged, benched or moved to a different position in the lineup. Try a fresh search, or jump back to the field.', 'ripper-sports' ); ?>
			</p>

			<div class="error-actions">
				<form class="error-search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
					<label for="error-search-input" class="sr-only"><?php esc_html_e( 'Search Ripper Sports', 'ripper-sports' ); ?></label>
					<input id="error-search-input" type="search" name="s" class="form-input" placeholder="<?php esc_attr_e( 'Search athletes, teams, stories…', 'ripper-sports' ); ?>" autocomplete="off" aria-label="<?php esc_attr_e( 'Search query', 'ripper-sports' ); ?>">
					<button type="submit" class="btn btn-primary">
						<?php esc_html_e( 'Search', 'ripper-sports' ); ?>
						<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
					</button>
				</form>

				<div class="error-action-row">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-secondary">
						<?php esc_html_e( 'Back to Home', 'ripper-sports' ); ?>
					</a>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" class="btn btn-ghost">
						<?php esc_html_e( 'Latest News', 'ripper-sports' ); ?>
					</a>
					<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'sports' ) ) ); ?>" class="btn btn-ghost">
						<?php esc_html_e( 'All Sports', 'ripper-sports' ); ?>
					</a>
				</div>
			</div>
		</div>
	</section>

	<?php if ( $ripper_404_recent->have_posts() ) : ?>
		<!-- Recent stories — keep the user engaged -->
		<section class="section bg-primary-container border-y border-white-10">
			<div class="container">
				<div class="section-header">
					<h2 class="section-title text-gold"><?php esc_html_e( 'While You’re Here', 'ripper-sports' ); ?></h2>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" class="section-link"><?php esc_html_e( 'View All', 'ripper-sports' ); ?></a>
				</div>
				<div class="grid-3">
					<?php
					while ( $ripper_404_recent->have_posts() ) :
						$ripper_404_recent->the_post();
						get_template_part( 'template-parts/content', 'card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- Newsletter CTA — recover the bounce -->
	<section class="section">
		<div class="container">
			<div class="bg-surface-container-high p-8 md-p-12 border border-white-10 relative overflow-hidden">
				<div class="relative z-10 max-w-2xl">
					<h2 class="text-headline-md text-gold uppercase mb-4"><?php esc_html_e( 'Stay on the team sheet', 'ripper-sports' ); ?></h2>
					<p class="text-body-lg text-muted mb-8"><?php esc_html_e( 'Get the scoreboard-level analytics and professional commentary delivered straight to your inbox every morning.', 'ripper-sports' ); ?></p>
					<form class="newsletter-inline js-newsletter-form" action="#" method="post" data-ajax-action="ripper_sports_newsletter">
						<label for="error-newsletter-email" class="sr-only"><?php esc_html_e( 'Email address', 'ripper-sports' ); ?></label>
						<input id="error-newsletter-email" type="email" name="email" class="form-input" placeholder="<?php esc_attr_e( 'Enter email address', 'ripper-sports' ); ?>" required>
						<button type="submit" class="btn btn-primary"><?php esc_html_e( 'Subscribe', 'ripper-sports' ); ?></button>
					</form>
				</div>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();