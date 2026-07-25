<?php
/**
 * Template part for displaying post cards in grids
 *
 * @package Ripper_Sports
 */

$categories = get_the_category();
$category   = ! empty( $categories ) ? $categories[0] : null;
$sports     = get_the_terms( get_the_ID(), 'sport' );
$sport      = ! empty( $sports ) && ! is_wp_error( $sports ) ? $sports[0] : null;
$tag        = $sport ? $sport->name : ( $category ? $category->name : __( 'News', 'ripper-sports' ) );
?>

<article class="card">
  <a href="<?php the_permalink(); ?>" class="card-image">
	<?php if ( has_post_thumbnail() ) : ?>
	  <?php the_post_thumbnail( 'ripper-card', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
	<?php else : ?>
	  <img src="https://images.unsplash.com/photo-1518605348738-4faafbd0945d?auto=format&fit=crop&w=800&q=80" alt="<?php the_title_attribute(); ?>" loading="lazy">
	<?php endif; ?>
    <span class="card-tag"><?php echo esc_html( $tag ); ?></span>
  </a>
  <div class="card-body">
    <span class="card-category"><?php echo esc_html( $tag ); ?></span>
    <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <p class="card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
  </div>
</article>
