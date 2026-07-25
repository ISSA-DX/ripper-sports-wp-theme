<?php
/**
 * Floating Sports Balls Background
 *
 * A fixed-position decorative layer with 8 hand-drawn sports balls.
 * Scroll = parallax drift (each ball has its own speed).
 * Cursor = gentle repulsion within ~140px radius.
 * Disabled entirely when prefers-reduced-motion: reduce.
 *
 * Marked aria-hidden because it is purely decorative.
 *
 * @package Ripper_Sports
 */

/* Each ball: sport, x%, y%, size px, parallax speed, rotation speed.
   Speeds are fractional multipliers relative to scroll. */
$balls = array(
	array( 'afl',         6,  18, 70, 0.18, 0.4, '#FFD996' ),
	array( 'rugby',       78, 12, 90, 0.32, -0.5, '#A8B5AE' ),
	array( 'soccer',      22, 64, 100, 0.10, 0.3, '#F4EFE3' ),
	array( 'basketball',  88, 58, 80, 0.22, -0.4, '#E07A26' ),
	array( 'cricket',     4,  82, 60, 0.14, 0.6, '#E63946' ),
	array( 'tennis',      62, 86, 50, 0.08, -0.7, '#D2F25E' ),
	array( 'baseball',    44, 36, 75, 0.26, 0.2, '#F4EFE3' ),
	array( 'volleyball',  70, 44, 85, 0.20, -0.3, '#FFD996' ),
);
?>
<div class="bg-animation" aria-hidden="true" data-bg-animation>
	<?php foreach ( $balls as $b ) :
		$sport = $b[0]; $x = $b[1]; $y = $b[2]; $size = $b[3];
		$speed = $b[4]; $rot = $b[5]; $stroke = $b[6];
		?>
		<div class="bg-ball bg-ball--<?php echo esc_attr( $sport ); ?>"
			style="left:<?php echo esc_attr( $x ); ?>%; top:<?php echo esc_attr( $y ); ?>%; width:<?php echo esc_attr( $size ); ?>px; height:<?php echo esc_attr( $size ); ?>px; --bg-parallax: <?php echo esc_attr( $speed ); ?>; --bg-rotation: <?php echo esc_attr( $rot ); ?>; --bg-stroke: <?php echo esc_attr( $stroke ); ?>;">
			<svg viewBox="0 0 100 100" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
				<?php
				switch ( $sport ) {
					case 'afl':
						/* AFL: red oval with a white cross/panel line. */
						echo '<ellipse cx="50" cy="50" rx="46" ry="30" fill="rgba(230,57,70,0.85)" stroke="#fff" stroke-width="1.5" />';
						echo '<path d="M50 22 Q40 50 50 78 M50 22 Q60 50 50 78" fill="none" stroke="#fff" stroke-width="1.5" />';
						echo '<line x1="6" y1="50" x2="94" y2="50" stroke="#fff" stroke-width="1.5" />';
						break;
					case 'rugby':
						/* Rugby ball: brown oval with stitching. */
						echo '<ellipse cx="50" cy="50" rx="48" ry="28" fill="rgba(110,72,42,0.85)" stroke="#fff" stroke-width="1.5" />';
						echo '<line x1="14" y1="50" x2="86" y2="50" stroke="#fff" stroke-width="1" stroke-dasharray="3 2" />';
						break;
					case 'soccer':
						/* Soccer ball: black & white pentagons. */
						echo '<circle cx="50" cy="50" r="46" fill="rgba(244,239,227,0.92)" stroke="#000" stroke-width="1.5" />';
						echo '<polygon points="50,18 60,30 55,44 45,44 40,30" fill="#000" />';
						echo '<polygon points="22,40 30,52 22,64 14,60 14,44" fill="#000" />';
						echo '<polygon points="78,40 86,44 86,60 78,64 70,52" fill="#000" />';
						echo '<polygon points="50,82 60,70 70,76 64,90 36,90 30,76 40,70" fill="#000" />';
						break;
					case 'basketball':
						/* Basketball: orange with seams. */
						echo '<circle cx="50" cy="50" r="46" fill="rgba(224,122,38,0.88)" stroke="#000" stroke-width="1.5" />';
						echo '<line x1="4" y1="50" x2="96" y2="50" stroke="#000" stroke-width="1.5" />';
						echo '<line x1="50" y1="4" x2="50" y2="96" stroke="#000" stroke-width="1.5" />';
						echo '<path d="M14 18 Q50 50 14 82 M86 18 Q50 50 86 82" fill="none" stroke="#000" stroke-width="1.5" />';
						break;
					case 'cricket':
						/* Cricket ball: red with raised seam. */
						echo '<circle cx="50" cy="50" r="38" fill="rgba(230,57,70,0.88)" stroke="#fff" stroke-width="1.5" />';
						echo '<path d="M18 38 Q50 50 18 62 M82 38 Q50 50 82 62" fill="none" stroke="#fff" stroke-width="1.2" />';
						echo '<line x1="22" y1="34" x2="22" y2="66" stroke="#fff" stroke-width="0.8" stroke-dasharray="2 1.5" />';
						echo '<line x1="78" y1="34" x2="78" y2="66" stroke="#fff" stroke-width="0.8" stroke-dasharray="2 1.5" />';
						break;
					case 'tennis':
						/* Tennis ball: green/yellow with seam. */
						echo '<circle cx="50" cy="50" r="40" fill="rgba(210,242,94,0.9)" stroke="#fff" stroke-width="1.5" />';
						echo '<path d="M18 30 Q50 50 18 70 M82 30 Q50 50 82 70" fill="none" stroke="#fff" stroke-width="1.8" />';
						break;
					case 'baseball':
						/* Baseball: white with red stitches. */
						echo '<circle cx="50" cy="50" r="42" fill="rgba(244,239,227,0.95)" stroke="#E63946" stroke-width="1.2" />';
						echo '<path d="M18 38 Q50 50 18 62" fill="none" stroke="#E63946" stroke-width="2" stroke-dasharray="2 2" />';
						echo '<path d="M82 38 Q50 50 82 62" fill="none" stroke="#E63946" stroke-width="2" stroke-dasharray="2 2" />';
						break;
					case 'volleyball':
						/* Volleyball: white panels with curved seams. */
						echo '<circle cx="50" cy="50" r="44" fill="rgba(244,239,227,0.92)" stroke="#000" stroke-width="1.2" />';
						echo '<path d="M14 22 Q50 50 86 22 M14 78 Q50 50 86 78 M6 50 Q50 30 94 50" fill="none" stroke="#000" stroke-width="1.2" />';
						break;
				}
				?>
			</svg>
		</div>
	<?php endforeach; ?>
</div>
