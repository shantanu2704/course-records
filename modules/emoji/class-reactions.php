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
		 * Constructor
		 * 
		 * @global int $post_id
		 * 
		 * @since 0.0.1
		 */
		public function __construct() {
			global $post_id;
			$this->reactions = get_post_meta( $post_id, '_cr_reactions' );
		}

	}

}