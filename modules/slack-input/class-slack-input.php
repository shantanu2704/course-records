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

if ( !class_exists( 'Slack_Input' ) ) {

	/**
	 * Slack Input
	 *
	 * @since 0.0.1
	 */
	class Slack_Input {

		/**
		 * Contents of the json file
		 */
		public $input_file;
		public $last_input;

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
			add_posts_page( 'Slack Input', 'Slack Importer', 'read', 'slack-importer', array( $this, 'form_page_content' ) );
		}

		/**
		 * Form page content
		 * 
		 * @since 0.0.1
		 */
		function form_page_content() {
			// Process the input file
			$this->process_input_file();

			// Define the uploads directory
			$upload_dir	 = WP_CONTENT_DIR . '/uploads/';
			// Open the directory
			$contents	 = opendir( $upload_dir );
			$files		 = array();

			// Loop over the directory
			while ( false !== ($entry = readdir( $contents ) ) ) {
				// Check if current item is a file
				if ( is_file( $upload_dir . $entry ) ) {
					// If yes, push it on to the list of files.
					array_push( $files, $entry );
				}
			}
			?>
			<div class="wrap">
				<form action="" method="POST">
					<label for="cr_json_file">Select JSON file</label>
					<select name="cr_json_file" id="cr_json_file">
			<?php foreach ( $files as $file ) : ?>
							<option value="<?php echo esc_attr( $file ); ?>" <?php selected( $file, $this->last_input ) ?>><?php echo esc_html( $file ); ?></option>
						<?php endforeach; ?>
					</select>
					<button type="submit" name="json_import" value="import">Import</button>
				</form>
			</div>
			<?php
			$this->process_json();
		}

		/**
		 * Process the input file
		 */
		function process_input_file() {
			// Define the path to the uploads directory
			$uploads_path = WP_CONTENT_DIR . '/uploads/';

			// Check if the form is submitted
			if ( isset( $_POST[ 'json_import' ] ) ) {
				// Get the user input
				$file_name			 = $uploads_path . $_POST[ 'cr_json_file' ];
				// Open the input file in read mode
				$handle				 = fopen( $file_name, 'r' );
				// Store the contents of the file in the 'input_file' property
				$this->input_file	 = fread( $handle, filesize( $file_name ) );
				// Make the current input as the 'las_input' for the next iteration
				$this->last_input	 = $_POST[ 'cr_json_file' ];
			}
		}

		/**
		 * Process the json input file
		 */
		function process_json() {
			// Decode the json and get the result as an associative array
			$json_input = json_decode( $this->input_file, true );
		}

	}

}