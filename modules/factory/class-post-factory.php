<?php

/**
 * Course Records
 * 
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) exit();

if ( !class_exists( 'Post_Factory' ) ) {

	/**
	 * Post Factory
	 *
	 * @since 0.0.1
	 */
	class Post_Factory {

		private $json_content;

		/**
		 * Constructor
		 * @since 0.0.1
		 */
		public function __construct( $json_input ) {
			$this->json_content = $json_input;
			$this->instantiate_classes( $this->json_content );
		}

		/**
		 * Instantiate the appropriate class
		 * @param array $content JSON of a message converted to an array
		 * @since 0.0.1
		 */
		private function instantiate_classes( $content ) {
			// Check if the current element is a task
			if ( $this->is_task() ) {
				$task = new Task( $content );
			}// Or if it is a question
			elseif ( $this->is_question() ) {
				$task = new Question( $content );
			}// Or if it is a message in a thread
			elseif ( $this->is_thread_message() ) {
				$message = new Message( $content, true, true );
			}// Or is just a regular message
			else {
				$message = new Message( $content );
			}
		}

		/**
		 * Check if the current message is part of a thread
		 * @param array $content
		 * @return bool
		 * @since 0.0.1
		 */
		private function is_thread_message( $content ) {
			// Check if the 'thread_ts' key exists in the json array
			$is_thread_message = ( array_key_exists( 'thread_ts', $content ) ) ? TRUE : FALSE;
			return $is_thread_message;
		}

		/**
		 * Check if the current message is a task
		 * @param array $content
		 * @return bool
		 */
		private function is_task( $content ) {
			// 'text' contains the message contents
			if ( isset( $content[ 'text' ] ) ) {
				$must_read = '<@U9DQ94KM3>'; // Bot ID for must-read
				$channel = '<!channel>'; // User ID for channel

				// Check if both of the strings appear in the message
				if ( ( strpos( $content[ 'text' ], $must_read ) !== false ) && 
				     ( strpos( $content[ 'text' ], $channel ) !== false) ) {
					return true;
				}else {
					return false;
				}
			} else {
				return false;
			}
		}

		/**
		 * Check if the current message is a question
		 * @param array $content
		 * @return bool
		 * @since 0.0.1
		 */
		private function is_question( $content ) {
			// 'text' contains the message contents
			if ( isset( $content[ 'text' ] ) ) {
				$must_read = '<@U9DQ94KM3>'; // Bot ID for must-read
				$saurabh = '<U9ATTAU00>'; // User ID for Saurabh
				
				// Check if both of the strings appear in the message
				if ( ( strpos( $content[ 'text' ], $must_read ) !== false ) &&
				     ( strpos( $content[ 'text' ], $saurabh ) !== false) ) {
					return true;
				}
				else {
					return false;
				}
			} else {
				return false;
			}
		}

	}

}