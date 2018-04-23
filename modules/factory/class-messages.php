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

if ( ! class_exists( 'Messages' ) ) {

	/**
	 * Post Factory
	 *
	 * @since 0.0.1
	 */
	class Messages {

		/**
		 * Multidimensional associative array containing Slack messages
		 *
		 * @var array 
		 */
		private $content;

		/**
		 * Whether the current message is part of a thread
		 *
		 * @var bool  
		 */
		private $thread;

		/**
		 * Was the current message broadcast
		 *
		 * @var bool 
		 */
		private $broadcast;

		/**
		 * Constructor
		 * 
		 * @param array $json_input Decoded JSON input array for a message.
		 * @param bool  $is_thread Is the current message part of a thread.
		 * @param bool  $was_broadcasted Was the current message broadcasted.
		 */
		public function __construct( $json_input, $is_thread = false, $was_broadcasted = false ) {
			$this->content = $json_input;
			$this->thread = $is_thread;
			$this->broadcast = $was_broadcasted;
		}

		/**
		 * Add a new message
		 */
		public function add_message() {
			$ts = (int) $this->content['ts'];
			$user_id = '';
			if ( array_key_exists( 'user', $this->content ) ) {
				$user = $this->content['user'];

				require get_parent_theme_file_path( '/modules/users/class-users.php' );
				$users = new Users();
				$user_id = $users->get_user_from_slack_id( $user );
			}

			// Create post object.
			$my_message = array(
				'post_author' => $user_id,
				'post_date'	=> date( 'Y-m-d H:i:s', $ts ),
				'post_content' => $this->content[ 'text' ],
				'post_status' => 'publish',
				'post_type' => 'message',
				'comment_status' => 'open',
			);

			// Insert post into database.
			$message_id = wp_insert_post( $my_message );
			$this->add_message_meta( $message_id );
		}

		/**
		 * Add meta data to the post
		 * 
		 * @param int $message_id Message ID.
		 */
		public function add_message_meta( $message_id ) {
			foreach ( $this->content as $key => $value ) {
				add_post_meta( $message_id, '_cr_' . $key, $value );
			}
		}

	}

}
