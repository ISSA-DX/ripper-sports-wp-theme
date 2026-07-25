<?php
/**
 * Card Horizontal (used on search results)
 *
 * Image on the left (~35%), body on the right with full meta
 * (author, time, reactions).
 *
 * @package Ripper_Sports
 *
 * @var WP_Post $post
 */

if ( ! isset( $post ) ) {
	global $post;
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
$like_count = (int) get_post_meta( $post->ID, '_rs_like_count', true );
?>
<article class="card card-horizontal">
	<a href="<?php echo esc_url( get_permalink( $post ) ); ?>" class="card-image">
		<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title( $post ) ); ?>" loading="lazy">
	</a>
	<div class="card-body">
		<span class="card-tag <?php echo esc_attr( $tag_class ); ?>"><?php echo esc_html( $tag_label ); ?></span>
		<h3 class="card-title">
			<a href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a>
		</h3>
		<p class="card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $post ), 24 ) ); ?></p>
		<div class="card-meta">
			<div class="card-meta-left">
				<span class="card-author"><?php echo esc_html( get_the_author_meta( 'display_name', $post->post_author ) ); ?></span>
				<span class="card-time"><?php echo esc_html( human_time_diff( get_the_time( 'U', $post ), current_time( 'U' ) ) . ' ' . __( 'ago', 'ripper-sports' ) ); ?></span>
			</div>
			<div class="card-meta-right">
				<span class="card-reaction" aria-label="<?php esc_attr_e( 'Like article', 'ripper-sports' ); ?>" data-post-id="<?php echo esc_attr( $post->ID ); ?>" data-reaction-type="like">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
					<span class="card-reaction-count"><?php echo esc_html( number_format_i18n( $like_count ) ); ?></span>
				</span>
			</div>
		</div>
	</div>
</article>
