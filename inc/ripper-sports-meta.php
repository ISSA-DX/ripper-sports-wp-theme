<?php
/**
 * Ripper Sports — Post Meta & Meta Boxes
 *
 * Registers every custom field used by the homepage, single article, and
 * match score ticker. Renders three editor meta boxes:
 *   1. Breaking / Feature / Editor's Pick (for `post`)
 *   2. Match Scores                 (for `match`)
 *
 * @package Ripper_Sports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register all custom meta keys (REST-enabled so the block editor can use them).
 */
function ripper_sports_register_meta() {
	$post_meta = array(
		'_rs_is_breaking'         => array( 'type' => 'boolean', 'default' => false ),
		'_rs_breaking_priority'   => array( 'type' => 'integer', 'default' => 10 ),
		'_rs_feature_on_front'    => array( 'type' => 'boolean', 'default' => false ),
		'_rs_editor_pick'         => array( 'type' => 'boolean', 'default' => false ),
		'_rs_pick_order'          => array( 'type' => 'integer', 'default' => 10 ),
		'_rs_standfirst'          => array( 'type' => 'string',  'default' => '' ),
		'_rs_like_count'          => array( 'type' => 'integer', 'default' => 0 ),
		'_rs_share_count'         => array( 'type' => 'integer', 'default' => 0 ),
		'_rs_view_count'          => array( 'type' => 'integer', 'default' => 0 ),
	);

	foreach ( $post_meta as $key => $config ) {
		register_post_meta(
			'post',
			$key,
			array(
				'show_in_rest'  => true,
				'single'        => true,
				'type'          => $config['type'],
				'default'       => $config['default'],
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
				'sanitize_callback' => 'ripper_sports_sanitize_meta',
			)
		);
	}

	$match_meta = array(
		'_rs_match_team_home'    => array( 'type' => 'string',  'default' => '' ),
		'_rs_match_team_away'    => array( 'type' => 'string',  'default' => '' ),
		'_rs_match_score_home'   => array( 'type' => 'string',  'default' => '' ),
		'_rs_match_score_away'   => array( 'type' => 'string',  'default' => '' ),
		'_rs_match_status'       => array( 'type' => 'string',  'default' => 'upcoming' ),
		'_rs_match_clock'        => array( 'type' => 'string',  'default' => '' ),
		'_rs_match_competition'  => array( 'type' => 'string',  'default' => '' ),
		'_rs_match_starts_at'    => array( 'type' => 'string',  'default' => '' ),
		'_rs_match_is_live'      => array( 'type' => 'boolean', 'default' => false ),
	);

	foreach ( $match_meta as $key => $config ) {
		register_post_meta(
			'match',
			$key,
			array(
				'show_in_rest'  => true,
				'single'        => true,
				'type'          => $config['type'],
				'default'       => $config['default'],
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
				'sanitize_callback' => 'ripper_sports_sanitize_meta',
			)
		);
	}
}
add_action( 'init', 'ripper_sports_register_meta' );

/**
 * Generic sanitizer for registered meta.
 *
 * @param mixed $value Raw value from the editor.
 * @return mixed Sanitized value.
 */
function ripper_sports_sanitize_meta( $value ) {
	if ( is_bool( $value ) || is_int( $value ) ) {
		return $value;
	}
	if ( is_string( $value ) ) {
		// Booleans arrive as "1"/"0"/"true"/"false" from the classic editor.
		if ( '1' === $value || 'true' === $value ) {
			return true;
		}
		if ( '0' === $value || 'false' === $value ) {
			return false;
		}
		return sanitize_text_field( $value );
	}
	return '';
}

/**
 * Add the Breaking / Feature / Editor's Pick meta box to the post editor.
 */
