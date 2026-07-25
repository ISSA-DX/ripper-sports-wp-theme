<?php
/**
 * Ripper Sports — Shortcodes
 *
 * Two shortcodes for editorial body content:
 *   [rs-stat-card number="42" label="Goals"]
 *   [rs-pull-quote quote="…" cite="…"]
 *
 * @package Ripper_Sports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Stat card.
 *
 * Renders a `.stat-card` with up to four `[rs-stat]` children. Can also
 * be used inline: [rs-stat-card number="42" label="Goals"].
 *
 * @param array  $atts    Attributes.
 * @param string $content Inner content (stat children).
 * @return string HTML.
 */
function ripper_sports_stat_card_shortcode( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			'number' => '',
			'label'  => '',
		),
		$atts,
		'rs-stat-card'
	);

	if ( ! empty( $atts['number'] ) && ! empty( $atts['label'] ) ) {
		$content = sprintf(
			'<div class="stat-item"><span class="stat-value-highlight">%s</span><span class="stat-label">%s</span></div>',
			esc_html( $atts['number'] ),
			esc_html( $atts['label'] )
		);
	}

	return '<div class="stat-card"><div class="stat-grid">' . do_shortcode( $content ) . '</div></div>';
}
add_shortcode( 'rs-stat-card', 'ripper_sports_stat_card_shortcode' );

/**
 * Stat child.
 *
 * Renders a single `.stat-item` inside a `[rs-stat-card]`.
 *
 * @param array $atts Attributes.
 * @return string HTML.
 */
function ripper_sports_stat_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'number' => '',
			'label'  => '',
			'highlight' => 'false',
		),
		$atts,
		'rs-stat'
	);
	$value_class = 'stat-value' . ( 'true' === strtolower( $atts['highlight'] ) ? ' stat-value-highlight' : '' );
	return sprintf(
		'<div class="stat-item"><span class="%1$s">%2$s</span><span class="stat-label">%3$s</span></div>',
		esc_attr( $value_class ),
		esc_html( $atts['number'] ),
		esc_html( $atts['label'] )
	);
}
add_shortcode( 'rs-stat', 'ripper_sports_stat_shortcode' );

/**
 * Pull quote.
 *
 * Renders a `.pull-quote` with optional cite. Matches the design system
 * editorial-content block.
 *
 * @param array  $atts    Attributes.
 * @param string $content Quote text.
 * @return string HTML.
 */
function ripper_sports_pull_quote_shortcode( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			'cite' => '',
		),
		$atts,
		'rs-pull-quote'
	);

	$html  = '<blockquote class="pull-quote"><p>' . wp_kses_post( do_shortcode( $content ) ) . '</p>';
	if ( ! empty( $atts['cite'] ) ) {
		$html .= '<cite>' . esc_html( $atts['cite'] ) . '</cite>';
	}
	$html .= '</blockquote>';

	return $html;
}
add_shortcode( 'rs-pull-quote', 'ripper_sports_pull_quote_shortcode' );
