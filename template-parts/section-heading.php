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
 *   $title_class     — class added to the heading wrapper for reveal animations
 *                      (e.g. 'reveal' for scroll-triggered fade-in)
 *
 * @package Ripper_Sports
 */

if ( empty( $title ) ) {
	return;
}

$view_all_label  = isset( $view_all_label ) && $view_all_label ? $view_all_label : __( 'View All', 'ripper-sports' );
$title_class     = isset( $title_class ) ? trim( (string) $title_class ) : '';
$wrapper_class   = 'section-header' . ( $title_class !== '' ? ' ' . $title_class : '' );
?>
<div class="<?php echo esc_attr( $wrapper_class ); ?>">
	<h2 class="section-title"><?php echo esc_html( $title ); ?></h2>
	<?php if ( ! empty( $view_all_url ) ) : ?>
		<a href="<?php echo esc_url( $view_all_url ); ?>" class="section-link"><?php echo esc_html( $view_all_label ); ?> &rarr;</a>
	<?php endif; ?>
</div>
