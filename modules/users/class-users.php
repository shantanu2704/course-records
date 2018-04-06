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
		 * An array to hold all the Slack IDs
		 * @var array
		 * @since 0.0.1 
		 */
		private $slack_user_ids;
		
		/**
		 * An array to hold all usernames
		 * @var array 
		 * @since 0.0.1 
		 */
		private $usernames;

		/**
		 * Constructor
		 */
		public function __construct() {
			
			$slack_user_ids = array (
				'<@U9H7QT561>',	// Archana
				'<@U9DHNB324>',	// Ashish
				'<@U9E46DFUH>',	// Chandni
				'<@U9HUZURK2>',	// Gaurav
				'<@U9K4V3AUE>',	// Jitender
				'<@U9EFHHDM0>',	// Kamlesh
				'<@U9GTQ3J85>',	// Naweed
				'<@U9E76V412>',	// Parth				
				'<@U9ATTAU00>',	// Saurabh
				'<@U9GMWL93L>',	// Shantanu
				'<@U9HEB6PMX>',	// Sheeba
				'<@U9EB4N9EH>',	// Tushar
				'<@U9K0JAMDZ>',	// VIshal
				'<@U9DQ94KM3>',	// must-read
				'<!channel>',		// channel
				'<@U9DS10XPG>',	// Akka
			);
			
			$this->slack_user_ids = apply_filters( 'cr_slack_user_ids', $slack_user_ids );

			$usernames = array(
				'@Archana',
				'@Ashish',
				'@Chandni',
				'@Gaurav',
				'@Jitender',
				'@Kamlesh',
				'@Naweed',
				'@Parth',
				'@Saurabh',
				'@Shantanu',
				'@Sheeba',
				'@Tushar',
				'@Vishal',
				'@must-read',
				'@channel',
				'@Akka',
			);

			$this->usernames = apply_filters( 'cr_usernames', $usernames );
		}
		
				
		/**
		 * Replace Slack ID with names
		 * @param array $content Decoded JSON message
		 */
		public function replace_slack_user_id_with_names( &$content ) {
			
			$content[ 'text' ] = str_replace( $this->slack_user_ids, $this->usernames, $content[ 'text' ] );
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
		 */
		public function task_completion( $task, $reactions ) {
			$tasks = array(
				'complete'	 => array(),
				'incomplete' => array(),
			);

			foreach ( $reactions as $reaction ) {
				if ( 'white_check_mark' === $reaction[ name ] ) {
					$this->add_reaction_to_user_meta( $task, 'white_check_mark', $reaction[ 'users' ] );
				}
			}
		}
		
		
		/**
		 * Add reaction to user meta
		 * @param string $task
		 * @param array $users
		 */
		public function add_reaction_to_user_meta( $task, $users ) {
			
			foreach ( $users as $user ) {
				$id = $this->get_user_from_slack_id( $user );
				$display_name = $this->get_display_name_from_slack_id( $user );
				$user_task_meta = get_user_meta( $id, 'TASK - ' . $display_name, true);
				
				if ( empty( $user_task_meta ) ) {
					update_user_meta( $id, 'TASK - ' . $display_name, array ($task ) );
				} else {
					$user_task_meta_array = ( is_array($user_task_meta) ) ? $user_task_meta : array ( $user_task_meta );
					$user_task_meta_array[] = $task;
					update_user_meta( $id, 'TASK - ' . $display_name, $user_task_meta_array );
				}
				
			}
		}
		
		
		/**
		 * Get a user's display name from their slack ID
		 * @param string $slack_id
		 */
		public function get_display_name_from_slack_id( $slack_id ) {
			$flipped_slack_user_ids = array_flip( $this->slack_user_ids );
			return $this->usernames[ $flipped_slack_user_ids[ $slack_id ] ];
		}

	}

}