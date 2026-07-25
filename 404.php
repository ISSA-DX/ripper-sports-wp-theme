<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Ripper_Sports
 */

get_header();
?>

<main id="main-content" class="section">
  <div class="container">
    <section class="error-404 not-found text-center py-16">
      <header class="page-header">
        <h1 class="text-display text-gold mb-4"><?php esc_html_e( '404', 'ripper-sports' ); ?></h1>
        <h2 class="text-headline-lg mb-6"><?php esc_html_e( 'Page not found', 'ripper-sports' ); ?></h2>
      </header>

      <div class="page-content max-w-2xl mx-auto">
        <p class="text-body-md mb-8">
          <?php esc_html_e( 'Looks like this play didn\'t come off. The page you\'re looking for may have moved or no longer exists.', 'ripper-sports' ); ?>
        </p>

        <form class="newsletter-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
          <input type="search" name="s" class="form-input" placeholder="<?php esc_attr_e( 'Search Ripper Sports...', 'ripper-sports' ); ?>" aria-label="<?php esc_attr_e( 'Search', 'ripper-sports' ); ?>">
          <button type="submit" class="btn btn-primary"><?php esc_html_e( 'Search', 'ripper-sports' ); ?></button>
        </form>

        <p class="mt-8">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-secondary"><?php esc_html_e( 'Back to home', 'ripper-sports' ); ?></a>
        </p>
      </div>
    </section>
  </div>
</main>

<?php
get_footer();
