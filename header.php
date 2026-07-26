<?php
/**
 * The header for our theme
 *
 * @package Ripper_Sports
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
/* Decorative floating sports balls (parallax + cursor repulsion).
   aria-hidden, fixed-position layer behind content. */
get_template_part( 'template-parts/background-animation' );

/* Cursor-following gold glow + scroll-tinted gradient layer.
   Sits above the balls but below all content. */
get_template_part( 'template-parts/cursor-glow' );
?>

<!-- Skip link for keyboard users -->
<a href="#main-content" class="skip-link"><?php esc_html_e( 'Skip to content', 'ripper-sports' ); ?></a>

<!-- Reading progress bar -->
<div class="reading-progress js-reading-progress" aria-hidden="true"></div>

<?php
$sports_terms = get_terms(
	array(
		'taxonomy'   => 'sport',
		'hide_empty' => false,
		'orderby'    => 'name',
		'order'      => 'ASC',
		'number'     => 10,
	)
);
$has_sports   = ! empty( $sports_terms ) && ! is_wp_error( $sports_terms );
$default_sports = array( 'AFL', 'NRL', 'Cricket', 'Soccer', 'Basketball', 'Rugby', 'Tennis', 'Motorsport', 'Golf', 'Individual Sport' );
?>

<!-- Site header -->
<header class="site-header js-site-header" role="banner">
  <div class="container site-header-inner">
    <!-- Brand / logo -->
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand" aria-label="<?php esc_attr_e( 'Ripper Sports home', 'ripper-sports' ); ?>">
      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-original.png?v=' . filemtime( get_template_directory() . '/assets/images/logo-original.png' ) ); ?>" alt="<?php esc_attr_e( 'Ripper Sports', 'ripper-sports' ); ?>" class="brand-logo" width="72" height="72">
    </a>

    <!-- Primary navigation — broadcast masthead (desktop + iPad) -->
    <nav class="primary-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'ripper-sports' ); ?>">
      <div class="nav-row">
        <div class="nav-rail js-nav-rail" aria-hidden="true"></div>
        <ul class="primary-nav-list">
          <li class="primary-nav-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" data-nav-key="home" class="primary-nav-link js-nav-home"><span class="nav-pip" aria-hidden="true"></span><?php esc_html_e( 'Home', 'ripper-sports' ); ?></a></li>
          <li class="primary-nav-item"><a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" data-nav-key="news" class="primary-nav-link js-nav-news"><span class="nav-pip" aria-hidden="true"></span><?php esc_html_e( 'News', 'ripper-sports' ); ?></a></li>
          <li class="primary-nav-item has-mega-menu">
            <button data-nav-key="sports" class="primary-nav-link js-nav-sports" aria-haspopup="true" aria-expanded="false">
              <span class="nav-pip" aria-hidden="true"></span>
              <span class="primary-nav-label"><?php esc_html_e( 'Sports', 'ripper-sports' ); ?></span>
              <svg class="nav-chevron" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6z"/></svg>
            </button>
            <div class="mega-menu" role="menu">
              <div class="mega-menu-grid mega-menu-grid--three">
                <div class="mega-menu-featured">
                  <span class="mega-menu-label"><?php esc_html_e( 'Trending', 'ripper-sports' ); ?></span>
                  <a href="<?php echo esc_url( home_url( '/?s=' . rawurlencode( 'AFL' ) ) ); ?>" class="mega-menu-featured-link">
                    <span class="mega-menu-sport-icon" aria-hidden="true">🏉</span>
                    <span><?php esc_html_e( 'AFL Finals Hub', 'ripper-sports' ); ?></span>
                  </a>
                  <a href="<?php echo esc_url( home_url( '/?s=' . rawurlencode( 'NRL' ) ) ); ?>" class="mega-menu-featured-link">
                    <span class="mega-menu-sport-icon" aria-hidden="true">🏉</span>
                    <span><?php esc_html_e( 'NRL Ladder', 'ripper-sports' ); ?></span>
                  </a>
                  <a href="<?php echo esc_url( home_url( '/?s=' . rawurlencode( 'Cricket' ) ) ); ?>" class="mega-menu-featured-link">
                    <span class="mega-menu-sport-icon" aria-hidden="true">🏏</span>
                    <span><?php esc_html_e( 'Cricket Central', 'ripper-sports' ); ?></span>
                  </a>
                </div>
                <div class="mega-menu-list">
                  <span class="mega-menu-label"><?php esc_html_e( 'All Sports', 'ripper-sports' ); ?></span>
                  <div class="mega-menu-links">
                    <?php
                    if ( $has_sports ) :
                      foreach ( $sports_terms as $sport ) :
                        $sport_slug_class = sanitize_html_class( 'mega-menu-link--' . $sport->slug );
                        ?>
                        <a href="<?php echo esc_url( get_term_link( $sport ) ); ?>" class="mega-menu-link <?php echo esc_attr( $sport_slug_class ); ?>" role="menuitem"><span class="mega-menu-chip" aria-hidden="true"></span><?php echo esc_html( $sport->name ); ?></a>
                        <?php
                      endforeach;
                    else :
                      foreach ( $default_sports as $sport ) :
                        $sport_slug_class = sanitize_html_class( 'mega-menu-link--' . strtolower( str_replace( ' ', '-', $sport ) ) );
                        ?>
                        <a href="<?php echo esc_url( home_url( '/?s=' . rawurlencode( $sport ) ) ); ?>" class="mega-menu-link <?php echo esc_attr( $sport_slug_class ); ?>" role="menuitem"><span class="mega-menu-chip" aria-hidden="true"></span><?php echo esc_html( $sport ); ?></a>
                        <?php
                      endforeach;
                    endif;
                    ?>
                  </div>
                </div>
                <div class="mega-menu-now">
                  <span class="mega-menu-label"><?php esc_html_e( 'On Now', 'ripper-sports' ); ?></span>
                  <a href="<?php echo esc_url( get_post_type_archive_link( 'match' ) ); ?>" class="mega-menu-now-card">
                    <span class="mega-menu-now-pulse" aria-hidden="true"></span>
                    <span class="mega-menu-now-count"><?php echo esc_html( ripper_sports_count_active_matches() ); ?></span>
                    <span class="mega-menu-now-label"><?php esc_html_e( 'Live matches', 'ripper-sports' ); ?></span>
                  </a>
                  <p class="mega-menu-now-hint"><?php esc_html_e( 'Live scores & stats hub — coming soon', 'ripper-sports' ); ?></p>
                </div>
              </div>
            </div>
          </li>
          <li class="primary-nav-item"><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'about' ) ) ); ?>" data-nav-key="about" class="primary-nav-link js-nav-about"><span class="nav-pip" aria-hidden="true"></span><?php esc_html_e( 'About', 'ripper-sports' ); ?></a></li>
          <li class="primary-nav-item"><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>" data-nav-key="contact" class="primary-nav-link js-nav-contact"><span class="nav-pip" aria-hidden="true"></span><?php esc_html_e( 'Contact', 'ripper-sports' ); ?></a></li>
        </ul>
      </div>
    </nav>

    <!-- Header actions cluster -->
    <div class="header-actions">
      <button class="icon-btn search-trigger js-search-trigger" aria-label="<?php esc_attr_e( 'Open search', 'ripper-sports' ); ?>" aria-expanded="false">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
      </button>
      <a href="#newsletter" class="btn btn-primary header-subscribe js-header-subscribe-text"><?php esc_html_e( 'Subscribe', 'ripper-sports' ); ?></a>
      <a href="#newsletter" class="icon-btn header-subscribe-icon js-header-subscribe-icon" aria-label="<?php esc_attr_e( 'Subscribe to newsletter', 'ripper-sports' ); ?>">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/></svg>
      </a>
      <button class="icon-btn mobile-menu-btn js-mobile-menu-open" aria-label="<?php esc_attr_e( 'Open menu', 'ripper-sports' ); ?>" aria-expanded="false" aria-controls="mobile-nav">
        <span class="hamburger" aria-hidden="true"><span></span><span></span><span></span></span>
      </button>
    </div>
  </div>

  <!-- Accent strip — date / tagline / live indicator -->
  <div class="header-accent-strip">
    <div class="container header-accent-strip-inner">
      <div class="accent-cell accent-cell--date">
        <span class="accent-pulse" aria-hidden="true"></span>
        <span class="accent-text"><?php echo esc_html( strtoupper( gmdate( 'D &#183; j M' ) ) ); ?></span>
      </div>
      <div class="accent-cell accent-cell--tagline">
        <?php
        // Get the most recent post title, fall back to the morning report copy.
        $ripper_accent_latest = get_posts(
          array(
            'numberposts' => 1,
            'post_status' => 'publish',
          )
        );
        if ( ! empty( $ripper_accent_latest ) ) {
          echo esc_html__( 'Out now: ', 'ripper-sports' ) . esc_html( $ripper_accent_latest[0]->post_title );
        } else {
          esc_html_e( 'The Morning Ripper — out now', 'ripper-sports' );
        }
        ?>
      </div>
      <div class="accent-cell accent-cell--live">
        <a href="<?php echo esc_url( get_post_type_archive_link( 'match' ) ); ?>" class="accent-live-link">
          <span class="accent-live-pulse" aria-hidden="true"></span>
          <span class="accent-live-count"><?php echo esc_html( ripper_sports_count_active_matches() ); ?></span>
          <?php esc_html_e( 'LIVE', 'ripper-sports' ); ?>
        </a>
      </div>
    </div>
  </div>
