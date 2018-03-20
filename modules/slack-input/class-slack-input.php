<?php

/**
 * Course Records
 * 
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 */

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) )	exit();

if ( !class_exists( 'Slack_Input' ) ) {

	/**
	 * Slack Input
	 *
	 * @since 0.0.1
	 */
	class Slack_Input {
		
		/**
		 * Initialise the class
		 * 
		 * @since 0.0.1
		 */
		function init() {
			
			add_action( 'admin_menu', array( $this, 'my_plugin_menu' ) );
			
		}
	}

}