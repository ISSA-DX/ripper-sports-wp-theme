<?php
/**
 * Author Archive
 *
 * @package Ripper_Sports
 */

get_header();

$author_id = get_queried_object_id();
?>
<main id="main-content">
	<section class="section">
		<div class="container">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

			<header class="page-header page-header--accent flex flex-col md-flex-row gap-6 md-items-center">
				<?php echo get_avatar( $author_id, 96, '', '', array( 'class' => 'rounded-full' ) ); ?>
				<div>
					<span class="tag"><?php esc_html_e( 'Author', 'ripper-sports' ); ?></span>
					<h1 class="text-display text-cream"><?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?></h1>
					<?php $bio = get_the_author_meta( 'description', $author_id ); if ( $bio ) : ?>
						<p class="text-body-lg text-muted"><?php echo esc_html( $bio ); ?></p>
					<?php endif; ?>
				</div>
			</header>

			<div class="grid-auto mt-8">
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
