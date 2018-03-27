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
		
		public function add_message() {
			$ts = (int) $this->content[ 'ts' ];
			// Create post object
			$my_message = array(
				'post_author'	 => substr( $this->content[ 'text' ], 2, 9 ),
				'post_date'		 => date( "Y-m-d H:i:s", $ts / 1000 ),
				'post_content'	 => $this->content[ 'text' ],
				'post_status'	 => 'publish',
				'post_type'		 => 'message',
				'comment_status' => 'open',
			);
			// Insert post into database
			$message_id =  wp_insert_post( $my_message );
			$this->add_message_meta( $message_id );
		}
		
		public function add_message_meta( $message_id ) {
			foreach ( $this->content as $key => $value ) {
				add_post_meta( $message_id, 'cr_' . $key, $value);
			}
		}
	}
}