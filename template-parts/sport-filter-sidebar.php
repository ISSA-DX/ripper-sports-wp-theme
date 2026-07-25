<?php
/**
 * Sport Filter Sidebar
 *
 * Filter sidebar used on the sport archive (`taxonomy-sport.php`) and
 * the generic taxonomy fallback (`taxonomy.php`). Story-type checkboxes
 * and a date-range select submit via JS that adds `?story_type=...` and
 * `?date=...` query args.
 *
 * @package Ripper_Sports
 */

$queried = get_queried_object();
$term_name = ( $queried && ! is_wp_error( $queried ) && isset( $queried->name ) ) ? $queried->name : __( 'Sport', 'ripper-sports' );
?>
<aside class="filter-sidebar sticky-sidebar">
	<div class="widget">
		<h3 class="filter-title"><?php
			/* translators: %s: sport name */
			echo esc_html( sprintf( __( 'Filter %s Stories', 'ripper-sports' ), $term_name ) );
		?></h3>

		<form id="sport-filter" class="space-y-6" data-base-url="<?php echo esc_url( get_term_link( $queried ) ); ?>">
			<fieldset class="filter-group">
				<legend class="filter-group-title"><?php esc_html_e( 'Story Type', 'ripper-sports' ); ?></legend>
				<label class="filter-option form-checkbox">
					<input type="checkbox" name="story_type" value="match-report" class="js-archive-filter">
					<span><?php esc_html_e( 'Match Reports', 'ripper-sports' ); ?></span>
				</label>
				<label class="filter-option form-checkbox">
					<input type="checkbox" name="story_type" value="analysis" class="js-archive-filter">
					<span><?php esc_html_e( 'Analysis', 'ripper-sports' ); ?></span>
				</label>
				<label class="filter-option form-checkbox">
					<input type="checkbox" name="story_type" value="transfer" class="js-archive-filter">
					<span><?php esc_html_e( 'Transfer News', 'ripper-sports' ); ?></span>
				</label>
				<label class="filter-option form-checkbox">
					<input type="checkbox" name="story_type" value="injury" class="js-archive-filter">
					<span><?php esc_html_e( 'Injury Updates', 'ripper-sports' ); ?></span>
				</label>
			</fieldset>

			<fieldset class="filter-group">
				<legend class="filter-group-title"><?php esc_html_e( 'Date Range', 'ripper-sports' ); ?></legend>
				<select name="date" class="form-select">
					<option value=""><?php esc_html_e( 'All time', 'ripper-sports' ); ?></option>
					<option value="7"><?php esc_html_e( 'Last 7 days', 'ripper-sports' ); ?></option>
					<option value="30"><?php esc_html_e( 'Last 30 days', 'ripper-sports' ); ?></option>
					<option value="season"><?php esc_html_e( 'This season', 'ripper-sports' ); ?></option>
				</select>
			</fieldset>
		</form>
	</div>
</aside>
