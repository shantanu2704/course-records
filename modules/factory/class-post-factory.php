<?php

/**
 * Course Records
 * 
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) )
	exit();

if ( !class_exists( 'Post_Factory' ) ) {

	/**
	 * Post Factory
	 *
	 * @since 0.0.1
	 */
	class Post_Factory {

		/**
		 * Instantiate the appropriate class
		 * @param array $content JSON of a message converted to an array
		 * @since 0.0.1
		 */
		public function instantiate_classes( $content ) {
			// Check if the current element is a task
			if ( $this->is_must_read( $content ) === 'Task' ) {
				$task = new Task( $content ); // Create new Task
			}// Or if it is a question
			elseif ( $this->is_must_read( $content ) === 'Question' ) {
				$task = new Question( $content ); // Create new Question
			}// Or if it is a message in a thread
			elseif ( $this->is_thread_message() ) {
				$message = new Messages( $content, true, true ); // Create new thread Message		
				$post_id = $message->add_message();
			}// Or is just a regular message
			else {
				$message = new Messages( $content ); // Create new Message
			}
		}

		/**
		 * Check if 'must-read' is used in a message
		 * @param array $content Decoded JSON message
		 * @return boolean|string 
		 * @since 0.0.1
		 */
		private function is_must_read( $content ) {
			$must_read = '<@U9DQ94KM3>'; // Bot ID for must-read
			// Check if must-read appears in the message
			if ( strpos( $content[ 'text' ], $must_read ) !== false ) { // If true
				if ( $this->is_question( $content ) ) { // Check if the message is a question
					return 'Question'; // Return the string 'Question' if it is
				} else {
					return 'Task'; // else return the string 'Task' if it isn't
				}
			} else {
				return false;
			}
		}

		/**
		 * Check if the current message is part of a thread
		 * @param array $content Decoded JSON message
		 * @return bool
		 * @since 0.0.1
		 */
		private function is_thread_message( $content ) {
			// Check if the 'thread_ts' key exists in the json array
			$is_thread_message = ( array_key_exists( 'thread_ts', $content ) ) ? TRUE : FALSE;
			return $is_thread_message;
		}

		/**
		 * Check if the current message is a question
		 * @param array $content Decoded JSON message
		 * @return bool
		 * @since 0.0.1
		 */
		private function is_question( $content ) {
			// User ID for Saurabh
			$saurabh = '<U9ATTAU00>';

			// Check if the string appears in the message
			if ( strpos( $content[ 'text' ], $saurabh ) !== false ) {
				return true;
			} else {
				return false;
			}
		}

	}

}