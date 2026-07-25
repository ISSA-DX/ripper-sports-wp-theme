<?php
/**
 * The template for displaying archive pages
 *
 * @package Ripper_Sports
 */

get_header();
?>

<main id="main-content" class="section">
  <div class="container">
    <header class="page-header mb-8">
      <?php
      the_archive_title( '<h1 class="section-title">', '</h1>' );
      the_archive_description( '<p class="text-body-md text-muted">', '</p>' );
      ?>
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
