<?php
/**
 * The front page template
 *
 * @package Ripper_Sports
 */

get_header();

$hero_post = new WP_Query(
	array(
		'posts_per_page'      => 1,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
	)
);

$latest_news = new WP_Query(
	array(
		'posts_per_page'      => 4,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'offset'              => 1,
	)
);

$afl_posts     = ripper_sports_get_sport_posts( 'afl' );
$nrl_posts     = ripper_sports_get_sport_posts( 'nrl' );
$cricket_posts = ripper_sports_get_sport_posts( 'cricket' );
?>

<!-- Live scores ticker -->
<div class="score-ticker" aria-label="<?php esc_attr_e( 'Live scores', 'ripper-sports' ); ?>">
  <div class="score-ticker-label" aria-hidden="true"><?php esc_html_e( 'Live Scores', 'ripper-sports' ); ?></div>
  <div class="score-ticker-track">
    <div class="score-item">
      <span class="score-status">AFL Live</span>
      <span class="score-team">WCE <span class="score-value js-live-score">83</span></span>
      <span class="score-divider">vs</span>
      <span class="score-team">FRE <span class="js-live-score">82</span></span>
      <span class="score-time">Q4 02:14</span>
    </div>
    <div class="score-item">
      <span class="score-status">NRL Live</span>
      <span class="score-team">STORM <span class="score-value js-live-score">30</span></span>
      <span class="score-divider">vs</span>
      <span class="score-team">PANTH <span class="js-live-score">18</span></span>
      <span class="score-time">Full Time</span>
    </div>
    <div class="score-item">
      <span class="score-status">AFL Live</span>
      <span class="score-team">COLL <span class="js-live-score">54</span></span>
      <span class="score-divider">vs</span>
      <span class="score-team">RICH <span class="score-value js-live-score">57</span></span>
      <span class="score-time">Q2 15:00</span>
    </div>
    <div class="score-item">
      <span class="score-status">Test</span>
      <span class="score-team">AUS <span class="score-value js-live-score">342/4</span></span>
      <span class="score-divider">vs</span>
      <span class="score-team">IND <span class="js-live-score">---</span></span>
      <span class="score-time">Day 1</span>
    </div>
    <!-- Duplicate set for infinite loop -->
    <div class="score-item">
      <span class="score-status">AFL Live</span>
      <span class="score-team">WCE <span class="score-value js-live-score">83</span></span>
      <span class="score-divider">vs</span>
      <span class="score-team">FRE <span class="js-live-score">82</span></span>
      <span class="score-time">Q4 02:14</span>
    </div>
    <div class="score-item">
      <span class="score-status">NRL Live</span>
      <span class="score-team">STORM <span class="score-value js-live-score">30</span></span>
      <span class="score-divider">vs</span>
      <span class="score-team">PANTH <span class="js-live-score">18</span></span>
      <span class="score-time">Full Time</span>
    </div>
    <div class="score-item">
      <span class="score-status">AFL Live</span>
      <span class="score-team">COLL <span class="js-live-score">54</span></span>
      <span class="score-divider">vs</span>
      <span class="score-team">RICH <span class="score-value js-live-score">57</span></span>
      <span class="score-time">Q2 15:00</span>
    </div>
    <div class="score-item">
      <span class="score-status">Test</span>
      <span class="score-team">AUS <span class="score-value js-live-score">342/4</span></span>
      <span class="score-divider">vs</span>
      <span class="score-team">IND <span class="js-live-score">---</span></span>
      <span class="score-time">Day 1</span>
    </div>
  </div>
</div>

<!-- Breaking news banner -->
<div class="breaking-bar js-breaking-bar" role="region" aria-label="<?php esc_attr_e( 'Breaking news', 'ripper-sports' ); ?>">
  <span class="breaking-bar-label"><?php esc_html_e( 'Breaking', 'ripper-sports' ); ?></span>
  <div class="breaking-bar-track">
    <span class="breaking-bar-headline"><?php esc_html_e( 'BREAKING: Dockers stun Eagles with final-second goal in the Western Derby', 'ripper-sports' ); ?></span>
  </div>
  <button class="breaking-bar-close js-breaking-bar-close" type="button" aria-label="<?php esc_attr_e( 'Dismiss breaking news', 'ripper-sports' ); ?>">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
  </button>
