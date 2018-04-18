<?php

/**
 * Course Records
 * 
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) exit();

if ( !class_exists( 'Slack_CSS' ) ) {

	/**
	 * Slack CSS
	 *
	 * @since 0.0.1
	 */
	class Slack_CSS {
		/**
		 * Initialse this class
		 * 
		 * @since 0.0.1
		 */
		public function init() {

			add_action( 'wp_enqueue_scripts', array( $this, 'slack_style' ) );
		}
		
		public function slack_style() {
			$style_src = get_parent_theme_file_uri() . 'sass/slack-style.scss';
			wp_enqueue_style( 'slack_style', $style_src );
		}

	}

}