<?php
/**
 * Template part for displaying single posts
 *
 * @package Ripper_Sports
 */

$sports     = get_the_terms( get_the_ID(), 'sport' );
$sport      = ! empty( $sports ) && ! is_wp_error( $sports ) ? $sports[0] : null;
$tag_label  = $sport ? $sport->name : __( 'News', 'ripper-sports' );
if ( has_post_thumbnail() ) {
	$hero_image = get_the_post_thumbnail_url( null, 'ripper-hero' );
} else {
	$external   = get_post_meta( get_the_ID(), '_rs_external_image', true );
	$hero_image = $external ? $external : 'https://images.unsplash.com/photo-1518605348738-4faafbd0945d?auto=format&fit=crop&w=1600&q=80';
}
?>

<!-- Article hero -->
<section class="article-hero reveal-scale" style="background-image: url('<?php echo esc_url( $hero_image ); ?>');" aria-label="<?php esc_attr_e( 'Article hero image', 'ripper-sports' ); ?>">
  <div class="container article-hero-content">
    <span class="hero-tag"><?php echo esc_html( $tag_label ); ?></span>
    <?php the_title( '<h1 class="text-display text-gold max-w-4xl mb-4">', '</h1>' ); ?>
    <div class="article-meta">
      <span><?php echo esc_html( get_the_author() ); ?></span>
      <span class="article-meta-dot" aria-hidden="true"></span>
      <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
      <span class="article-meta-dot" aria-hidden="true"></span>
      <span><?php echo esc_html( ripper_sports_reading_time() ); ?></span>
    </div>
  </div>
</section>

<main id="main-content" class="section" data-drift="0.04">
  <div class="container">
    <div class="grid grid-cols-1 lg-grid-cols-12 gap-6">

      <!-- Left share sidebar -->
      <aside class="share-bar sticky-sidebar hidden lg-flex reveal-left">
        <span class="share-label"><?php esc_html_e( 'Share Story', 'ripper-sports' ); ?></span>
        <button class="share-btn js-share-x" aria-label="<?php esc_attr_e( 'Share on X', 'ripper-sports' ); ?>">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        </button>
        <button class="share-btn js-bookmark" aria-label="<?php esc_attr_e( 'Bookmark article', 'ripper-sports' ); ?>">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17 3H7c-1.1 0-1.99.9-1.99 2L5 21l7-3 7 3V5c0-1.1-.9-2-2-2z"/></svg>
        </button>
        <button class="share-btn" aria-label="<?php esc_attr_e( 'Comments', 'ripper-sports' ); ?>">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M21.99 4c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4-.01-18z"/></svg>
        </button>
        <div style="width: 1px; height: 96px; background-color: var(--rs-secondary-container);"></div>
      </aside>

      <!-- Main article -->
      <article class="editorial-content lg-col-span-8 reveal">
        <?php
        $standfirst = get_post_meta( get_the_ID(), '_rs_standfirst', true );
        if ( ! empty( $standfirst ) ) :
          ?>
          <p class="article-lede text-body-lg text-muted mb-6"><?php echo esc_html( $standfirst ); ?></p>
          <?php
        endif;
        ?>
        <div class="entry-content">
          <?php
          the_content();

          wp_link_pages(
            array(
              'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ripper-sports' ),
              'after'  => '</div>',
            )
          );
          ?>
        </div>

        <footer class="mt-12 pt-8" style="border-top: 2px solid var(--rs-secondary-container);">
          <div class="flex flex-wrap gap-3">
			<?php
			$tags = get_the_tags();
			if ( ! empty( $tags ) ) :
				foreach ( $tags as $tag ) :
					?>
					<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="tag">#<?php echo esc_html( $tag->name ); ?></a>
					<?php
				endforeach;
			endif;
			?>
          </div>
        </footer>
      </article>

      <!-- Right sidebar -->
      <aside class="lg-col-span-3 flex flex-col gap-8 reveal-right">
		<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		  <?php dynamic_sidebar( 'sidebar-1' ); ?>
		<?php else : ?>
		  <div class="widget">
			<h3 class="widget-title"><?php esc_html_e( 'Trending Now', 'ripper-sports' ); ?></h3>
			<ul class="trending-list">
			  <?php
			  $trending = new WP_Query(
				array(
					'posts_per_page' => 3,
					'orderby'        => 'comment_count',
					'order'          => 'DESC',
				)
			  );
			  $index = 1;
			  if ( $trending->have_posts() ) :
				while ( $trending->have_posts() ) :
					$trending->the_post();
					$sport_terms = get_the_terms( get_the_ID(), 'sport' );
					$sport_name  = ! empty( $sport_terms ) && ! is_wp_error( $sport_terms ) ? $sport_terms[0]->name : __( 'News', 'ripper-sports' );
					?>
					<li class="trending-item">
					  <span class="trending-number"><?php echo esc_html( str_pad( (string) $index, 2, '0', STR_PAD_LEFT ) ); ?></span>
					  <div>
						<div class="trending-category"><?php echo esc_html( $sport_name ); ?></div>
						<a href="<?php the_permalink(); ?>" class="trending-title"><?php the_title(); ?></a>
					  </div>
					</li>
					<?php
					$index++;
				endwhile;
				wp_reset_postdata();
			  endif;
			  ?>
			</ul>
		  </div>
		<?php endif; ?>
      </aside>
    </div>
  </div>

  <?php
  $related_args = array(
    'posts_per_page'      => 3,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => 1,
    'post__not_in'        => array( get_the_ID() ),
  );

  $related_sports = get_the_terms( get_the_ID(), 'sport' );
  if ( ! empty( $related_sports ) && ! is_wp_error( $related_sports ) ) {
    $related_args['tax_query'] = array(
      array(
        'taxonomy' => 'sport',
        'field'    => 'slug',
        'terms'    => $related_sports[0]->slug,
      ),
    );
    $related_link = get_term_link( $related_sports[0] );
  } else {
    $related_categories = get_the_category();
    if ( ! empty( $related_categories ) ) {
      $related_args['category__in'] = array( $related_categories[0]->term_id );
    }
    $related_link = get_post_type_archive_link( 'post' );
  }

  $related = new WP_Query( $related_args );
  if ( $related->have_posts() ) :
    ?>
    <!-- Related Stories -->
    <section class="section bg-primary-container" data-drift="0.04">
      <div class="container">
        <div class="related-section">
          <div class="section-header reveal">
            <h2 class="section-title text-gold"><?php esc_html_e( 'Related Stories', 'ripper-sports' ); ?></h2>
            <a href="<?php echo esc_url( $related_link ); ?>" class="section-link"><?php esc_html_e( 'View All Editorials', 'ripper-sports' ); ?></a>
          </div>

          <div class="related-scroll reveal-stagger">
            <?php
            while ( $related->have_posts() ) :
              $related->the_post();
              get_template_part( 'template-parts/content', 'card' );
            endwhile;
            wp_reset_postdata();
            ?>
          </div>
        </div>
      </div>
    </section>
    <?php
  endif;
  ?>
</main>
