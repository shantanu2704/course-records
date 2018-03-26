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
		public function __construct( $json_content ) {
			$this->content = $json_content;
		}

		/**
		 * Instantiate the appropriate class
		 * @param array $post_type JSON of a message converted to an array
		 * @since 0.0.1
		 */
		public function instantiate_classes( $post_type, $post_id ) {
			
			if ( $post_type === 'Task' ) {
				$task = new Tasks( $this->content ); // Create new Task
				return $task->add_task();
			}elseif ( $post_type === 'Question' ) {
				$question = new Questions( $this->content ); // Create new Question
				return $question->add_question();
			}elseif ( ( $post_type === 'First Thread Message' ) || ( $post_type === 'Message' ) ){
				$message = new Messages( $this->content ); // Create new thread Message		
				return $message->add_message();
			}else {
				$message = new Comments( $this->content, $post_id ); // Create new Message
				return $message->add_comments();
			}
		}

	}

}