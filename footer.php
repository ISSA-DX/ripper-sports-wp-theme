<?php
/**
 * The template for displaying the footer
 *
 * @package Ripper_Sports
 */

?>

<!-- Cookie consent banner -->
<div class="cookie-banner js-cookie-banner" role="dialog" aria-label="<?php esc_attr_e( 'Cookie consent', 'ripper-sports' ); ?>">
  <div class="cookie-banner-inner">
    <div class="cookie-banner-content">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="cookie-icon" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
      <p class="text-body-md">
		  <?php
		  printf(
			  /* translators: %s: privacy policy page URL */
			  esc_html__( 'We use cookies to improve your experience and deliver personalised content. By continuing, you agree to our %s.', 'ripper-sports' ),
			  '<a href="' . esc_url( get_permalink( get_page_by_path( 'privacy' ) ) ) . '" class="text-gold">' . esc_html__( 'Privacy Policy', 'ripper-sports' ) . '</a>'
		  );
		  ?>
      </p>
    </div>
    <button type="button" class="btn btn-primary js-cookie-accept"><?php esc_html_e( 'Accept', 'ripper-sports' ); ?></button>
  </div>
</div>

<!-- Site footer -->
<footer class="site-footer" role="contentinfo">
  <div class="container">
    <div class="footer-top">
      <div class="footer-brand">
        <div class="footer-brand-header">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-original.png?v=' . filemtime( get_template_directory() . '/assets/images/logo-original.png' ) ); ?>" alt="<?php esc_attr_e( 'Ripper Sports', 'ripper-sports' ); ?>" width="72" height="72">
        </div>
        <p class="text-body-md footer-mission">
		  <?php
		  $description = get_bloginfo( 'description' );
		  echo esc_html( $description ? $description : __( 'Australia\'s premier destination for bold sports journalism, real-time data, and unmissable highlights.', 'ripper-sports' ) );
		  ?>
        </p>
        <div class="social-links">
          <a href="#" class="social-link" aria-label="<?php esc_attr_e( 'Facebook', 'ripper-sports' ); ?>">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          </a>
          <a href="#" class="social-link" aria-label="<?php esc_attr_e( 'X (Twitter)', 'ripper-sports' ); ?>">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          </a>
          <a href="#" class="social-link" aria-label="<?php esc_attr_e( 'Instagram', 'ripper-sports' ); ?>">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
          </a>
          <a href="#" class="social-link" aria-label="<?php esc_attr_e( 'YouTube', 'ripper-sports' ); ?>">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
          </a>
          <a href="#" class="social-link" aria-label="<?php esc_attr_e( 'TikTok', 'ripper-sports' ); ?>">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12.525.02c1.31 0 2.591.317 3.734.925.076.042.123.119.123.206v4.613a.24.24 0 01-.365.207c-1.127-.674-2.42-1.03-3.738-1.026v4.475a5.558 5.558 0 105.557 5.557c0-.063-.001-.125-.004-.187v-9.52a8.041 8.041 0 004.148 1.341c.12 0 .22-.092.23-.211l.01-4.175c0-.13-.105-.236-.235-.235a4.041 4.041 0 01-3.666-2.228.239.239 0 00-.214-.14H12.525z"/></svg>
          </a>
        </div>
      </div>

      <div class="footer-links-col">
        <h3 class="footer-title"><?php esc_html_e( 'Quick Links', 'ripper-sports' ); ?></h3>
		<?php if ( has_nav_menu( 'footer' ) ) : ?>
		  <?php
		  wp_nav_menu(
			  array(
				  'theme_location' => 'footer',
				  'container'      => false,
				  'menu_class'     => 'footer-links',
				  'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
				  'depth'          => 1,
			  )
		  );
		  ?>
		<?php else : ?>
		  <ul class="footer-links">
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-link"><?php esc_html_e( 'Home', 'ripper-sports' ); ?></a></li>
			<li><a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" class="footer-link"><?php esc_html_e( 'Latest News', 'ripper-sports' ); ?></a></li>
			<li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'sports' ) ) ); ?>" class="footer-link"><?php esc_html_e( 'All Sports', 'ripper-sports' ); ?></a></li>
			<li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'about' ) ) ); ?>" class="footer-link"><?php esc_html_e( 'About Us', 'ripper-sports' ); ?></a></li>
			<li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>" class="footer-link"><?php esc_html_e( 'Contact Us', 'ripper-sports' ); ?></a></li>
		  </ul>
		<?php endif; ?>
      </div>

      <div class="footer-links-col">
        <h3 class="footer-title"><?php esc_html_e( 'Categories', 'ripper-sports' ); ?></h3>
        <ul class="footer-links">
		  <?php
		  $footer_sports = get_terms(
			  array(
				  'taxonomy'   => 'sport',
				  'hide_empty' => false,
				  'number'     => 5,
				  'orderby'    => 'name',
			  )
		  );

		  if ( ! empty( $footer_sports ) && ! is_wp_error( $footer_sports ) ) :
			  foreach ( $footer_sports as $sport ) :
				  ?>
				  <li><a href="<?php echo esc_url( get_term_link( $sport ) ); ?>" class="footer-link"><?php echo esc_html( $sport->name ); ?></a></li>
				  <?php
			  endforeach;
		  else :
			  $default_footer_sports = array( 'AFL', 'NRL', 'Cricket', 'Soccer', 'Basketball' );
			  foreach ( $default_footer_sports as $sport ) :
				  ?>
				  <li><a href="<?php echo esc_url( home_url( '/?s=' . rawurlencode( $sport ) ) ); ?>" class="footer-link"><?php echo esc_html( $sport ); ?></a></li>
				  <?php
			  endforeach;
		  endif;
		  ?>
        </ul>
      </div>

      <div class="footer-newsletter" id="newsletter">
        <h3 class="footer-title"><?php esc_html_e( 'The Ripper Report', 'ripper-sports' ); ?></h3>
        <p class="text-body-md text-muted"><?php esc_html_e( 'The biggest sports stories delivered to your inbox every morning.', 'ripper-sports' ); ?></p>
        <form class="newsletter-inline js-newsletter-form mt-4" action="#" method="post" data-ajax-action="ripper_sports_newsletter">
          <input type="email" name="email" class="form-input" placeholder="<?php esc_attr_e( 'Email address', 'ripper-sports' ); ?>" required aria-label="<?php esc_attr_e( 'Email address for newsletter', 'ripper-sports' ); ?>">
          <button type="submit" class="btn btn-primary"><?php esc_html_e( 'Subscribe', 'ripper-sports' ); ?></button>
        </form>
        <p class="js-newsletter-status" role="status" aria-live="polite" aria-atomic="true"></p>
        <p class="text-body-sm text-muted mt-3"><?php esc_html_e( 'No spam. Unsubscribe anytime.', 'ripper-sports' ); ?></p>
      </div>
    </div>

    <div class="footer-bottom">
      <p class="footer-copyright">
        &copy; <?php
        /* translators: 1: copyright year, 2: site name */
        echo esc_html( sprintf( __( '%1$d %2$s. All rights reserved.', 'ripper-sports' ), (int) gmdate( 'Y' ), get_bloginfo( 'name' ) ) );
        ?>
      </p>
      <nav class="footer-legal" aria-label="<?php esc_attr_e( 'Legal links', 'ripper-sports' ); ?>">
        <?php if ( get_page_by_path( 'privacy' ) ) : ?>
          <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'privacy' ) ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'ripper-sports' ); ?></a>
        <?php endif; ?>
        <?php if ( get_page_by_path( 'terms' ) ) : ?>
          <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'terms' ) ) ); ?>"><?php esc_html_e( 'Terms of Service', 'ripper-sports' ); ?></a>
        <?php endif; ?>
        <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'about' ) ) ); ?>"><?php esc_html_e( 'About Us', 'ripper-sports' ); ?></a>
      </nav>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
