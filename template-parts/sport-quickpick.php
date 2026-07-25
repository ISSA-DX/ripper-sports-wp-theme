<?php
/**
 * Sport Quick-Pick Icon Row
 *
 * Horizontal row of 10 sport icons. Each is a link to the sport
 * archive. Inline SVG keeps the markup self-contained.
 *
 * @package Ripper_Sports
 */

$sports = get_terms(
	array(
		'taxonomy'   => 'sport',
		'hide_empty' => false,
		'orderby'    => 'name',
		'order'      => 'ASC',
	)
);
if ( empty( $sports ) || is_wp_error( $sports ) ) {
	return;
}

/* Inline SVG icon set. Each path is hand-drawn and minimal. */
$icons = array(
	'afl'         => '<circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" fill="none"/><ellipse cx="12" cy="12" rx="4" ry="10" stroke="currentColor" stroke-width="1.5" fill="none"/><line x1="2" y1="12" x2="22" y2="12" stroke="currentColor" stroke-width="1.5"/>',
	'nrl'         => '<ellipse cx="12" cy="12" rx="9" ry="6" stroke="currentColor" stroke-width="1.5" fill="none"/><line x1="3" y1="12" x2="21" y2="12" stroke="currentColor" stroke-width="1.5"/><circle cx="6" cy="12" r="1.5" fill="currentColor"/><circle cx="18" cy="12" r="1.5" fill="currentColor"/>',
	'cricket'     => '<rect x="9" y="2" width="6" height="14" rx="3" stroke="currentColor" stroke-width="1.5" fill="none"/><line x1="12" y1="6" x2="12" y2="10" stroke="currentColor" stroke-width="1.5"/><rect x="11" y="16" width="2" height="6" fill="currentColor"/>',
	'soccer'      => '<circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" fill="none"/><polygon points="12,7 16,10 14,15 10,15 8,10" stroke="currentColor" stroke-width="1.5" fill="none"/>',
	'rugby'       => '<ellipse cx="12" cy="12" rx="6" ry="9" stroke="currentColor" stroke-width="1.5" fill="none"/><line x1="6" y1="8" x2="18" y2="8" stroke="currentColor" stroke-width="1.5"/><line x1="6" y1="16" x2="18" y2="16" stroke="currentColor" stroke-width="1.5"/>',
	'basketball'  => '<circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M2 12 H22" stroke="currentColor" stroke-width="1.5"/><path d="M12 2 C7 7 7 17 12 22" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M12 2 C17 7 17 17 12 22" stroke="currentColor" stroke-width="1.5" fill="none"/>',
	'tennis'      => '<circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M4 6 Q12 12 4 18" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M20 6 Q12 12 20 18" stroke="currentColor" stroke-width="1.5" fill="none"/>',
	'motorsport'  => '<rect x="3" y="9" width="18" height="6" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/><circle cx="7" cy="17" r="2" stroke="currentColor" stroke-width="1.5" fill="none"/><circle cx="17" cy="17" r="2" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M6 9 L8 5 H16 L18 9" stroke="currentColor" stroke-width="1.5" fill="none"/>',
	'boxing-mma'  => '<path d="M4 12 Q4 7 8 7 L8 4 L11 4 L11 7 L13 7 L13 4 L16 4 L16 7 Q20 7 20 12 Q20 17 16 17 L13 17 L13 20 L11 20 L11 17 L8 17 Q4 17 4 12 Z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
	'golf'        => '<circle cx="12" cy="6" r="3" stroke="currentColor" stroke-width="1.5" fill="none"/><line x1="12" y1="9" x2="12" y2="20" stroke="currentColor" stroke-width="1.5"/><line x1="9" y1="18" x2="15" y2="22" stroke="currentColor" stroke-width="1.5"/><line x1="9" y1="22" x2="15" y2="18" stroke="currentColor" stroke-width="1.5"/>',
);

?>
<nav class="sport-quickpick" aria-label="<?php esc_attr_e( 'Quick pick a sport', 'ripper-sports' ); ?>">
	<div class="container">
		<div class="sport-quickpick-track">
			<?php foreach ( $sports as $sport ) :
				$slug = $sport->slug;
				$icon = isset( $icons[ $slug ] ) ? $icons[ $slug ] : '<circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" fill="none"/>';
				?>
				<a href="<?php echo esc_url( get_term_link( $sport ) ); ?>" class="sport-quickpick-item card-tag--<?php echo esc_attr( $slug ); ?>">
					<span class="sport-quickpick-icon" aria-hidden="true">
						<svg width="28" height="28" viewBox="0 0 24 24"><?php echo $icon; // Already escaped, hand-written. ?></svg>
					</span>
					<span class="sport-quickpick-label"><?php echo esc_html( $sport->name ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</nav>
