<?php

/**
 * Course Records
 * 
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) )	exit();

require get_parent_theme_file_path( '/modules/users/class-users.php' );

if ( !class_exists( 'Reactions' ) ) {
	
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
		private $reactions = array();

		/**
		 * The current post ID
		 * @var int 
		 */
		private $current_post_id;
		
		/**
		 * Object of type Users
		 * @var object  
		 */
		private $users;


		/**
		 * Constructor
		 * 
		 * @global int $post_id
		 * 
		 * @since 0.0.1
		 */
		public function __construct() {
			global $post_id;
			$reactions = get_post_meta( $post_id, '_cr_reactions', true );
			print_r( "Reactions are: ---------------------------------------------------------" );
			print_r( $reactions );
//			wp_die();
			$this->users = new Users();
		}
		
		public function get_reactions() {
			return $this->reactions;
		}
		
		/**
		 * Gets the list of reactions and their counts on a post
		 * @return array
		 */
		public function get_reactions_on_post() {
			return array_column( $this->reactions, 'name', 'count' ); //Gets the list of reactions and their counts as key-value pairs
		}
		
		public function get_userlist_with_reactions() {
			$reactors = array ();
			if ( !$this->reactions ) {
				foreach ( $this->reactions as $reaction ) {
					if ( $reaction[ 'name' ] != 'white_check_mark' ) {
						$reactors[ $reaction ] = $this->users->get_names_from_slack_ids( $reaction[ 'users' ] );
					}
				}
			}

			return $reactors;
		}

	}

}