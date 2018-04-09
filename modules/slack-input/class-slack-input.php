<?php
/**
 * Course Records
 * 
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) exit();

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
		private $current_thread_ts;
		private $previous_thread_ts;
		private $post_id;

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
			$json_input		 = json_decode( $this->input_file, true );
			if ( empty( $json_input ) ) {
				return;
			}
			require get_parent_theme_file_path( '/modules/factory/class-post-factory.php' );
			$post_factory	 = new Post_Factory();
			foreach ( $json_input as $content ) {
				
				if ( $this->is_comment( $content ) ){
					$message_type = 'Comment';
					$post_id = $this->get_main_post_id( $content );
					$this->post_id		 = $post_factory->instantiate_classes( $content, $message_type, $post_id );
					continue;
				}
				
				$message_type = $this->check_message_subtype( $content );
				
				require get_parent_theme_file_path( '/modules/users/class-users.php' );
				$users = new Users();
				$content[ 'text' ] = $users->replace_slack_user_id_with_names( $content[ 'text' ] );
				$content[ 'text' ] = $users->replace_slack_bot_id_with_names( $content[ 'text' ] );
				
				$this->post_id		 = $post_factory->instantiate_classes( $content, $message_type );
			}
		}
		
		/**
		 * Check if the current element is a comment
		 * @param array $content Decoded JSON message
		 * @return bool
		 * @since 0.0.1
		 */
		private function is_comment( $content ) {
			if ( array_key_exists( 'subtype', $content ) && ( "thread_broadcast" === $content['subtype'] ) ) {
				return true;
			}
			return array_key_exists( 'parent_user_id', $content );
		}

		/**
		 * Check the subtype of the message based on the presence of must-read
		 * @param array $content Decoded JSON message
		 * @return boolean|string 
		 * @since 0.0.1
		 */
		private function check_message_subtype( $content ) {
			$must_read = '<@U9DQ94KM3>'; // Bot ID for must-read
			// Check if must-read appears in the message
			if ( strpos( $content[ 'text' ], $must_read ) !== false ) {
				if ( true === $this->is_question( $content ) ) {
					return 'Question';
				}else {
					return 'Task';
				}
			}else {
				return 'Message';
			}
		}

		/**
		 * Check if the current message is a question
		 * @param array $content Decoded JSON message
		 * @return bool
		 * @since 0.0.1
		 */
		private function is_question( $content ) {
			// User ID for Saurabh
			$saurabh = 'U9ATTAU00';

			// Check if the string appears in the message
			if ( strpos( $content[ 'text' ], $saurabh ) !== false ) {
				return true;
			}
			else {
				return false;
			}
		}
		
		/**
		 * Get the ID of the parent post
		 * @param string $value Timestamp
		 * @return string
		 * @since 0.0.1
		 */
		private function get_main_post_id( $value ) {
			
			$args = array(
				'post_type' => array( 'message', 'task', 'question' ),
				'meta_query' => array(
					array(
						'key' => 'cr_thread_ts',
						'value' => $value[ 'thread_ts' ],
						'compare' => 'CHAR',
						)
				),
				
			);
			$query = new WP_Query( $args );
			
			if ( $query->have_posts() ) {
				return $query->post->ID;
			}
		}
		
	}

}	