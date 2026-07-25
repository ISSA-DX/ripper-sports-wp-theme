<?php
/**
 * Template Name: Sports Directory
 *
 * A directory of all sports covered by the site.
 *
 * @package Ripper_Sports
 */

get_header();

$sports = get_terms(
	array(
		'taxonomy'   => 'sport',
		'hide_empty' => false,
		'orderby'    => 'name',
		'order'      => 'ASC',
	)
);

$sport_meta = array(
	'afl'        => array(
		'image'   => 'https://images.unsplash.com/photo-1560272564-c83061ea7ca4?auto=format&fit=crop&w=800&q=80',
		'tag'     => __( 'Live Updates', 'ripper-sports' ),
		'headline'=> __( 'Finals Series Bracket Revealed', 'ripper-sports' ),
		'summary' => __( 'Analysing the road to the Grand Final as the top eight prepares for the most competitive season finish.', 'ripper-sports' ),
	),
	'nrl'        => array(
		'image'   => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?auto=format&fit=crop&w=800&q=80',
		'headline'=> __( 'Storm vs Panthers: Blockbuster Recap', 'ripper-sports' ),
		'summary' => __( 'A tactical breakdown of the defensive masterclass that saw the ladder leaders extend their streak.', 'ripper-sports' ),
	),
	'cricket'    => array(
		'image'   => 'https://images.unsplash.com/photo-1531417448997-8e32b5c03701?auto=format&fit=crop&w=800&q=80',
		'headline'=> __( 'The Ashes: Selection Dilemmas Deepen', 'ripper-sports' ),
		'summary' => __( 'Internal reports suggest a major shakeup in the bowling lineup ahead of the Boxing Day Test.', 'ripper-sports' ),
	),
	'soccer'     => array(
		'image'   => 'https://images.unsplash.com/photo-1518091043644-c1d4457512c6?auto=format&fit=crop&w=800&q=80',
		'tag'     => __( 'Video', 'ripper-sports' ),
		'headline'=> __( 'A-League: Transfer Window Madness', 'ripper-sports' ),
		'summary' => __( 'Three marquee signings announced in 24 hours as clubs look to bolster squads.', 'ripper-sports' ),
	),
	'basketball' => array(
		'image'   => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?auto=format&fit=crop&w=800&q=80',
		'headline'=> __( 'NBL: MVP Race Tightens Up', 'ripper-sports' ),
		'summary' => __( 'Stat-heavy analysis of the top three contenders as the regular season enters its final month.', 'ripper-sports' ),
	),
	'rugby'      => array(
		'image'   => 'https://images.unsplash.com/photo-1473973266408-ed4e27abdd47?auto=format&fit=crop&w=800&q=80',
		'headline'=> __( 'Bledisloe Cup: Tactical Preview', 'ripper-sports' ),
		'summary' => __( 'Expert panel discusses the scrum mechanics and set-piece strategies for the series opener.', 'ripper-sports' ),
	),
	'tennis'     => array(
		'image'   => 'https://images.unsplash.com/photo-1622163642998-1ea0b3e6e3f6?auto=format&fit=crop&w=800&q=80',
		'headline'=> __( 'Aus Open: Wildcards Announced', 'ripper-sports' ),
		'summary' => __( 'A first look at the rising stars and returning veterans granted entry into the season\'s first Major.', 'ripper-sports' ),
	),
	'motorsport' => array(
		'image'   => 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&w=800&q=80',
		'headline'=> __( 'Grand Prix: Aero Upgrades Leaked', 'ripper-sports' ),
		'summary' => __( 'Tech deep-dive into the floor modifications expected to give the championship leaders an advantage.', 'ripper-sports' ),
	),
	'boxing-mma' => array(
		'image'   => 'https://images.unsplash.com/photo-1599058945522-28d584b6f0ff?auto=format&fit=crop&w=800&q=80',
		'tag'     => __( 'Pay-Per-View', 'ripper-sports' ),
		'headline'=> __( 'Title Fight: Weigh-in Controversy', 'ripper-sports' ),
		'summary' => __( 'Tempers flare at the final press conference as the heavyweight rivals come face-to-face.', 'ripper-sports' ),
	),
	'golf'       => array(
		'image'   => 'https://images.unsplash.com/photo-1535131749006-b7f58c99034b?auto=format&fit=crop&w=800&q=80',
		'headline'=> __( 'Masters: Course Conditions Report', 'ripper-sports' ),
		'summary' => __( 'Greens are running faster than ever as weather patterns predict a challenging weekend at Augusta.', 'ripper-sports' ),
	),
);
?>

