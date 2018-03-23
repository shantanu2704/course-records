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

			$dir		 = wp_upload_dir();
			$contents	 = opendir( $dir[ 'basedir' ] );
			$files		 = array();

			while ( false !== ($entry = readdir( $contents ) ) ) {

				$file_path = $dir[ 'basedir' ] . '/' . $entry;

				if ( is_file( $file_path ) ) {
					array_push( $files, $entry );
				}
			}

			?>
			<div class="wrap">
				<form action="" method="POST">
					<label for="cr_json_files">Select JSON file</label>
					<select name="cr_json_files" id="cr_json_files">
					<?php foreach ( $files as $file ) : ?>
						<option value="<?php echo esc_attr( $file ); ?>" ><?php echo esc_html( $file ); ?></option>
					<?php endforeach; ?>
					</select>
					<button type="submit">Import</button>
				</form>
			</div>
			<?php
		}

	}

}