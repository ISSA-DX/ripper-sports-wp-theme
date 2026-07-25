<?php
/**
 * Score Ticker (CNN-style)
 *
 * Renders a horizontal strip of live / upcoming / finished matches
 * as rich cards. Each card has a sport badge, two team rows, the
 * score, a status pill, and a clock that JS will keep ticking
 * (count-up for live, count-down for upcoming).
 *
 * The track is duplicated once for the CSS marquee loop.
 *
 * @package Ripper_Sports
 */

$matches = ripper_sports_get_active_matches( 6 );
if ( empty( $matches ) ) {
	return;
}
?>
<div class="score-ticker" aria-label="<?php esc_attr_e( 'Live scores', 'ripper-sports' ); ?>">
	<div class="score-ticker-label" aria-hidden="true">
		<span class="score-ticker-pulse" aria-hidden="true"></span>
		<?php esc_html_e( 'Live', 'ripper-sports' ); ?>
	</div>
	<div class="score-ticker-track" data-ripper-ticker>
		<?php foreach ( $matches as $match ) :
			$match_id     = (int) $match->ID;
			$status       = get_post_meta( $match_id, '_rs_match_status', true );
			$is_live      = 'live' === $status;
			$is_final     = 'full-time' === $status;
			$is_upcoming  = 'upcoming' === $status;
			$competition  = get_post_meta( $match_id, '_rs_match_competition', true );
			$team_home    = get_post_meta( $match_id, '_rs_match_team_home', true );
			$team_away    = get_post_meta( $match_id, '_rs_match_team_away', true );
			$score_home   = get_post_meta( $match_id, '_rs_match_score_home', true );
			$score_away   = get_post_meta( $match_id, '_rs_match_score_away', true );
			$clock_text   = get_post_meta( $match_id, '_rs_match_clock', true );
			$starts_at    = get_post_meta( $match_id, '_rs_match_starts_at', true );
			$starts_ts    = $starts_at ? strtotime( $starts_at . ' UTC' ) : 0;

			// Sport guess from competition string.
			$sport_slug  = '';
			$comp_lower  = strtolower( (string) $competition );
			foreach ( array( 'afl', 'nrl', 'cricket', 'soccer', 'rugby', 'basketball', 'tennis', 'motorsport', 'boxing', 'golf' ) as $slug ) {
				if ( false !== strpos( $comp_lower, $slug ) ) {
					$sport_slug = strpos( $comp_lower, 'boxing' ) !== false ? 'boxing-mma' : $slug;
					break;
				}
			}
			?>
			<div class="score-ticker-card <?php echo $is_live ? 'is-live' : ( $is_final ? 'is-final' : 'is-upcoming' ); ?>"
				data-match-id="<?php echo esc_attr( $match_id ); ?>"
				data-status="<?php echo esc_attr( $status ); ?>"
				<?php if ( $is_upcoming && $starts_ts ) : ?>
					data-starts-ts="<?php echo esc_attr( $starts_ts ); ?>"
				<?php endif; ?>
				data-ripper-match>
				<div class="score-ticker-card-head">
					<?php if ( $sport_slug ) : ?>
						<span class="score-ticker-sport card-tag--<?php echo esc_attr( $sport_slug ); ?>"><?php echo esc_html( strtoupper( str_replace( '-', '/', $sport_slug ) ) ); ?></span>
					<?php endif; ?>
					<span class="score-ticker-status-pill <?php echo $is_live ? 'is-live' : ( $is_final ? 'is-final' : 'is-upcoming' ); ?>">
						<?php if ( $is_live ) : ?>
							<span class="score-ticker-pulse" aria-hidden="true"></span>
							<?php esc_html_e( 'LIVE', 'ripper-sports' ); ?>
						<?php elseif ( $is_final ) : ?>
							<?php esc_html_e( 'FT', 'ripper-sports' ); ?>
						<?php else : ?>
							<?php esc_html_e( 'SOON', 'ripper-sports' ); ?>
						<?php endif; ?>
					</span>
				</div>

				<div class="score-ticker-card-body">
					<div class="score-ticker-team">
						<span class="score-ticker-team-name"><?php echo esc_html( $team_home ); ?></span>
						<span class="score-ticker-team-score <?php echo $is_live ? 'is-live' : ''; ?>"><?php echo esc_html( $score_home ); ?></span>
					</div>
					<div class="score-ticker-team">
						<span class="score-ticker-team-name"><?php echo esc_html( $team_away ); ?></span>
						<span class="score-ticker-team-score"><?php echo esc_html( $score_away ); ?></span>
					</div>
				</div>

				<div class="score-ticker-card-foot">
					<?php if ( $is_upcoming && $starts_ts ) : ?>
						<span class="score-ticker-clock" data-ripper-clock="down" data-target="<?php echo esc_attr( $starts_ts ); ?>">
							<?php
							$diff = max( 0, $starts_ts - time() );
							echo esc_html( gmdate( 'i:s', $diff ) );
							?>
						</span>
					<?php else : ?>
						<span class="score-ticker-clock" data-ripper-clock="<?php echo $is_live ? 'up' : 'static'; ?>">
							<?php echo esc_html( $clock_text ); ?>
						</span>
					<?php endif; ?>
					<?php if ( $competition ) : ?>
						<span class="score-ticker-comp"><?php echo esc_html( $competition ); ?></span>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>

		<?php // Duplicate the set for the marquee loop. The aria-hidden ones don't tick. ?>
		<?php foreach ( $matches as $match ) :
			$status      = get_post_meta( $match->ID, '_rs_match_status', true );
			$is_live     = 'live' === $status;
			$competition = get_post_meta( $match->ID, '_rs_match_competition', true );
			$team_home   = get_post_meta( $match->ID, '_rs_match_team_home', true );
			$team_away   = get_post_meta( $match->ID, '_rs_match_team_away', true );
			$score_home  = get_post_meta( $match->ID, '_rs_match_score_home', true );
			$score_away  = get_post_meta( $match->ID, '_rs_match_score_away', true );
			$clock_text  = get_post_meta( $match->ID, '_rs_match_clock', true );
			$sport_slug  = '';
			$comp_lower  = strtolower( (string) $competition );
			foreach ( array( 'afl', 'nrl', 'cricket', 'soccer', 'rugby', 'basketball', 'tennis', 'motorsport', 'boxing', 'golf' ) as $slug ) {
				if ( false !== strpos( $comp_lower, $slug ) ) {
					$sport_slug = strpos( $comp_lower, 'boxing' ) !== false ? 'boxing-mma' : $slug;
					break;
				}
			}
			?>
			<div class="score-ticker-card <?php echo $is_live ? 'is-live' : ( 'full-time' === $status ? 'is-final' : 'is-upcoming' ); ?>" aria-hidden="true">
				<div class="score-ticker-card-head">
					<?php if ( $sport_slug ) : ?>
						<span class="score-ticker-sport card-tag--<?php echo esc_attr( $sport_slug ); ?>"><?php echo esc_html( strtoupper( str_replace( '-', '/', $sport_slug ) ) ); ?></span>
					<?php endif; ?>
					<span class="score-ticker-status-pill <?php echo $is_live ? 'is-live' : ( 'full-time' === $status ? 'is-final' : 'is-upcoming' ); ?>">
						<?php if ( $is_live ) : ?>
							<span class="score-ticker-pulse" aria-hidden="true"></span>
							<?php esc_html_e( 'LIVE', 'ripper-sports' ); ?>
						<?php elseif ( 'full-time' === $status ) : ?>
							<?php esc_html_e( 'FT', 'ripper-sports' ); ?>
						<?php else : ?>
							<?php esc_html_e( 'SOON', 'ripper-sports' ); ?>
						<?php endif; ?>
					</span>
				</div>
				<div class="score-ticker-card-body">
					<div class="score-ticker-team">
						<span class="score-ticker-team-name"><?php echo esc_html( $team_home ); ?></span>
						<span class="score-ticker-team-score"><?php echo esc_html( $score_home ); ?></span>
					</div>
					<div class="score-ticker-team">
						<span class="score-ticker-team-name"><?php echo esc_html( $team_away ); ?></span>
						<span class="score-ticker-team-score"><?php echo esc_html( $score_away ); ?></span>
					</div>
				</div>
				<div class="score-ticker-card-foot">
					<span class="score-ticker-clock"><?php echo esc_html( $clock_text ); ?></span>
					<?php if ( $competition ) : ?>
						<span class="score-ticker-comp"><?php echo esc_html( $competition ); ?></span>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
