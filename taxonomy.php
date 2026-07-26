<?php
/**
 * Generic Taxonomy Archive
 *
 * Fallback for any custom taxonomy that does not have a specific
 * template (e.g. categories, future editorial taxonomies). Mirrors
 * `taxonomy-sport.php` minus the sport-specific copy.
 *
 * @package Ripper_Sports
 */

get_header();

$term = get_queried_object();
?>
<main id="main-content">
	<section class="section" data-drift="0.04">
		<div class="container">
			<?php /* Breadcrumbs removed per UX */ ?>

			<?php if ( $term && ! is_wp_error( $term ) ) : ?>
				<header class="page-header page-header--accent reveal">
					<h1 class="text-display text-cream"><?php echo esc_html( single_term_title( '', false ) ); ?></h1>
					<?php if ( ! empty( $term->description ) ) : ?>
						<p class="text-body-lg text-muted"><?php echo esc_html( $term->description ); ?></p>
					<?php endif; ?>
				</header>
			<?php endif; ?>

			<div class="grid-auto reveal-stagger">
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
	</section>
</main>

<?php
get_footer();
