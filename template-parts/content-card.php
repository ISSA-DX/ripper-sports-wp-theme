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
$tag_class  = $sport ? sanitize_html_class( 'card-tag--' . $sport->slug ) : 'card-tag--analysis';

$avatar_url = get_avatar_url(
	get_the_author_meta( 'ID' ),
	array( 'size' => 44 )
);
if ( empty( $avatar_url ) ) {
	$avatar_url = 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80';
}

$like_count    = (int) get_post_meta( get_the_ID(), '_rs_like_count', true );
if ( ! $like_count ) {
	$like_count = ( abs( crc32( get_the_ID() . 'like' ) ) % 140 ) + 20;
}
$share_count   = (int) get_post_meta( get_the_ID(), '_rs_share_count', true );
if ( ! $share_count ) {
	$share_count = ( abs( crc32( get_the_ID() . 'share' ) ) % 30 ) + 1;
}
$comment_count = get_comments_number();

$card_image = '';
if ( has_post_thumbnail() ) {
	$card_image = get_the_post_thumbnail_url( null, 'ripper-card' );
} else {
	$external = get_post_meta( get_the_ID(), '_rs_external_image', true );
	if ( $external ) {
		$card_image = $external;
	} else {
		$card_image = 'https://images.unsplash.com/photo-1518605348738-4faafbd0945d?auto=format&fit=crop&w=800&q=80';
	}
}
?>

<article class="card">
	<a href="<?php the_permalink(); ?>" class="card-image">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'ripper-card', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
		<?php else : ?>
			<img src="<?php echo esc_url( $card_image ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
		<?php endif; ?>
		<span class="card-tag <?php echo esc_attr( $tag_class ); ?>"><?php echo esc_html( $tag ); ?></span>
	</a>
	<button class="card-bookmark js-card-bookmark" type="button" aria-label="<?php esc_attr_e( 'Bookmark article', 'ripper-sports' ); ?>" aria-pressed="false">
		<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17 3H7c-1.1 0-1.99.9-1.99 2L5 21l7-3 7 3V5c0-1.1-.9-2-2-2z"/></svg>
	</button>
	<div class="card-body">
		<h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
		<div class="card-meta">
			<div class="card-meta-left">
				<span class="card-author">
					<img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( get_the_author() ); ?>">
					<span><?php echo esc_html( get_the_author() ); ?></span>
				</span>
				<span><?php echo esc_html( human_time_diff( get_the_time( 'U' ), current_time( 'U' ) ) . ' ' . __( 'ago', 'ripper-sports' ) ); ?></span>
			</div>
			<div class="card-meta-right">
				<span class="card-reactions">
					<button class="card-reaction js-card-reaction" type="button" title="<?php esc_attr_e( 'Like article', 'ripper-sports' ); ?>" aria-label="<?php esc_attr_e( 'Like article', 'ripper-sports' ); ?>" data-reacted="false">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
						<span class="card-reaction-count"><?php echo esc_html( $like_count ); ?></span>
					</button>
					<button class="card-reaction js-card-reaction" type="button" title="<?php esc_attr_e( 'Comment on article', 'ripper-sports' ); ?>" aria-label="<?php esc_attr_e( 'Comment on article', 'ripper-sports' ); ?>" data-reacted="false">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M21.99 4c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4-.01-18z"/></svg>
						<span class="card-reaction-count"><?php echo esc_html( $comment_count ); ?></span>
					</button>
					<button class="card-reaction js-card-reaction" type="button" title="<?php esc_attr_e( 'Share article', 'ripper-sports' ); ?>" aria-label="<?php esc_attr_e( 'Share article', 'ripper-sports' ); ?>" data-reacted="false">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92s2.92-1.31 2.92-2.92-1.31-2.92-2.92-2.92z"/></svg>
						<span class="card-reaction-count"><?php echo esc_html( $share_count ); ?></span>
					</button>
				</span>
			</div>
		</div>
	</div>
</article>
