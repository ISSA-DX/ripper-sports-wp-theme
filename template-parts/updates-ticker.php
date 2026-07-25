<?php
/**
 * Live Updates Ticker
 *
 * A fixed-position bottom-left notification that slides in the
 * 5 most recent posts one at a time. Users can dismiss it
 * (writes a 24h cookie via JS).
 *
 * Hidden by default; JS in main.js will fade it in after 5s.
 *
 * @package Ripper_Sports
 */

$updates = new WP_Query(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 5,
		'no_found_rows'  => true,
	)
);
if ( ! $updates->have_posts() ) {
	return;
}
?>
<aside class="updates-ticker js-updates-ticker" aria-label="<?php esc_attr_e( 'Latest updates', 'ripper-sports' ); ?>" hidden>
	<div class="updates-ticker-head">
		<span class="updates-ticker-pulse" aria-hidden="true"></span>
		<span class="updates-ticker-title"><?php esc_html_e( 'Latest Updates', 'ripper-sports' ); ?></span>
		<button class="updates-ticker-close js-updates-ticker-close" type="button" aria-label="<?php esc_attr_e( 'Dismiss updates', 'ripper-sports' ); ?>">
			<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
		</button>
	</div>
	<div class="updates-ticker-list" data-ripper-updates>
		<?php
		$updates_index = 0;
		while ( $updates->have_posts() ) :
			$updates->the_post();
			$sports   = get_the_terms( get_the_ID(), 'sport' );
			$sport    = ! empty( $sports ) && ! is_wp_error( $sports ) ? $sports[0] : null;
			$is_first = 0 === $updates_index;
			?>
			<a href="<?php the_permalink(); ?>" class="updates-ticker-item <?php echo $is_first ? 'is-active' : ''; ?>" <?php echo $is_first ? '' : 'hidden'; ?>>
				<?php if ( $sport ) : ?>
					<span class="updates-ticker-sport card-tag--<?php echo esc_attr( $sport->slug ); ?>"><?php echo esc_html( $sport->name ); ?></span>
				<?php endif; ?>
				<span class="updates-ticker-headline"><?php the_title(); ?></span>
				<span class="updates-ticker-time"><?php echo esc_html( human_time_diff( get_the_time( 'U' ), current_time( 'U' ) ) . ' ' . __( 'ago', 'ripper-sports' ) ); ?></span>
			</a>
			<?php
			$updates_index++;
		endwhile;
		wp_reset_postdata();
		?>
	</div>
</aside>
