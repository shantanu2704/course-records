<?php

/**
 * Course Records
 * 
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) )	exit();

if ( !class_exists( 'Questions' ) ) {

	/**
	 * Post Factory
	 *
	 * @since 0.0.1
	 */
	class Questions {

		private $content;

		/**
		 * Constructor
		 * @param array $json_input Decoded JSON input array for a question
		 */
		public function __construct( $json_input ) {
			$this->content = $json_input;
		}

		public function add_question() {
			// Create post object
			$my_post = array(
				'post_author'	 => $this->content[ 'name' ],
				'post_date'		 => substr( $this->content[ 'datetime' ], 0, 10 ),
				'post_content'	 => $this->content[ 'text' ],
				'post_status'	 => 'publish',
				'post_type'		 => 'question',
				'comment_status' => 'open',
			);
			// Insert post into database
			return wp_insert_post( $my_post );
		}

	}

}