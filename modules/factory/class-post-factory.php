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
		 */
		public function __construct( $json_input ) {
			$this->json_content = $json_input;
			$this->instantiate_classes( $this->json_content );
		}

		private function instantiate_classes( $content ) {
			if ( $this->is_task() ) {
				$task = new Task( $content );
			}elseif ( $this->is_question() ) {
				$task = new Question( $content );
			}elseif ( $this->is_thread_message() ) {
				$message = new Message( $content, true, true );
			}else {
				$message = new Message( $content );
			}
		}

		private function is_message() {
			
		}

		private function is_thread_message( $content ) {
			$is_thread_message = ( isset( $content[ 'thread_ts' ] ) ) ? TRUE : FALSE;
			return $is_thread_message;
		}

		private function is_task( $content ) {
			if ( isset( $content[ 'text' ] ) ) {
				$query			 = '<@U9DQ94KM3> <!channel>';
				$return_value	 = ( substr( $content[ 'text' ], 0, strlen( $query ) ) ) === $query ? TRUE : FALSE;
				return $return_value;
			}
		}

		private function is_question( $content ) {
			if ( isset( $content[ 'text' ] ) ) {
				$query			 = '<@U9DQ94KM3> <U9ATTAU00>';
				$return_value	 = ( substr( $content[ 'text' ], 0, strlen( $query ) ) ) === $query ? TRUE : FALSE;
				return $return_value;
			}
		}

	}

}