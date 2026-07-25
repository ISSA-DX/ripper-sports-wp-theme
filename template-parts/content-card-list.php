<?php
/**
 * Card List (horizontal small thumb)
 *
 * Used in the Editor's Picks sidebar widget and the related-stories
 * carousel. No excerpt, no reactions row — just image, tag, title.
 *
 * @package Ripper_Sports
 *
 * @var WP_Post $post
 */

if ( ! isset( $post ) ) {
	$post = get_the_ID() ? get_post() : null;
}
if ( ! $post ) {
	return;
}

if ( has_post_thumbnail( $post->ID ) ) {
	$image = get_the_post_thumbnail_url( $post->ID, 'ripper-card' );
} else {
	$external = get_post_meta( $post->ID, '_rs_external_image', true );
	$image    = $external ? $external : 'https://images.unsplash.com/photo-1518605348738-4faafbd0945d?auto=format&fit=crop&w=400&q=80';
}
$sport      = get_the_terms( $post->ID, 'sport' );
$sport_obj  = ( ! empty( $sport ) && ! is_wp_error( $sport ) ) ? $sport[0] : null;
$tag_label  = $sport_obj ? $sport_obj->name : __( 'News', 'ripper-sports' );
$tag_class  = $sport_obj ? sanitize_html_class( 'card-tag--' . $sport_obj->slug ) : 'card-tag--analysis';
?>
<article class="card card-list">
	<a href="<?php echo esc_url( get_permalink( $post ) ); ?>" class="card-image">
		<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title( $post ) ); ?>" loading="lazy">
	</a>
	<div class="card-body">
		<span class="card-tag <?php echo esc_attr( $tag_class ); ?>"><?php echo esc_html( $tag_label ); ?></span>
		<h3 class="card-title">
			<a href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a>
		</h3>
	</div>
</article>