</header>

<!-- Mobile off-canvas navigation -->
<div class="overlay js-overlay" aria-hidden="true"></div>
<nav id="mobile-nav" class="mobile-nav js-mobile-nav" aria-label="<?php esc_attr_e( 'Mobile navigation', 'ripper-sports' ); ?>">
  <div class="mobile-nav-header">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-nav-brand">
      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-original.png?v=' . filemtime( get_template_directory() . '/assets/images/logo-original.png' ) ); ?>" alt="<?php esc_attr_e( 'Ripper Sports', 'ripper-sports' ); ?>" width="64" height="64">
    </a>
    <button class="icon-btn js-mobile-menu-close" aria-label="<?php esc_attr_e( 'Close menu', 'ripper-sports' ); ?>">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
    </button>
  </div>

  <div class="mobile-nav-search">
    <form class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
      <span class="search-icon" aria-hidden="true">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
      </span>
      <input type="search" name="s" class="search-input" placeholder="<?php esc_attr_e( 'Search...', 'ripper-sports' ); ?>" aria-label="<?php esc_attr_e( 'Search Ripper Sports', 'ripper-sports' ); ?>">
    </form>
  </div>

  <ul class="mobile-nav-list">
    <li class="mobile-nav-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-nav-link js-nav-home"><?php esc_html_e( 'Home', 'ripper-sports' ); ?></a></li>
    <li class="mobile-nav-item"><a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" class="mobile-nav-link js-nav-news"><?php esc_html_e( 'News', 'ripper-sports' ); ?></a></li>
    <li class="mobile-nav-item">
      <button class="mobile-nav-link js-mobile-submenu-toggle" aria-expanded="false" aria-controls="mobile-sports-submenu">
        <span><?php esc_html_e( 'Sports', 'ripper-sports' ); ?></span>
        <svg class="mobile-nav-toggle" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6z"/></svg>
      </button>
      <ul id="mobile-sports-submenu" class="mobile-submenu js-mobile-submenu">
		<?php
		if ( $has_sports ) :
			foreach ( $sports_terms as $sport ) :
				?>
				<li><a href="<?php echo esc_url( get_term_link( $sport ) ); ?>" class="mobile-submenu-link"><?php echo esc_html( $sport->name ); ?></a></li>
				<?php
			endforeach;
		else :
			foreach ( $default_sports as $sport ) :
				?>
				<li><a href="<?php echo esc_url( home_url( '/?s=' . rawurlencode( $sport ) ) ); ?>" class="mobile-submenu-link"><?php echo esc_html( $sport ); ?></a></li>
				<?php
			endforeach;
		endif;
		?>
      </ul>
    </li>
    <li class="mobile-nav-item"><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'about' ) ) ); ?>" class="mobile-nav-link js-nav-about"><?php esc_html_e( 'About', 'ripper-sports' ); ?></a></li>
    <li class="mobile-nav-item"><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>" class="mobile-nav-link js-nav-contact"><?php esc_html_e( 'Contact', 'ripper-sports' ); ?></a></li>
  </ul>

  <div class="mobile-nav-footer">
    <a href="#newsletter" class="btn btn-primary w-full"><?php esc_html_e( 'Subscribe to Ripper Sports', 'ripper-sports' ); ?></a>
  </div>
</nav>

<!-- Search overlay -->
<div class="overlay js-search-overlay" aria-hidden="true">
  <div class="container search-overlay-inner">
    <div class="search-overlay-card" role="dialog" aria-label="<?php esc_attr_e( 'Search Ripper Sports', 'ripper-sports' ); ?>">
      <div class="search-overlay-header">
        <h2 class="text-headline-md text-gold"><?php esc_html_e( 'Search', 'ripper-sports' ); ?></h2>
        <button class="icon-btn js-search-close" aria-label="<?php esc_attr_e( 'Close search', 'ripper-sports' ); ?>">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
        </button>
      </div>
      <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
        <div class="newsletter-inline">
          <input type="search" name="s" class="form-input js-search-overlay-input" placeholder="<?php esc_attr_e( 'Search athletes, teams, stories...', 'ripper-sports' ); ?>" aria-label="<?php esc_attr_e( 'Search query', 'ripper-sports' ); ?>" autofocus>
          <button type="submit" class="btn btn-primary"><?php esc_html_e( 'Search', 'ripper-sports' ); ?></button>
        </div>
      </form>
    </div>
  </div>
</div>
