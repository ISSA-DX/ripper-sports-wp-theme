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

<main id="main-content">

  <!-- Hero + sidebar -->
  <section class="section">
    <div class="container">
      <div class="two-column-layout">
        <?php if ( $hero_post->have_posts() ) : ?>
          <?php
          $hero_post->the_post();
          $hero_image = has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'ripper-hero' ) : 'https://images.unsplash.com/photo-1518605348738-4faafbd0945d?auto=format&fit=crop&w=1600&q=80';
          $hero_tag   = __( 'Exclusive', 'ripper-sports' );
          $sports     = get_the_terms( get_the_ID(), 'sport' );
          if ( ! empty( $sports ) && ! is_wp_error( $sports ) ) {
            $hero_tag = $sports[0]->name;
          }
          ?>
          <article class="hero">
            <a href="<?php the_permalink(); ?>" class="h-full w-full">
              <div class="hero-bg" style="background-image: url('<?php echo esc_url( $hero_image ); ?>');" aria-hidden="true"></div>
              <div class="hero-overlay" aria-hidden="true"></div>
              <div class="hero-content">
                <span class="hero-tag"><?php echo esc_html( $hero_tag ); ?></span>
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
