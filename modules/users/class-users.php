<?php

/**
 * Course Records
 * 
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) )	exit();

if ( !class_exists( 'Users' ) ) {

	/**
	 * Slack Input
	 *
	 * @since 0.0.1
	 */
	class Users {

		/**
		 * An array to hold the Slack IDs as keys and display names as values for users
		 * @var array
		 * @since 0.0.1 
		 */
		private $slack_users;

		/**
		 * An array to hold the Slack IDs as keys and display names as values for bots
		 * @var array
		 * @since 0.0.1 
		 */
		private $slack_bots;

		/**
		 * Constructor
		 */
		public function __construct() {
			$slack_users		 = array(
				'U9H7QT561'	 => 'Archana',
				'U9DHNB324'	 => 'Ashish',
				'U9E46DFUH'	 => 'Chandni',
				'U9HUZURK2'	 => 'Gaurav',
				'U9K4V3AUE'	 => 'Jitender',
				'U9EFHHDM0'	 => 'Kamlesh',
				'U9GTQ3J85'	 => 'Naweed',
				'U9E76V412'	 => 'Parth',
				'U9ATTAU00'	 => 'Saurabh',
				'U9GMWL93L'	 => 'Shantanu',
				'U9HEB6PMX'	 => 'Sheeba',
				'U9EB4N9EH'	 => 'Tushar',
				'U9K0JAMDZ'	 => 'Vishal',
			);
			$slack_bots			 = array(
				'U9DQ94KM3'	 => 'must-read',
				'channel'	 => 'channel',
				'U9DS10XPG'	 => 'Akka',
			);
			$this->slack_users	 = apply_filters( 'cr_slack_user_ids', $slack_users );
			$this->slack_bots	 = apply_filters( 'cr_slack_bot_ids', $slack_bots );
		}

		/**
		 * Replace Slack User ID with names
		 * @param mixed $content String/Array to be searched
		 */
		public function replace_slack_user_id_with_names( $content ) {
			return str_replace( array_keys( $this->slack_users ), array_values( $this->slack_users ), $content );
		}


		/**
		 * Replace Slack Bot ID with names
		 * @param mixed $content String/Array to be searched
		 */
		public function replace_slack_bot_id_with_names( $content ) {
			return str_replace( array_keys( $this->slack_bots ), array_values( $this->slack_bots ), $content );
		}

		/**
		 * Get WordPress user object from Slack ID
		 * @param int Slack ID
		 * @return array WordPress user objects
		 */
		public function get_user_from_slack_id( $slack_id ) {
			$user_object = '';

			$args	 = array(
				'meta_key'	 => 'slack_username',
				'meta_value' => $slack_id,
				'fields'	 => 'ID'
			);
			$user	 = get_users( $args );
			if ( isset( $user[ 0 ] ) ) {
				$user_object = ( int ) $user[ 0 ];
			}
			return $user_object;
		}

		/**
		 * 
		 * @param array $reactions Multidimensional array of reactions with users.
		 * @return array A multidimensional array with a list of users who have 
		 *			completed the task and are yet to complete the task with 
		 *			keys - 'complete' and 'incomplete'
		 */
		public function get_user_list_for_task( $reactions ) {
			$tasks = array(
				'complete'	 => array(),
				'incomplete' => array(),
			);

			foreach ( $reactions as $reaction ) {
				if ( 'white_check_mark' === $reaction[ 'name' ] ) {					
					foreach ( $reaction[ 'users' ] as $user ) {
						$tasks[ 'complete' ][] = $this->slack_users[ $user ];
					}
					$tasks[ 'incomplete' ]	 = array_merge( $tasks[ 'incomplete' ], array_diff( $this->slack_users, $tasks[ 'complete' ] ) );
				}
			}
			
			return $tasks;
		}

		/**
		 * Add reaction to user meta
		 * @param string $task
		 * @param array $reactions Multidimensional array of reactions with users.
		 */
		public function add_reaction_to_user_meta( $task, $reactions ) {

			foreach ( $reactions as $reaction ) {
				if ( 'white_check_mark' === $reaction[ 'name' ] ) {
					foreach ( $reaction[ 'users' ] as $user ) {
						if ( $user === 'U9DQ94KM3' ) {
							continue;
						}
						$id				 = $this->get_user_from_slack_id( $user );
						$display_name	 = $this->slack_users[ $user ];
						add_user_meta( $id, 'TASK - ' . $display_name, $task );
					} // foreach ( $reactions[ 'users' ] as $user )
				} // if ( 'white_check_mark' === $reaction[ name ] ) 
			} // foreach ( $reactions as $reaction )
		}

	}

}