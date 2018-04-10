<?php
/**
 * Course Records
 * 
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) exit();

if ( !class_exists( 'Emoji' ) ) {

	/**
	 * Emoji
	 *
	 * @since 0.0.1
	 */
	class Emoji {
		
		/**
		 * Initialse this class
		 * 
		 * @since 0.0.1
		 */
		public function init() {

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_emoji_styles_and_scripts' ) );
		}

	}
}
