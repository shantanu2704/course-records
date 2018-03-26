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
		
		public $json_content;
		
		/**
		 * Constructor
		 */
		public function __construct( $json_input ) {
			$this->json_content = $json_input;
		}
	}
}