<main id="main-content">
  <section class="section">
    <div class="container">
      <div class="page-header">
        <span class="page-kicker"><?php esc_html_e( 'The Ultimate Arena', 'ripper-sports' ); ?></span>
        <h1 class="page-title"><?php the_title(); ?></h1>
      </div>

      <?php if ( ! empty( $sports ) && ! is_wp_error( $sports ) ) : ?>
        <div class="grid-auto">
          <?php foreach ( $sports as $sport ) : ?>
            <?php
            $slug = $sport->slug;
            $meta = isset( $sport_meta[ $slug ] ) ? $sport_meta[ $slug ] : array(
              'image'    => 'https://images.unsplash.com/photo-1518605348738-4faafbd0945d?auto=format&fit=crop&w=800&q=80',
              'headline' => __( 'Latest Coverage', 'ripper-sports' ),
              'summary'  => sprintf(
                /* translators: %s: sport name */
                esc_html__( 'Read the latest %s news, analysis and highlights.', 'ripper-sports' ),
                $sport->name
              ),
            );
            $link = get_term_link( $sport );
            ?>
            <article class="sport-card">
              <a href="<?php echo esc_url( $link ); ?>" class="sport-card-image">
                <img src="<?php echo esc_url( $meta['image'] ); ?>" alt="<?php echo esc_attr( $sport->name ); ?>" loading="lazy">
                <?php if ( ! empty( $meta['tag'] ) ) : ?>
                  <span class="card-tag" <?php echo ( 'boxing-mma' === $slug ) ? 'style="background-color: var(--rs-error-container);"' : ''; ?>><?php echo esc_html( $meta['tag'] ); ?></span>
                <?php endif; ?>
              </a>
              <div class="sport-card-body">
                <h2 class="sport-card-title"><?php echo esc_html( $sport->name ); ?></h2>
                <p class="text-body-md font-bold text-cream mb-2"><?php echo esc_html( $meta['headline'] ); ?></p>
                <p class="text-body-md text-muted"><?php echo esc_html( $meta['summary'] ); ?></p>
                <a href="<?php echo esc_url( $link ); ?>" class="sport-card-link">
                  <?php
                  /* translators: %s: sport name */
                  printf( esc_html__( 'View %s News', 'ripper-sports' ), $sport->name );
                  ?>
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
                </a>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php else : ?>
        <p class="text-body-md text-muted"><?php esc_html_e( 'Sports categories will appear here once they are created.', 'ripper-sports' ); ?></p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Newsletter CTA -->
  <section class="section">
    <div class="container">
      <div class="bg-surface-container-high p-8 md-p-12 border border-white-10 relative overflow-hidden">
        <div class="relative z-10 max-w-2xl">
          <h2 class="text-headline-md text-gold uppercase mb-4"><?php esc_html_e( 'Data-Driven Insights', 'ripper-sports' ); ?></h2>
          <p class="text-body-lg text-muted mb-8"><?php esc_html_e( 'Get the scoreboard-level analytics and professional commentary delivered straight to your inbox every morning.', 'ripper-sports' ); ?></p>
          <form class="newsletter-inline js-newsletter-form" action="#" method="post" data-ajax-action="ripper_sports_newsletter">
            <input type="email" name="email" class="form-input" placeholder="<?php esc_attr_e( 'Enter email address', 'ripper-sports' ); ?>" required aria-label="<?php esc_attr_e( 'Email address for newsletter', 'ripper-sports' ); ?>">
            <button type="submit" class="btn btn-primary"><?php esc_html_e( 'Subscribe', 'ripper-sports' ); ?></button>
          </form>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
get_footer();
