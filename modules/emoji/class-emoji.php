<?php
/**
 * Course Records
 *
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 * @package course-records
 * 
 */
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

if ( ! class_exists( 'Emoji' ) ) {

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

		/**
		 * Enqueue the styles and scripts for emojis
		 * Library - https://github.com/emojione/emojify.js
		 * 
		 * @since 0.0.1
		 */
		public function enqueue_emoji_styles_and_scripts() {
			$style_src = '//cdnjs.cloudflare.com/ajax/libs/emojify.js/1.1.0/css/basic/emojify.min.css';
			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
				$style_src = '//cdnjs.cloudflare.com/ajax/libs/emojify.js/1.1.0/css/basic/emojify.css';
			}

			$script_src = '//cdnjs.cloudflare.com/ajax/libs/emojify.js/1.1.0/js/emojify.min.js';
			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
				$style_src = '//cdnjs.cloudflare.com/ajax/libs/emojify.js/1.1.0/js/emojify.js';
			}

			wp_enqueue_style( 'emoji_style', $style_src );
			wp_enqueue_script( 'emoji_script', $script_src );
			wp_enqueue_script( 'cr_emoji', get_template_directory_uri() . ( '/assets/js/cr-emoji.js' ), array( 'jquery', 'emoji_script' ) );
		}

	}

}
