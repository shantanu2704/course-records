<?php

/**
 * Course Records
 * 
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) exit();

if ( !class_exists( 'Messages' ) ) {

	/**
	 * Post Factory
	 *
	 * @since 0.0.1
	 */
	class Messages {
		
		private $content;
		
		private $thread;
		
		private $broadcast;
		
		private $post_id;
		
		/**
		 * Constructor
		 * @param array $json_input Decoded JSON input array for a message
		 * @param bool $is_thread Is the current message part of a thread
		 * @param bool $was_broadcasted Was the current message broadcasted
		 */
		public function __construct( $json_input, $is_thread = FALSE, $was_broadcasted = FALSE ) {
			$this->content = $json_input;
			$this->thread = $is_thread;
			$this->broadcast = $was_broadcasted;
		}
		
		private function add_message() {
			// Create post object
			$my_post = array(
				'post_author' => $this->content[ 'name' ],
				'post_date' => substr($this->content[ 'datetime' ], 0, 10 ),
				'post_content' => $this->content[ 'text' ],
				'post_status' => 'publish',
				'post_type' => 'message',
				'comment_status' => 'open',				
			);
			// Insert post into database
			$this->post_id = wp_insert_post( $my_post );
		}
	}
}