<?php

/**
 * Course Records
 * 
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) exit();

if ( !class_exists( 'Post_Factory' ) ) {

	/**
	 * Post Factory
	 *
	 * @since 0.0.1
	 */
	class Post_Factory {
		
		private $content;
		
		/**
		 * Constructor
		 * @param array $json_content Decoded json data
		 */
		public function __construct( ) {
//			$this->content = array();
//			$this->content = $json_content;
		}

		/**
		 * Instantiate the appropriate class
		 * @param array $post_type JSON of a message converted to an array
		 * @since 0.0.1
		 */
		public function instantiate_classes( $content, $post_type, $post_id = 0 ) {
			require get_parent_theme_file_path( '/modules/factory/class-tasks.php' );
			require get_parent_theme_file_path( '/modules/factory/class-questions.php' );
			require get_parent_theme_file_path( '/modules/factory/class-messages.php' );
			require get_parent_theme_file_path( '/modules/factory/class-comments.php' );
			

			if ( $post_type === 'Task' ) {
				$task = new Tasks( $content ); // Create new Task
				return $task->add_task();
			}elseif ( $post_type === 'Question' ) {
				$question = new Questions( $content ); // Create new Question
				return $question->add_question();
			}elseif ( ( $post_type === 'First Thread Message' ) || ( $post_type === 'Message' ) ){
				$message = new Messages( $content ); // Create new Message		
				return $message->add_message();
			}elseif ( $post_type === 'Comment' ) {
				$message = new Comments( $content, $post_id ); // Create new comment
				$message->add_comments();
				return $post_id;
			}
		}

	}

}