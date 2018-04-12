<?php

/**
 * Course Records
 * 
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) )	exit();

if ( !class_exists( 'Reactions' ) ) {

	require get_parent_theme_file_path( '/modules/users/class-users.php' );
	$users = new Users();
	
	/**
	 * Reactions
	 *
	 * @since 0.0.1
	 */
	class Reactions {

		/**
		 *
		 * @var array Array to store reactions on a post 
		 */
		private $reactions;

		/**
		 * The current post ID
		 * @var int 
		 */
		private $current_post_id;
		
		/**
		 * Constructor
		 * 
		 * @global int $post_id
		 * 
		 * @since 0.0.1
		 */
		public function __construct() {
			global $post_id;
			$this->current_post_id = $post_id;
			$this->reactions = get_post_meta( $this->current_post_id, '_cr_reactions' );
		}
		
		/**
		 * Gets the list of reactions and their counts on a post
		 * @return array
		 */
		public function get_reactions_on_post() {
			return array_column( $this->reactions, 'name', 'count' ); //Gets the list of reactions and their counts as key-value pairs
		}

	}

}