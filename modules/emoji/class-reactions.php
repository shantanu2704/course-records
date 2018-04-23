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

require get_parent_theme_file_path( '/modules/users/class-users.php' );

if ( ! class_exists( 'Reactions' ) ) {

	/**
	 * Reactions
	 *
	 * @since 0.0.1
	 */
	class Reactions {

		/**
		 * Array to store reactions on a post
		 *
		 * @var array
		 * @since 0.0.1
		 */
		private $reactions;

		/**
		 * Object of type Users
		 *
		 * @var object
		 * @since 0.0.1
		 */
		private $users;


		/**
		 * Constructor
		 *
		 * @since 0.0.1
		 */
		public function __construct() {
			$this->reactions = get_post_meta( get_the_ID(), '_cr_reactions', true );
			$this->users = new Users();
		}

		/**
		 * Getter for reactions
		 *
		 * @return array
		 * @since 0.0.1
		 */
		public function get_reactions() {
			return $this->reactions;
		}

		/**
		 * Gets the list of reactions and their counts on a post
		 *
		 * @return array
		 * @since 0.0.1
		 */
		public function get_reactions_on_post() {
			return array_column( $this->reactions, 'name', 'count' ); // Gets the list of reactions and their counts as key-value pairs.
		}

		/**
		 * Get a multidimensional array of reactions and the users who have reacted
		 *
		 * @return array
		 * @since 0.0.1
		 */
		public function get_userlist_with_reactions() {
			$reactors = array();
			if ( ! empty( $this->reactions ) ) {
				foreach ( $this->reactions as $reaction ) {
					if ( 'white_check_mark' !== $reaction['name'] ) {
						$reactors[ $reaction['name'] ] = $this->users->get_names_from_slack_ids( $reaction['users'] );
					}
				}
			}

			return $reactors;
		}

	}

}
