<?php
/**
 * Course Records
 *
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 * @package course-records
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

if ( ! class_exists( 'Comments' ) ) {

	/**
	 * Post Factory
	 *
	 * @since 0.0.1
	 */
	class Comments {

		/**
		 * Associative multidimensional array to store message content
		 *
		 * @var array Message Content
		 * @since 0.0.1
		 */
		private $content;

		/**
		 * ID of the parent post
		 *
		 * @var int
		 * @since 0.0.1
		 */
		private $parent_id;

		/**
		 * Constructor
		 *
		 * @param array $json_input Decoded JSON input array for a message.
		 * @param int $parent_post_id ID of the parent post.
		 * @since 0.0.1
		 */
		public function __construct( $json_input, $parent_post_id ) {
			$this->content = $json_input;
			$this->parent_id = $parent_post_id;
		}

		/**
		 * Add new comment to a post
		 *
		 * @since 0.0.1
		 */
		public function add_comments() {
			$ts = (int) $this->content['ts'];
			$user_id = '';
			if ( array_key_exists( 'user', $this->content ) ) {
				$user = $this->content['user'];

				require get_parent_theme_file_path( '/modules/users/class-users.php' );
				$users = new Users();
				$user_id = $users->get_user_from_slack_id( $user );
			}

			// Create post object.
			$my_comment = array(
				'comment_date' => date( 'Y-m-d H:i:s', $ts ),
				'comment_content' => $this->content['text'],
				'comment_post_ID' => $this->parent_id,
				'user_id' => $user_id,
			);

			// Insert post into database.
			$comment_id = wp_insert_comment( $my_comment );
			$this->add_comment_meta( $comment_id );
		}

		/**
		 * Add meta data
		 *
		 * @param int $comment_id Comment ID
		 * @since 0.0.1
		 */
		public function add_comment_meta( $comment_id ) {
			foreach ( $this->content as $key => $value ) {
				add_comment_meta( $comment_id, '_cr_' . $key, $value );
			}
		}

	}

}
