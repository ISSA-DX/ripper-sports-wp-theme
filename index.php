<?php
/**
 * The main template file
 *
 * @package Ripper_Sports
 */

get_header();
?>

<main id="main-content" class="section" data-drift="0.04">
  <div class="container">
    <header class="page-header page-header--accent mb-8 reveal">
      <h1 class="text-display text-cream"><?php single_post_title(); ?></h1>
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
      <div class="topic-pills mb-8 reveal-stagger" aria-label="<?php esc_attr_e( 'Topics', 'ripper-sports' ); ?>">
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
