<?php
/**
 * Course Records
 *
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 * @package course-records
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

if ( ! class_exists( 'User_Meta' ) ) {

	/**
	 * User Meta
	 *
	 * @since 0.0.1
	 */
	class User_Meta {

		/**
		 * Initialse this class
		 *
		 * @since 0.0.1
		 */
		public function init() {

			add_action( 'edit_user_profile', array( $this, 'add_custom_user_profile_field' ) );

			add_action( 'edit_user_profile_update', array( $this, 'save_custom_user_profile_field' ) );
		}

		/**
		 * Add a custom field to the user profile
		 *
		 * @param object $profileuser The WP_User object of the user being edited.
		 * @since 0.0.1
		 */
		function add_custom_user_profile_field( $profileuser ) {

			// Get the slack_username.
			$user_meta = get_user_meta( $profileuser->ID, '_cr_slack_username', true );
			?>
			<!-- Add another filed to the form for the 'slack_username' -->
			<table class="form-table">
				<tr>
					<th>
						<label for="cr_slack_username"><?php esc_html_e( 'Slack Username' ); ?></label>
					</th>
					<td>
						<input type="text" name="cr_slack_username" id="cr_slack_username" value="<?php echo esc_attr( $user_meta ); ?>" class="regular-text" />
					</td>
				</tr>
			</table>
			<?php
		}

		/**
		 * Save the value entered into the custom field
		 *
		 * @param integer $user_id The user ID of the user being edited.
		 *
		 * @since 0.0.1
		 */
		function save_custom_user_profile_field( $user_id ) {

			// Check if the current user can edit the current user profile.
			if ( ! current_user_can( 'edit_user', $user_id ) ) {
				return false;
			}

			// Get the input from $_POST.
			$slack_username = filter_input( INPUT_POST, 'cr_slack_username' );

			// Update the database with user input.
			update_usermeta( $user_id, '_cr_slack_username', $slack_username );
		}

	}

}
