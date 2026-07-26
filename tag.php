<?php
/**
 * Tag Archive
 *
 * @package Ripper_Sports
 */

get_header();
?>
<main id="main-content">
	<section class="section" data-drift="0.04">
		<div class="container">
			<?php /* Breadcrumbs removed per UX */ ?>

			<header class="page-header page-header--accent reveal">
				<span class="tag"><?php esc_html_e( 'Tag', 'ripper-sports' ); ?></span>
				<h1 class="text-display text-cream"><?php echo esc_html( single_tag_title( '', false ) ); ?></h1>
			</header>

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
