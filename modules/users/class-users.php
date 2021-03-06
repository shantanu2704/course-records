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

if ( ! class_exists( 'Users' ) ) {

	/**
	 * Slack Input
	 *
	 * @since 0.0.1
	 */
	class Users {

		/**
		 * An array to hold the Slack IDs as keys and display names as values for users
		 *
		 * @var array
		 * @since 0.0.1
		 */
		private $slack_users;

		/**
		 * An array to hold the Slack IDs as keys and display names as values for bots
		 *
		 * @var array
		 * @since 0.0.1
		 */
		private $slack_bots;

		/**
		 * Constructor
		 */
		public function __construct() {
			$slack_users = array(
				'U9H7QT561' => 'Archana',
				'U9DHNB324' => 'Ashish',
				'U9E46DFUH' => 'Chandni',
				'U9HUZURK2' => 'Gaurav',
				'U9K4V3AUE' => 'Jitender',
				'U9EFHHDM0' => 'Kamlesh',
				'U9GTQ3J85' => 'Naweed',
				'U9E76V412' => 'Parth',
				'U9ATTAU00' => 'Saurabh',
				'U9GMWL93L' => 'Shantanu',
				'U9HEB6PMX' => 'Sheeba',
				'U9EB4N9EH' => 'Tushar',
				'U9K0JAMDZ' => 'Vishal',
			);
			$slack_bots = array(
				'U9DQ94KM3' => 'must-read',
				'channel' => 'channel',
				'U9DS10XPG' => 'Akka',
			);
			$this->slack_users = apply_filters( 'cr_slack_user_ids', $slack_users );
			$this->slack_bots = apply_filters( 'cr_slack_bot_ids', $slack_bots );
		}

		/**
		 * Getter for $slack_bots and $slack_users
		 *
		 * @param string $slack_id Slack ID.
		 * @return string Display name.
		 */
		public function __get( $slack_id ) {
			if ( array_key_exists( $slack_id, $this->slack_bots ) ) {
				return $this->slack_bots[ $slack_id ];
			}
			if ( array_key_exists( $slack_id, $this->slack_users ) ) {
				return $this->slack_users[ $slack_id ];
			}
		}

		/**
		 * Replace Slack User ID with names
		 *
		 * @param mixed $content String/Array to be searched.
		 */
		public function replace_slack_user_id_with_names( $content ) {
			return str_replace( array_keys( $this->slack_users ), array_values( $this->slack_users ), $content );
		}


		/**
		 * Replace Slack Bot ID with names
		 *
		 * @param mixed $content String/Array to be searched.
		 */
		public function replace_slack_bot_id_with_names( $content ) {
			return str_replace( array_keys( $this->slack_bots ), array_values( $this->slack_bots ), $content );
		}

		/**
		 * Get WordPress user object from Slack ID
		 *
		 * @param int $slack_id Slack ID.
		 * @return array WordPress user objects.
		 */
		public function get_user_from_slack_id( $slack_id ) {
			$user_object = '';

			$args = array(
				'meta_key' => 'slack_username',
				'meta_value' => $slack_id,
				'fields' => 'ID',
			);
			$user = get_users( $args );
			if ( isset( $user[0] ) ) {
				$user_object = (int) $user[0];
			}
			return $user_object;
		}

		/**
		 * Get a list of users who have completed the task and who haven't
		 *
		 * @param array $reactions Multidimensional array of reactions with users.
		 * @return array A multidimensional array with a list of users who have
		 *                          completed the task and are yet to complete the task with
		 *                          keys - 'complete' and 'incomplete'.
		 */
		public function get_user_list_for_task( $reactions ) {
			$tasks = array(
				'complete' => array(),
				'incomplete' => array(),
			);

			foreach ( $reactions as $reaction ) {
				if ( ( isset( $reaction['name'] ) ) && ( 'white_check_mark' === $reaction['name'] ) ) {
					foreach ( $reaction['users'] as $user ) {
						$tasks['complete'][] = array_key_exists( $user, $this->slack_users ) ? $this->slack_users[ $user ] : $this->slack_bots[ $user ];
					}

					$tasks['incomplete'] = array_merge( $tasks['incomplete'], array_diff( $this->slack_users, $tasks['complete'] ) );
				}
			}

			return $tasks;
		}

		/**
		 * Add reaction to user meta
		 *
		 * @param string $task Task.
		 * @param array $reactions Multidimensional array of reactions with users.
		 */
		public function add_reaction_to_user_meta( $task, $reactions ) {

			foreach ( $reactions as $reaction ) {
				if ( 'white_check_mark' === $reaction['name'] ) {
					foreach ( $reaction['users'] as $user ) {
						if ( 'U9DQ94KM3' === $user ) {
							continue;
						}
						$id = $this->get_user_from_slack_id( $user );
						$display_name = $this->slack_users[ $user ];
						add_user_meta( $id, '_cr_TASK_' . $display_name, $task );
					} // foreach ( $reactions[ 'users' ] as $user )
				} // if ( 'white_check_mark' === $reaction[ name ] )
			} // foreach ( $reactions as $reaction )
		}

		/**
		 * Get names from Slack IDs
		 *
		 * @param array $slack_ids Slack IDs.
		 * @return array User names.
		 */
		public function get_names_from_slack_ids( $slack_ids ) {
			$names = array();
			foreach ( $slack_ids as $slack_id ) {
				$names[] = $this->__get( $slack_id );
			}
			return $names;
		}

	}

}