function ripper_sports_add_post_meta_boxes() {
	add_meta_box(
		'rs_curation',
		__( 'Editorial Curation', 'ripper-sports' ),
		'ripper_sports_render_curation_metabox',
		'post',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'ripper_sports_add_post_meta_boxes' );

/**
 * Render the curation meta box.
 *
 * @param WP_Post $post Current post.
 */
function ripper_sports_render_curation_metabox( $post ) {
	wp_nonce_field( 'ripper_sports_curation', 'ripper_sports_curation_nonce' );

	$is_breaking       = (bool) get_post_meta( $post->ID, '_rs_is_breaking', true );
	$breaking_priority = (int)  get_post_meta( $post->ID, '_rs_breaking_priority', true );
	$is_featured       = (bool) get_post_meta( $post->ID, '_rs_feature_on_front', true );
	$is_pick           = (bool) get_post_meta( $post->ID, '_rs_editor_pick', true );
	$pick_order        = (int)  get_post_meta( $post->ID, '_rs_pick_order', true );
	$standfirst        = (string) get_post_meta( $post->ID, '_rs_standfirst', true );
	?>
	<p>
		<label>
			<input type="checkbox" name="_rs_is_breaking" value="1" <?php checked( $is_breaking, true ); ?>>
			<?php esc_html_e( 'Show as Breaking News', 'ripper-sports' ); ?>
		</label>
	</p>
	<p>
		<label for="_rs_breaking_priority"><?php esc_html_e( 'Breaking priority (lower = earlier)', 'ripper-sports' ); ?></label>
		<input type="number" min="1" max="99" step="1" id="_rs_breaking_priority" name="_rs_breaking_priority" value="<?php echo esc_attr( $breaking_priority ?: 10 ); ?>" class="widefat">
	</p>
	<hr>
	<p>
		<label>
			<input type="checkbox" name="_rs_feature_on_front" value="1" <?php checked( $is_featured, true ); ?>>
			<?php esc_html_e( 'Feature on Front Page hero', 'ripper-sports' ); ?>
		</label>
	</p>
	<hr>
	<p>
		<label>
			<input type="checkbox" name="_rs_editor_pick" value="1" <?php checked( $is_pick, true ); ?>>
			<?php esc_html_e( 'Editor\'s Pick', 'ripper-sports' ); ?>
		</label>
	</p>
	<p>
		<label for="_rs_pick_order"><?php esc_html_e( 'Pick order (1, 2, 3…)', 'ripper-sports' ); ?></label>
		<input type="number" min="1" max="99" step="1" id="_rs_pick_order" name="_rs_pick_order" value="<?php echo esc_attr( $pick_order ?: 10 ); ?>" class="widefat">
	</p>
	<hr>
	<p>
		<label for="_rs_standfirst"><?php esc_html_e( 'Standfirst / lede paragraph (optional)', 'ripper-sports' ); ?></label>
		<textarea id="_rs_standfirst" name="_rs_standfirst" rows="3" class="widefat"><?php echo esc_textarea( $standfirst ); ?></textarea>
	</p>
	<?php
}

/**
 * Persist the curation meta box.
 *
 * @param int $post_id Post ID.
 */
function ripper_sports_save_curation_metabox( $post_id ) {
	if ( ! isset( $_POST['ripper_sports_curation_nonce'] ) ) {
		return;
		}
		$nonce = sanitize_text_field( wp_unslash( $_POST['ripper_sports_curation_nonce'] ) );
	if ( ! wp_verify_nonce( $nonce, 'ripper_sports_curation' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = array(
		'_rs_is_breaking'       => 'bool',
		'_rs_feature_on_front'  => 'bool',
		'_rs_editor_pick'       => 'bool',
		'_rs_breaking_priority' => 'int',
		'_rs_pick_order'        => 'int',
		'_rs_standfirst'        => 'string',
	);

	foreach ( $fields as $key => $type ) {
		$value = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : ( 'bool' === $type ? '' : '' );
		if ( 'bool' === $type ) {
			update_post_meta( $post_id, $key, ! empty( $value ) );
		} elseif ( 'int' === $type ) {
			update_post_meta( $post_id, $key, absint( $value ) );
		} else {
			update_post_meta( $post_id, $key, sanitize_text_field( $value ) );
		}
	}
}
add_action( 'save_post_post', 'ripper_sports_save_curation_metabox' );

/**
 * Add the Match Scores meta box to the match editor.
 */
function ripper_sports_add_match_meta_boxes() {
	add_meta_box(
		'rs_match_scores',
		__( 'Match Scores', 'ripper-sports' ),
		'ripper_sports_render_match_metabox',
		'match',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'ripper_sports_add_match_meta_boxes' );

/**
 * Render the match scores meta box.
 *
 * @param WP_Post $post Current post.
 */
function ripper_sports_render_match_metabox( $post ) {
	wp_nonce_field( 'ripper_sports_match', 'ripper_sports_match_nonce' );

	$team_home     = (string) get_post_meta( $post->ID, '_rs_match_team_home', true );
	$team_away     = (string) get_post_meta( $post->ID, '_rs_match_team_away', true );
	$score_home    = (string) get_post_meta( $post->ID, '_rs_match_score_home', true );
	$score_away    = (string) get_post_meta( $post->ID, '_rs_match_score_away', true );
	$status        = (string) get_post_meta( $post->ID, '_rs_match_status', true );
	$clock         = (string) get_post_meta( $post->ID, '_rs_match_clock', true );
	$competition   = (string) get_post_meta( $post->ID, '_rs_match_competition', true );
	$starts_at     = (string) get_post_meta( $post->ID, '_rs_match_starts_at', true );
	$is_live       = (bool)   get_post_meta( $post->ID, '_rs_match_is_live', true );

	$statuses = array(
		'live'      => __( 'Live', 'ripper-sports' ),
		'full-time' => __( 'Full Time', 'ripper-sports' ),
		'upcoming'  => __( 'Upcoming', 'ripper-sports' ),
	);
	?>
	<table class="form-table" role="presentation">
		<tr>
			<th scope="row"><label for="_rs_match_team_home"><?php esc_html_e( 'Home team (3-letter abbr)', 'ripper-sports' ); ?></label></th>
			<td><input type="text" id="_rs_match_team_home" name="_rs_match_team_home" value="<?php echo esc_attr( $team_home ); ?>" class="regular-text" maxlength="6"></td>
		</tr>
		<tr>
			<th scope="row"><label for="_rs_match_score_home"><?php esc_html_e( 'Home score', 'ripper-sports' ); ?></label></th>
			<td><input type="text" id="_rs_match_score_home" name="_rs_match_score_home" value="<?php echo esc_attr( $score_home ); ?>" class="regular-text" maxlength="10"></td>
		</tr>
		<tr>
			<th scope="row"><label for="_rs_match_team_away"><?php esc_html_e( 'Away team (3-letter abbr)', 'ripper-sports' ); ?></label></th>
			<td><input type="text" id="_rs_match_team_away" name="_rs_match_team_away" value="<?php echo esc_attr( $team_away ); ?>" class="regular-text" maxlength="6"></td>
		</tr>
		<tr>
			<th scope="row"><label for="_rs_match_score_away"><?php esc_html_e( 'Away score', 'ripper-sports' ); ?></label></th>
			<td><input type="text" id="_rs_match_score_away" name="_rs_match_score_away" value="<?php echo esc_attr( $score_away ); ?>" class="regular-text" maxlength="10"></td>
		</tr>
		<tr>
			<th scope="row"><label for="_rs_match_status"><?php esc_html_e( 'Status', 'ripper-sports' ); ?></label></th>
			<td>
				<select id="_rs_match_status" name="_rs_match_status">
					<?php foreach ( $statuses as $key => $label ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $status, $key ); ?>><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="_rs_match_clock"><?php esc_html_e( 'Clock / period', 'ripper-sports' ); ?></label></th>
			<td><input type="text" id="_rs_match_clock" name="_rs_match_clock" value="<?php echo esc_attr( $clock ); ?>" class="regular-text" placeholder="<?php esc_attr_e( 'Q4 02:14 / Full Time / Day 1', 'ripper-sports' ); ?>"></td>
		</tr>
		<tr>
			<th scope="row"><label for="_rs_match_competition"><?php esc_html_e( 'Competition', 'ripper-sports' ); ?></label></th>
			<td><input type="text" id="_rs_match_competition" name="_rs_match_competition" value="<?php echo esc_attr( $competition ); ?>" class="regular-text" placeholder="<?php esc_attr_e( 'AFL / NRL / Cricket', 'ripper-sports' ); ?>"></td>
		</tr>
		<tr>
			<th scope="row"><label for="_rs_match_starts_at"><?php esc_html_e( 'Starts at (ISO datetime)', 'ripper-sports' ); ?></label></th>
			<td><input type="datetime-local" id="_rs_match_starts_at" name="_rs_match_starts_at" value="<?php echo esc_attr( $starts_at ); ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Is live now', 'ripper-sports' ); ?></th>
			<td>
				<label>
					<input type="checkbox" name="_rs_match_is_live" value="1" <?php checked( $is_live, true ); ?>>
					<?php esc_html_e( 'Show in live ticker', 'ripper-sports' ); ?>
				</label>
			</td>
		</tr>
	</table>
	<?php
}

/**
 * Persist the match meta box.
 *
 * @param int $post_id Post ID.
 */
function ripper_sports_save_match_metabox( $post_id ) {
	if ( ! isset( $_POST['ripper_sports_match_nonce'] ) ) {
		return;
	}
	$nonce = sanitize_text_field( wp_unslash( $_POST['ripper_sports_match_nonce'] ) );
	if ( ! wp_verify_nonce( $nonce, 'ripper_sports_match' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$text_fields = array(
		'_rs_match_team_home',
		'_rs_match_team_away',
		'_rs_match_score_home',
		'_rs_match_score_away',
		'_rs_match_status',
		'_rs_match_clock',
		'_rs_match_competition',
		'_rs_match_starts_at',
	);
	foreach ( $text_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}

	update_post_meta( $post_id, '_rs_match_is_live', ! empty( $_POST['_rs_match_is_live'] ) );
}
add_action( 'save_post_match', 'ripper_sports_save_match_metabox' );

/**
 * AJAX handler: increment a like/share count on a post.
 *
 * POST params:
 *   post_id (int)  — target post ID
 *   type    (str)  — 'like' or 'share'
 *   nonce   (str)  — `ripper_sports_reaction` nonce
 *
 * Returns JSON { success: bool, data: { count: int } }
 */
function ripper_sports_reaction_handler() {
	$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'ripper_sports_reaction' ) ) {
		wp_send_json_error( __( 'Invalid nonce.', 'ripper-sports' ), 403 );
	}

	$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
	$type    = isset( $_POST['type'] ) ? sanitize_key( wp_unslash( $_POST['type'] ) ) : '';

	if ( ! $post_id || ! in_array( $type, array( 'like', 'share' ), true ) ) {
		wp_send_json_error( __( 'Bad request.', 'ripper-sports' ), 400 );
	}

	$key = '_rs_' . $type . '_count';
	$current = (int) get_post_meta( $post_id, $key, true );
	$new      = $current + 1;
	update_post_meta( $post_id, $key, $new );

	wp_send_json_success( array( 'count' => $new ) );
}
add_action( 'wp_ajax_ripper_sports_reaction', 'ripper_sports_reaction_handler' );
add_action( 'wp_ajax_nopriv_ripper_sports_reaction', 'ripper_sports_reaction_handler' );
