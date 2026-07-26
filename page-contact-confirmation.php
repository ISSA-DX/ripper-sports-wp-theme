<?php
/**
 * Contact Confirmation
 *
 * Shown after the contact form AJAX handler succeeds. The JS
 * handler redirects here.
 *
 * Template Name: Contact Confirmation
 *
 * @package Ripper_Sports
 */

get_header();
?>
<main id="main-content">
	<section class="section" data-drift="0.04">
		<div class="container">
			<?php /* Breadcrumbs removed per UX: keep the confirmation hero clean. */ ?>

			<header class="page-header page-header--accent reveal-scale">
				<span class="tag"><?php esc_html_e( 'Message Received', 'ripper-sports' ); ?></span>
				<h1 class="text-display text-gold"><?php esc_html_e( "Thanks — we'll be in touch.", 'ripper-sports' ); ?></h1>
				<p class="text-body-lg text-muted">
					<?php esc_html_e( "Your message is on its way to our editorial team. We aim to reply within two business days.", 'ripper-sports' ); ?>
				</p>
				<div class="mt-8 flex flex-wrap gap-3">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary"><?php esc_html_e( 'Back to home', 'ripper-sports' ); ?></a>
					<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>" class="btn btn-ghost"><?php esc_html_e( 'Send another message', 'ripper-sports' ); ?></a>
				</div>
			</header>

			<section class="section mt-12">
				<?php
				set_query_var( 'title', __( 'Recommended reading', 'ripper-sports' ) );
				set_query_var( 'title_class', 'reveal' );
				get_template_part( 'template-parts/section-heading' );
				?>
				<div class="grid-auto reveal-stagger">
					<?php
					$rec = new WP_Query(
						array(
							'post_type'      => 'post',
							'post_status'    => 'publish',
							'posts_per_page' => 4,
							'no_found_rows'  => true,
						)
					);
					if ( $rec->have_posts() ) :
						while ( $rec->have_posts() ) :
							$rec->the_post();
							get_template_part( 'template-parts/content', 'card' );
						endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>
			</section>
		</div>
	</section>
</main>

<?php
get_footer();
