<?php
/**
 * Sport Taxonomy Archive
 *
 * Renders the per-sport archive (e.g. /sport/afl/). Mirrors the
 * reference `sport-archive.html` with breadcrumbs, a sticky filter
 * sidebar, and a 2-col grid of cards.
 *
 * @package Ripper_Sports
 */

get_header();

$term = get_queried_object();
?>
<main id="main-content">
	<section class="section">
		<div class="container">
			<?php /* Breadcrumbs removed per UX: keep the hero clean, no 'Home / AFL' trail. */ ?>

			<?php if ( $term && ! is_wp_error( $term ) ) : ?>
				<header class="page-header page-header--accent">
					<span class="tag"><?php esc_html_e( 'Sport Archive', 'ripper-sports' ); ?></span>
					<h1 class="text-display text-cream"><?php echo esc_html( $term->name ); ?> <?php esc_html_e( 'News', 'ripper-sports' ); ?></h1>
					<?php if ( ! empty( $term->description ) ) : ?>
						<p class="text-body-lg text-muted js-sport-summary"><?php echo esc_html( $term->description ); ?></p>
					<?php else : ?>
						<p class="text-body-lg text-muted js-sport-summary">
							<?php
							printf(
								/* translators: %s: sport name */
								esc_html__( 'Latest news, analysis and opinion from the world of %s.', 'ripper-sports' ),
								esc_html( $term->name )
							);
							?>
						</p>
					<?php endif; ?>
				</header>
			<?php endif; ?>

			<div class="archive-layout">
				<?php get_template_part( 'template-parts/sport-filter-sidebar' ); ?>

				<div class="archive-content">
					<div class="grid-2">
						<?php
						if ( have_posts() ) :
							while ( have_posts() ) :
								the_post();
								get_template_part( 'template-parts/content', 'card' );
							endwhile;
							the_posts_pagination();
						else :
							get_template_part( 'template-parts/content', 'none' );
						endif;
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
