<?php
/**
 * Template Name: Sports Directory
 *
 * A directory of all sports covered by the site. Prefers term meta
 * (`_rs_sport_image`, `_rs_sport_headline`, `_rs_sport_summary`,
 * `_rs_sport_tag`) so editors can curate per-sport; falls back to a
 * small hardcoded default when none is set.
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

$default_image = 'https://images.unsplash.com/photo-1518605348738-4faafbd0945d?auto=format&fit=crop&w=800&q=80';
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
            $tid = (int) $sport->term_id;
            $image    = get_term_meta( $tid, '_rs_sport_image', true )    ?: $default_image;
            $headline = get_term_meta( $tid, '_rs_sport_headline', true ) ?: __( 'Latest Coverage', 'ripper-sports' );
            $tag      = get_term_meta( $tid, '_rs_sport_tag', true );
            $summary  = get_term_meta( $tid, '_rs_sport_summary', true );
            if ( ! $summary ) {
              $summary = sprintf(
                /* translators: %s: sport name */
                esc_html__( 'Read the latest %s news, analysis and highlights.', 'ripper-sports' ),
                $sport->name
              );
            }
            $link = get_term_link( $sport );
            $slug = $sport->slug;
            ?>
            <article class="sport-card">
              <a href="<?php echo esc_url( $link ); ?>" class="sport-card-image">
                <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $sport->name ); ?>" loading="lazy">
                <?php if ( ! empty( $tag ) ) : ?>
                  <span class="card-tag" <?php echo ( 'boxing-mma' === $slug ) ? 'style="background-color: var(--rs-error-container);"' : ''; ?>><?php echo esc_html( $tag ); ?></span>
                <?php endif; ?>
              </a>
              <div class="sport-card-body">
                <h2 class="sport-card-title"><?php echo esc_html( $sport->name ); ?></h2>
                <p class="text-body-md font-bold text-cream mb-2"><?php echo esc_html( $headline ); ?></p>
                <p class="text-body-md text-muted"><?php echo esc_html( $summary ); ?></p>
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
