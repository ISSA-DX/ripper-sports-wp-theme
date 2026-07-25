<?php
/**
 * Template part for displaying page content
 *
 * @package Ripper_Sports
 */
?>

<main id="main-content" class="section">
  <div class="container">
    <article class="editorial-content max-w-4xl mx-auto">
      <header class="mb-10">
        <?php the_title( '<h1 class="text-display text-gold mb-4">', '</h1>' ); ?>
      </header>

      <div class="entry-content">
        <?php
        the_content();

        wp_link_pages(
          array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ripper-sports' ),
            'after'  => '</div>',
          )
        );
        ?>
      </div>
    </article>
  </div>
</main>
