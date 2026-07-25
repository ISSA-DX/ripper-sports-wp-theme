<?php
/**
 * Section Heading
 *
 * Standard `<div class="section-header">` with optional "View All" link.
 *
 * Required:
 *   $title           — section title
 * Optional:
 *   $view_all_url    — destination URL for the "View All" link
 *   $view_all_label  — label text (default: 'View All')
 *
 * @package Ripper_Sports
 */

if ( empty( $title ) ) {
	return;
}

$view_all_label = isset( $view_all_label ) && $view_all_label ? $view_all_label : __( 'View All', 'ripper-sports' );
?>
<div class="section-header">
	<h2 class="section-title"><?php echo esc_html( $title ); ?></h2>
	<?php if ( ! empty( $view_all_url ) ) : ?>
		<a href="<?php echo esc_url( $view_all_url ); ?>" class="section-link"><?php echo esc_html( $view_all_label ); ?> &rarr;</a>
	<?php endif; ?>
</div>
