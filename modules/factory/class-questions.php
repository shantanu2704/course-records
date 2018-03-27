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
			$ts = (int) $this->content[ 'ts' ] / 1000;

			// Create post object
			$my_question = array(
				'post_author'	 => substr( $this->content[ 'text' ], 2, 9 ),
				'post_date'		 => date( "Y-m-d H:i:s", $ts ),
				'post_content'	 => $this->content[ 'text' ],
				'post_status'	 => 'publish',
				'post_type'		 => 'question',
				'comment_status' => 'open',
			);
			// Insert post into database
			$question_id =  wp_insert_post( $my_question );
			$this->add_question_meta( $question_id );
		}
		
		public function add_question_meta( $question_id ) {
			foreach ( $this->content as $key => $value ) {
				add_post_meta( $question_id, 'cr_' . $key, $value);
			}
		}

	}

}