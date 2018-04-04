<?php

/**
 * Course Records
 * 
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) )	exit();

if ( !class_exists( 'Tasks' ) ) {

	/**
	 * Post Factory
	 *
	 * @since 0.0.1
	 */
	class Tasks {

		private $content;

		/**
		 * Constructor
		 * @param array $json_input Decoded JSON input array for a task
		 */
		public function __construct( $json_input ) {
			$this->content = $json_input;
		}

		public function add_task() {
			$ts = (int) $this->content[ 'ts' ];
			$user = '';
			if ( array_key_exists( 'user', $this->content ) ) {
				$user = $this->content[ 'user' ];
			}
			
			// Create post object
			$my_task = array(
				'post_author'	 => $this->get_username_from_slack_id(),
				'post_date'		 => date( "Y-m-d H:i:s", $ts ),
				'post_content'	 => $this->content[ 'text' ],
				'post_status'	 => 'publish',
				'post_type'		 => 'task',
				'comment_status' => 'open',
			);
			// Insert post into database
			$task_id =  wp_insert_post( $my_task );
			$this->add_question_meta( $task_id );
		}
		
		public function add_question_meta( $task_id ) {
			foreach ( $this->content as $key => $value ) {
				add_post_meta( $task_id, 'cr_' . $key, $value);
			}
		}
		
		private function get_username_from_slack_id() {
			$return_value = '';
			if ( array_key_exists( 'user', $this->content ) ) {
				$args	 = array(
					'meta_key'	 => 'slack_username',
					'meta_value' => $this->content[ 'user' ],
					'fields'	 => 'ID'
				);
				$user	 = get_users( $args );
				if ( isset($user[ 0 ] ) ) {
					$return_value = ( int ) $user[ 0 ];
				}
			}
			return $return_value;
		}
		
	}

}