</div>

<main id="main-content">

  <!-- Hero + sidebar -->
  <section class="section">
    <div class="container">
      <div class="two-column-layout">
        <?php if ( $hero_post->have_posts() ) : ?>
          <?php
          $hero_post->the_post();
          $hero_image = has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'ripper-hero' ) : 'https://images.unsplash.com/photo-1518605348738-4faafbd0945d?auto=format&fit=crop&w=1600&q=80';
          $hero_tag       = __( 'Exclusive', 'ripper-sports' );
          $hero_tag_class = 'hero-tag';
          $sports         = get_the_terms( get_the_ID(), 'sport' );
          if ( ! empty( $sports ) && ! is_wp_error( $sports ) ) {
            $hero_tag       = $sports[0]->name;
            $hero_tag_class = 'hero-tag hero-tag--exclusive';
          }
          ?>
          <article class="hero">
            <a href="<?php the_permalink(); ?>" class="h-full w-full">
              <div class="hero-bg" style="background-image: url('<?php echo esc_url( $hero_image ); ?>');" aria-hidden="true"></div>
              <div class="hero-overlay" aria-hidden="true"></div>
              <div class="hero-content">
                <span class="<?php echo esc_attr( $hero_tag_class ); ?>"><?php echo esc_html( $hero_tag ); ?></span>
                <h1 class="hero-title"><?php the_title(); ?></h1>
                <p class="hero-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28 ) ); ?></p>
              </div>
            </a>
          </article>
          <?php wp_reset_postdata(); ?>
        <?php endif; ?>

        <!-- Sidebar -->
        <aside class="flex flex-col gap-6">
          <div class="widget">
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

          <div class="widget widget--editors-picks">
            <h3 class="widget-title">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <?php esc_html_e( "Editor's Picks", 'ripper-sports' ); ?>
            </h3>
            <div class="flex flex-col gap-4">
              <?php
              $editors_picks = new WP_Query(
                array(
                  'posts_per_page'      => 3,
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
                  $ep_image      = has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'ripper-card' ) : 'https://images.unsplash.com/photo-1518605348738-4faafbd0945d?auto=format&fit=crop&w=400&q=80';
                  $ep_like_count = ( abs( crc32( get_the_ID() . 'like' ) ) % 140 ) + 20;
                  ?>
                  <article class="card card-list">
                    <a href="<?php the_permalink(); ?>" class="card-image">
                      <img src="<?php echo esc_url( $ep_image ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                    </a>
                    <div class="card-body">
                      <span class="card-tag <?php echo esc_attr( $ep_tag_class ); ?>"><?php echo esc_html( $ep_tag ); ?></span>
                      <span class="card-category"><?php echo esc_html( $ep_tag ); ?></span>
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

          <div class="newsletter-box" id="newsletter">
            <h3 class="widget-title"><?php esc_html_e( 'The Ripper Report', 'ripper-sports' ); ?></h3>
            <p class="text-body-md mb-4"><?php esc_html_e( 'The biggest sports stories delivered to your inbox every morning at 7am.', 'ripper-sports' ); ?></p>
            <form class="newsletter-inline js-newsletter-form" action="#" method="post" data-ajax-action="ripper_sports_newsletter">
              <input type="email" name="email" class="form-input" placeholder="<?php esc_attr_e( 'Email address', 'ripper-sports' ); ?>" required aria-label="<?php esc_attr_e( 'Email address for newsletter', 'ripper-sports' ); ?>">
              <button type="submit" class="btn btn-accent"><?php esc_html_e( 'Sign Up Free', 'ripper-sports' ); ?></button>
            </form>
          </div>
        </aside>
      </div>
    </div>
  </section>

  <!-- Latest News grid -->
  <section class="section">
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

  <!-- AFL section -->
  <section class="section">
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
  <section class="section">
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
  <section class="section">
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
