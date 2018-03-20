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
			
			// Hook into this action to add an extra submenu
			add_action( 'admin_menu', array( $this, 'add_input_page' ) );	
		}
		
		/**
		 * Add input page
		 * 
		 * @since 0.0.1
		 */
		function add_input_page() {
			
			// Add a submenu to the 'Posts' menu
			add_posts_page( 'Slack Input', 'Slack Importer', 'read', 'slack-importer', array ( $this, 'form_page_content' ) );
		}
		
		/**
		 * Form page content
		 * 
		 * @since 0.0.1
		 */
		function form_page_content() {
			?>
				<label for="json_input"><?php _e( 'JSON Input' ); ?></label>
				<input type="text" name="json_input" id="json_input" value="<?php echo "Hello" ?>" class="regular-text" />

			<?php
		}

	}

}