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

if ( ! class_exists( 'Post_Factory' ) ) {

	/**
	 * Post Factory
	 *
	 * @since 0.0.1
	 */
	class Post_Factory {

		/**
		 * Instantiate the appropriate class
		 *
		 * @param array $content JSON of a message converted to an array.
		 * @param array $post_type Post type.
		 * @param array $post_id Post ID.
		 * @since 0.0.1
		 */
		public function instantiate_classes( $content, $post_type, $post_id = 0 ) {
			require get_parent_theme_file_path( '/modules/factory/class-tasks.php' );
			require get_parent_theme_file_path( '/modules/factory/class-questions.php' );
			require get_parent_theme_file_path( '/modules/factory/class-messages.php' );
			require get_parent_theme_file_path( '/modules/factory/class-comments.php' );	

			if ( 'Task' === $post_type ) {
				$task = new Tasks( $content ); // Create new Task.
				return $task->add_task();
			} elseif ( 'Question' === $post_type ) {
				$question = new Questions( $content ); // Create new Question.
				return $question->add_question();
			} elseif ( ( 'First Thread Message' === $post_type ) || ( 'Message' === $post_type ) ) {
				$message = new Messages( $content ); // Create new Message.
				return $message->add_message();
			} elseif ( 'Comment' === $post_type ) {
				$message = new Comments( $content, $post_id ); // Create new comment.
				$message->add_comments();
				return $post_id;
			}
		}

	}

}
