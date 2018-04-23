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
if ( !defined( 'ABSPATH' ) ) {
	exit();
}

if ( ! class_exists( 'Questions' ) ) {

	/**
	 * Post Factory
	 *
	 * @since 0.0.1
	 */
	class Questions {

		/**
		 * Associative multidimensional array to store message content
		 *
		 * @var array Message Content 
		 */
		private $content;

		/**
		 * Constructor
		 * 
		 * @param array $json_input Decoded JSON input array for a question.
		 * @since 0.0.1
		 */
		public function __construct( $json_input ) {
			$this->content = $json_input;
		}


		/**
		 * Add a new question
		 * 
		 * @since 0.0.1
		 */
		public function add_question() {
			$ts = (int) $this->content['ts'];
			$user_id = '';
			if ( array_key_exists( 'user', $this->content ) ) {
				$user = $this->content['user'];

				require get_parent_theme_file_path( '/modules/users/class-users.php' );
				$users = new Users();
				$user_id = $users->get_user_from_slack_id( $user );
			}

			// Create post object.
			$my_question = array(
				'post_author' => $user_id,
				'post_date'	=> date( 'Y-m-d H:i:s', $ts ),
				'post_content' => $this->content[ 'text' ],
				'post_status' => 'publish',
				'post_type'	=> 'question',
				'comment_status' => 'open',
			);
			// Insert post into database.
			$question_id = wp_insert_post( $my_question );
			$this->add_question_meta( $question_id );
		}

		/**
		 * Add meta data to the post
		 * @param int $task_id Task ID
		 */
		public function add_question_meta( $question_id ) {
			foreach ( $this->content as $key => $value ) {
				add_post_meta( $question_id, '_cr_' . $key, $value );
			}
		}

	}

}
