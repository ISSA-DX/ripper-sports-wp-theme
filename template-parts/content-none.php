<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Ripper_Sports
 */
?>

<section class="no-results not-found">
  <header class="page-header">
    <h1 class="text-headline-lg text-gold mb-4"><?php esc_html_e( 'Nothing Found', 'ripper-sports' ); ?></h1>
  </header>

  <div class="page-content">
    <p class="text-body-md">
      <?php
      if ( is_search() ) {
        esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'ripper-sports' );
      } else {
        esc_html_e( 'It seems we can\'t find what you\'re looking for. Perhaps a search will help.', 'ripper-sports' );
      }
      ?>
    </p>

    <form class="newsletter-inline mt-6" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
      <input type="search" name="s" class="form-input" placeholder="<?php esc_attr_e( 'Search Ripper Sports...', 'ripper-sports' ); ?>" aria-label="<?php esc_attr_e( 'Search', 'ripper-sports' ); ?>">
      <button type="submit" class="btn btn-primary"><?php esc_html_e( 'Search', 'ripper-sports' ); ?></button>
    </form>
  </div>
</section>
