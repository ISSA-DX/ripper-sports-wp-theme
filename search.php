<?php
/**
 * The template for displaying search results pages
 *
 * @package Ripper_Sports
 */

get_header();
?>

<main id="main-content" class="section">
  <div class="container">
    <header class="page-header mb-8">
      <h1 class="section-title">
        <?php
        printf(
          /* translators: %s: search query. */
          esc_html__( 'Search results for: %s', 'ripper-sports' ),
          '<span class="text-gold">' . get_search_query() . '</span>'
        );
        ?>
      </h1>
    </header>

    <div class="grid-auto">
      <?php
      if ( have_posts() ) :
        while ( have_posts() ) :
          the_post();
          get_template_part( 'template-parts/content', 'card' );
        endwhile;
      else :
        get_template_part( 'template-parts/content', 'none' );
      endif;
      ?>
    </div>

    <?php the_posts_pagination(); ?>
  </div>
</main>

<?php
get_footer();
