<?php
/**
 * The main template file
 *
 * @package Ripper_Sports
 */

get_header();
?>

<main id="main-content" class="section">
  <div class="container">
    <header class="page-header mb-8">
      <h1 class="section-title"><?php single_post_title(); ?></h1>
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
