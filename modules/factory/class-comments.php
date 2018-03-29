<?php

/**
 * Course Records
 * 
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) exit();

if ( !class_exists( 'Comments' ) ) {

	/**
	 * Post Factory
	 *
	 * @since 0.0.1
	 */
	class Comments {
		
		private $content;
		
		private $parent_id;
		
		/**
		 * Constructor
		 * @param array $json_input Decoded JSON input array for a message
		 * @param bool $is_thread Is the current message part of a thread
		 * @param bool $was_broadcasted Was the current message broadcasted
		 */
		public function __construct( $json_input, $parent_post_id ) {
			$this->content = $json_input;
			$this->parent_id = $parent_post_id;
		}
		
		public function add_comments() {
			$ts = (int) $this->content[ 'ts' ];
			$user = '';
			if ( array_key_exists( 'user', $this->content ) ) {
				$user = $this->content[ 'user' ];
			}
			
			// Create post object
			$my_comment = array(
				'comment_author'	 => $user,
				'comment_date'		 => date( "Y-m-d H:i:s", $ts / 1000 ),
				'comment_content'	 => $this->content[ 'text' ],
				'comment_post_ID'	 => $this->parent_id,
			);
			// Insert post into database
			$comment_id =  wp_insert_comment( $my_comment );
			$this->add_comment_meta( $comment_id );
		}
		
		public function add_comment_meta( $comment_id ) {
			foreach ( $this->content as $key => $value ) {
				add_comment_meta( $comment_id, 'cr_' . $key, $value);
			}
		}
		
		private function get_username_from_slack_id() {
			$args = array(
				'meta_key'	 => 'slack_username',
				'meta_value' => $this->content[ 'user' ],
				'fields'	 => 'ID'
			);
			$user = get_users( $args );
			return $user[ 0 ];
		}

	}

}