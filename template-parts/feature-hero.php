<?php
/**
 * Feature Hero (CNN-style full-bleed)
 *
 * Replaces the small hero in front-page.php. Renders the most
 * recent post marked `_rs_feature_on_front` (or the latest post
 * if none is flagged) as a full-bleed section with a layered
 * overlay, sport badge, breaking-news pulse if applicable, and
 * a CTA to the article.
 *
 * @package Ripper_Sports
 */

$hero_post = ripper_sports_get_featured_post();
if ( ! $hero_post ) {
	return;
}

$hero_id    = (int) $hero_post->ID;
$sports     = get_the_terms( $hero_id, 'sport' );
$sport      = ! empty( $sports ) && ! is_wp_error( $sports ) ? $sports[0] : null;
$is_breaking = (bool) get_post_meta( $hero_id, '_rs_is_breaking', true );

if ( has_post_thumbnail( $hero_id ) ) {
	$hero_image = get_the_post_thumbnail_url( $hero_id, 'ripper-hero' );
} else {
	$external   = get_post_meta( $hero_id, '_rs_external_image', true );
	$hero_image = $external ? $external : 'https://images.unsplash.com/photo-1518605348738-4faafbd0945d?auto=format&fit=crop&w=1600&q=80';
}
?>
<section class="feature-hero" style="background-image: url('<?php echo esc_url( $hero_image ); ?>');" aria-label="<?php esc_attr_e( 'Featured story', 'ripper-sports' ); ?>">
	<div class="feature-hero-overlay" aria-hidden="true"></div>
	<div class="feature-hero-noise" aria-hidden="true"></div>
	<div class="container feature-hero-content">
		<?php if ( $is_breaking ) : ?>
			<span class="feature-hero-breaking">
				<span class="feature-hero-pulse" aria-hidden="true"></span>
				<?php esc_html_e( 'BREAKING', 'ripper-sports' ); ?>
			</span>
		<?php endif; ?>

		<?php if ( $sport ) : ?>
			<a href="<?php echo esc_url( get_term_link( $sport ) ); ?>" class="feature-hero-sport card-tag--<?php echo esc_attr( $sport->slug ); ?>">
				<?php echo esc_html( $sport->name ); ?>
			</a>
		<?php endif; ?>

		<h1 class="feature-hero-title">
			<a href="<?php echo esc_url( get_permalink( $hero_id ) ); ?>"><?php echo esc_html( get_the_title( $hero_id ) ); ?></a>
		</h1>

		<?php
		$standfirst = get_post_meta( $hero_id, '_rs_standfirst', true );
		if ( ! $standfirst ) {
			$standfirst = get_the_excerpt( $hero_id );
		}
		if ( $standfirst ) :
			?>
			<p class="feature-hero-excerpt"><?php echo esc_html( wp_trim_words( $standfirst, 32 ) ); ?></p>
		<?php endif; ?>

		<div class="feature-hero-meta">
			<span class="feature-hero-author">
				<?php echo get_avatar( get_the_author_meta( 'ID', $hero_post->post_author ), 32, '', '', array( 'class' => 'feature-hero-avatar' ) ); ?>
				<span class="feature-hero-author-name"><?php echo esc_html( get_the_author_meta( 'display_name', $hero_post->post_author ) ); ?></span>
			</span>
			<span class="feature-hero-dot" aria-hidden="true"></span>
			<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $hero_id ) ); ?>" class="feature-hero-time">
				<?php echo esc_html( human_time_diff( get_the_time( 'U', $hero_id ), current_time( 'U' ) ) . ' ' . __( 'ago', 'ripper-sports' ) ); ?>
			</time>
			<a href="<?php echo esc_url( get_permalink( $hero_id ) ); ?>" class="feature-hero-cta">
				<?php esc_html_e( 'Read the story', 'ripper-sports' ); ?>
				<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
			</a>
		</div>
	</div>
</section>
