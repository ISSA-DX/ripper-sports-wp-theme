<?php
/**
 * Breaking News Bar
 *
 * Renders the breaking news chyron with the most recent post marked
 * `_rs_is_breaking=1`. JS handles dismiss via sessionStorage.
 *
 * @package Ripper_Sports
 */

$breaking = ripper_sports_get_breaking_post();
if ( ! $breaking ) {
	return;
}
?>
<div class="breaking-bar js-breaking-bar" role="region" aria-label="<?php esc_attr_e( 'Breaking news', 'ripper-sports' ); ?>">
	<span class="breaking-bar-label"><?php esc_html_e( 'Breaking', 'ripper-sports' ); ?></span>
	<div class="breaking-bar-track">
		<a href="<?php echo esc_url( get_permalink( $breaking ) ); ?>" class="breaking-bar-headline">
			<?php
			/* translators: %s: breaking post title */
			echo esc_html( sprintf( __( 'BREAKING: %s', 'ripper-sports' ), $breaking->post_title ) );
			?>
		</a>
	</div>
	<button class="breaking-bar-close js-breaking-bar-close" type="button" aria-label="<?php esc_attr_e( 'Dismiss breaking news', 'ripper-sports' ); ?>">
		<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
	</button>
</div>
