<?php
/**
 * The front page template
 *
 * Template Name: Front Page (Hero)
 *
 * @package Ripper_Sports
 */

get_header();

$latest_news = new WP_Query(
	array(
		'posts_per_page'      => 9,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
	)
);

$afl_posts     = ripper_sports_get_sport_posts( 'afl' );
$nrl_posts     = ripper_sports_get_sport_posts( 'nrl' );
$cricket_posts = ripper_sports_get_sport_posts( 'cricket' );
?>

<?php
/* CNN-style full-bleed hero (replaces the small hero). */
get_template_part( 'template-parts/feature-hero' );

/* Breaking news banner. */
get_template_part( 'template-parts/breaking-bar' );

/* Sport quick-pick icon row. */
get_template_part( 'template-parts/sport-quickpick' );

/* Live updates ticker (bottom-left slide-in). */
get_template_part( 'template-parts/updates-ticker' );
?>

<main id="main-content">

  <!-- Trending Now + The Ripper Report — full-width band -->
  <section class="trending-newsletter-band">
    <div class="container">
      <div class="trending-newsletter-grid">
        <div class="widget widget--trending widget--trending-wide">
          <h3 class="widget-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/></svg>
            <?php esc_html_e( 'Trending Now', 'ripper-sports' ); ?>
          </h3>
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
                    <div class="trending-meta">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
                      <?php echo esc_html( human_time_diff( get_the_time( 'U' ), current_time( 'U' ) ) . ' ' . __( 'ago', 'ripper-sports' ) ); ?>
                    </div>
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

        <div class="newsletter-box newsletter-box--band" id="newsletter">
          <h3 class="widget-title"><?php esc_html_e( 'The Ripper Report', 'ripper-sports' ); ?></h3>
          <p class="text-body-sm mb-3"><?php esc_html_e( 'The biggest sports stories delivered to your inbox every morning at 7am.', 'ripper-sports' ); ?></p>
          <form class="newsletter-inline js-newsletter-form" action="#" method="post" data-ajax-action="ripper_sports_newsletter">
            <input type="email" name="email" class="form-input" placeholder="<?php esc_attr_e( 'Email address', 'ripper-sports' ); ?>" required aria-label="<?php esc_attr_e( 'Email address for newsletter', 'ripper-sports' ); ?>">
            <button type="submit" class="btn btn-accent"><?php esc_html_e( 'Sign Up Free', 'ripper-sports' ); ?></button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Latest News grid -->
  <section class="section" data-drift="0.05">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title"><?php esc_html_e( 'Latest News', 'ripper-sports' ); ?></h2>
        <a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" class="section-link"><?php esc_html_e( 'View All', 'ripper-sports' ); ?></a>
      </div>

      <div class="grid-auto">
        <?php
        if ( $latest_news->have_posts() ) :
          while ( $latest_news->have_posts() ) :
            $latest_news->the_post();
            get_template_part( 'template-parts/content', 'card' );
          endwhile;
          wp_reset_postdata();
        else :
          get_template_part( 'template-parts/content', 'none' );
        endif;
        ?>
      </div>
    </div>
  </section>

  <!-- Editor's Picks + Live sidebar — two columns -->
  <section class="section" data-drift="0.04">
    <div class="container">
      <div class="two-column-layout">
        <div class="widget widget--editors-picks">
          <h3 class="widget-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            <?php esc_html_e( "Editor's Picks", 'ripper-sports' ); ?>
          </h3>
          <div class="flex flex-col gap-4">
            <?php
            $editors_picks = new WP_Query(
              array(
                'posts_per_page'      => 4,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
              )
            );
            if ( $editors_picks->have_posts() ) :
              while ( $editors_picks->have_posts() ) :
                $editors_picks->the_post();
                $ep_sports     = get_the_terms( get_the_ID(), 'sport' );
                $ep_sport      = ! empty( $ep_sports ) && ! is_wp_error( $ep_sports ) ? $ep_sports[0] : null;
                $ep_tag        = $ep_sport ? $ep_sport->name : __( 'News', 'ripper-sports' );
                $ep_tag_class  = $ep_sport ? sanitize_html_class( 'card-tag--' . $ep_sport->slug ) : 'card-tag--analysis';
                if ( has_post_thumbnail() ) {
                  $ep_image = get_the_post_thumbnail_url( null, 'ripper-card' );
                } else {
                  $ep_image_ext = get_post_meta( get_the_ID(), '_rs_external_image', true );
                  $ep_image     = $ep_image_ext ? $ep_image_ext : 'https://images.unsplash.com/photo-1518605348738-4faafbd0945d?auto=format&fit=crop&w=400&q=80';
                }
                $ep_like_count = (int) get_post_meta( get_the_ID(), '_rs_like_count', true );
                if ( ! $ep_like_count ) {
                  $ep_like_count = ( abs( crc32( get_the_ID() . 'like' ) ) % 140 ) + 20;
                }
                ?>
                <article class="card card-list">
                  <a href="<?php the_permalink(); ?>" class="card-image">
                    <img src="<?php echo esc_url( $ep_image ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                  </a>
                  <div class="card-body">
                    <span class="card-tag <?php echo esc_attr( $ep_tag_class ); ?>"><?php echo esc_html( $ep_tag ); ?></span>
                    <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="card-meta">
                      <div class="card-meta-left">
                        <span class="editors-stamp">
                          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                          <?php esc_html_e( "Editor's Pick", 'ripper-sports' ); ?>
                        </span>
                      </div>
                      <div class="card-meta-right">
                        <span class="card-reaction" aria-label="<?php esc_attr_e( 'Like article', 'ripper-sports' ); ?>">
                          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                          <span class="card-reaction-count"><?php echo esc_html( $ep_like_count ); ?></span>
                        </span>
                      </div>
                    </div>
                  </div>
                </article>
                <?php
              endwhile;
              wp_reset_postdata();
            endif;
            ?>
          </div>
        </div>

        <div class="live-sidebar-column">
          <?php get_template_part( 'template-parts/score-ticker-sidebar' ); ?>
        </div>
      </div>
    </div>
  </section>

  <!-- AFL section -->
  <section class="section" data-drift="0.06">
    <div class="container">
      <h2 class="section-title section-title-accent mb-8"><?php esc_html_e( 'AFL: The Footy Report', 'ripper-sports' ); ?></h2>
      <div class="three-column-layout">
        <?php
        if ( $afl_posts->have_posts() ) :
          while ( $afl_posts->have_posts() ) :
            $afl_posts->the_post();
            get_template_part( 'template-parts/content', 'card' );
          endwhile;
          wp_reset_postdata();
        endif;
        ?>
      </div>
    </div>
  </section>

  <!-- NRL section -->
  <section class="section" data-drift="0.06">
    <div class="container">
      <h2 class="section-title section-title-accent mb-8" style="border-left-color: var(--rs-secondary);"><?php esc_html_e( 'NRL: League Watch', 'ripper-sports' ); ?></h2>
      <div class="three-column-layout">
        <?php
        if ( $nrl_posts->have_posts() ) :
          while ( $nrl_posts->have_posts() ) :
            $nrl_posts->the_post();
            get_template_part( 'template-parts/content', 'card' );
          endwhile;
          wp_reset_postdata();
        endif;
        ?>
      </div>
    </div>
  </section>

  <!-- Cricket section -->
  <section class="section" data-drift="0.05">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title"><?php esc_html_e( 'Cricket Central', 'ripper-sports' ); ?></h2>
        <?php
        $cricket_term = get_term_by( 'slug', 'cricket', 'sport' );
        $cricket_link = $cricket_term ? get_term_link( $cricket_term ) : home_url( '/' );
        ?>
        <a href="<?php echo esc_url( $cricket_link ); ?>" class="section-link"><?php esc_html_e( 'View All Cricket', 'ripper-sports' ); ?></a>
      </div>

      <div class="three-column-layout">
        <?php
        if ( $cricket_posts->have_posts() ) :
          while ( $cricket_posts->have_posts() ) :
            $cricket_posts->the_post();
            get_template_part( 'template-parts/content', 'card' );
          endwhile;
          wp_reset_postdata();
        endif;
        ?>
      </div>
    </div>
  </section>

</main>

<?php
get_footer();
