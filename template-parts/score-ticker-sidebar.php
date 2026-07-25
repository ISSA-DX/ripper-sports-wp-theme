<?php
/**
 * Live Scores Sidebar Widget
 *
 * Stacked vertical list of match cards for the homepage sidebar.
 * Reuses the same data hooks (data-ripper-match, data-ripper-clock,
 * data-target) as the horizontal score-ticker so initLiveTicker()
 * in main.js keeps both variants in sync.
 *
 * @package Ripper_Sports
 */

$matches = ripper_sports_get_active_matches( 4 );
?>
<div class="widget widget--live-scores">
	<div class="widget-head">
		<span class="score-ticker-pulse" aria-hidden="true"></span>
		<h3 class="widget-title widget-title--inline"><?php esc_html_e( 'Live', 'ripper-sports' ); ?></h3>
		<a class="widget-link" href="<?php echo esc_url( get_post_type_archive_link( 'match' ) ); ?>">
			<?php esc_html_e( 'All matches', 'ripper-sports' ); ?>
			<svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M10 6 8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
		</a>
	</div>

	<?php if ( empty( $matches ) ) : ?>
		<p class="live-scores-empty"><?php esc_html_e( 'No live or upcoming matches right now.', 'ripper-sports' ); ?></p>
	<?php else : ?>
		<ul class="live-scores-list">
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

				$sport_slug   = '';
				$comp_lower   = strtolower( (string) $competition );
				foreach ( array( 'afl', 'nrl', 'cricket', 'soccer', 'rugby', 'basketball', 'tennis', 'motorsport', 'boxing', 'golf' ) as $slug ) {
					if ( false !== strpos( $comp_lower, $slug ) ) {
						$sport_slug = strpos( $comp_lower, 'boxing' ) !== false ? 'boxing-mma' : $slug;
						break;
					}
				}
				?>
				<li class="live-scores-card score-ticker-card <?php echo $is_live ? 'is-live' : ( $is_final ? 'is-final' : 'is-upcoming' ); ?>"
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
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>
