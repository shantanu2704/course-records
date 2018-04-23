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

if ( ! class_exists( 'Tasks' ) ) {

	/**
	 * Post Factory
	 *
	 * @since 0.0.1
	 */
	class Tasks {

		/**
		 * Associative multidimensional array to store message content
		 *
		 * @var array Message Content
		 * @since 0.0.1
		 */
		private $content;

		/**
		 * Constructor
		 *
		 * @param array $json_input Decoded JSON input array for a task.
		 * @since 0.0.1
		 */
		public function __construct( $json_input ) {
			$this->content = $json_input;
		}

		/**
		 * Add a new task
		 *
		 * @since 0.0.1
		 */
		public function add_task() {
			$ts = (int) $this->content['ts'];
			$user_id = '';
			if ( array_key_exists( 'user', $this->content ) ) {
				$user = $this->content['user'];

				require get_parent_theme_file_path( '/modules/users/class-users.php' );
				$users = new Users();
				$user_id = $users->get_user_from_slack_id( $user );
				if ( array_key_exists( 'reactions', $this->content ) ) {
					$users->add_reaction_to_user_meta( $this->content['text'], $this->content['reactions'] );
				}
			}

			// Create post object.
			$my_task = array(
				'post_author' => $user_id,
				'post_date' => date( 'Y-m-d H:i:s', $ts ),
				'post_content' => $this->content['text'],
				'post_status' => 'publish',
				'post_type' => 'task',
				'comment_status' => 'open',
			);
			// Insert post into database.
			$task_id = wp_insert_post( $my_task );
			$this->add_task_meta( $task_id );

		}

		/**
		 * Add meta data to the post
		 *
		 * @param int $task_id Task ID.
		 */
		public function add_task_meta( $task_id ) {
			foreach ( $this->content as $key => $value ) {
				add_post_meta( $task_id, '_cr_' . $key, $value );
			}
		}

	}

}
