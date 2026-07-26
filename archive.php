<?php
/**
 * The template for displaying archive pages
 *
 * @package Ripper_Sports
 */

get_header();
?>

<main id="main-content" class="section" data-drift="0.04">
  <div class="container">
    <header class="page-header page-header--accent mb-8 reveal">
      <?php
      the_archive_title( '<h1 class="text-display text-cream">', '</h1>' );
      the_archive_description( '<p class="text-body-lg text-muted">', '</p>' );
      ?>
    </header>

    <?php
    $sport_terms = get_terms(
      array(
        'taxonomy'   => 'sport',
        'hide_empty' => true,
      )
    );
    if ( ! empty( $sport_terms ) && ! is_wp_error( $sport_terms ) ) :
      ?>
      <div class="topic-pills mb-8" aria-label="<?php esc_attr_e( 'Topics', 'ripper-sports' ); ?>">
        <?php foreach ( $sport_terms as $sport_term ) : ?>
          <button class="tag js-topic-pill" type="button"><?php echo esc_html( $sport_term->name ); ?></button>
        <?php endforeach; ?>
      </div>
      <?php
    endif;
    ?>

    <div class="grid-auto reveal-stagger">
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
