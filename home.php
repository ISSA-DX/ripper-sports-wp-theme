<?php
/**
 * Home (Blog Index)
 *
 * Used when Settings → Reading → "Your homepage displays" is set to
 * "Your latest posts". Renders the latest news grid, the same as
 * front-page minus the featured hero.
 *
 * @package Ripper_Sports
 */

get_header();
?>

<main id="main-content">
	<section class="section">
		<div class="container">
			<?php
			set_query_var( 'title', __( 'Latest News', 'ripper-sports' ) );
			set_query_var( 'view_all_url', '' );
			get_template_part( 'template-parts/section-heading' );
			?>
			<div class="grid-auto">
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
