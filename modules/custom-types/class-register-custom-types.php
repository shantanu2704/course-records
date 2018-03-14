<?php
/**
 * Course Records
 * 
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 */

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) exit();

if ( !class_exists( 'Register_Custom_Types' ) ) {

	/**
	 * Register Custom Types
	 *
	 * @since 0.0.1
	 */
	class Register_Custom_Types {
		
		// Initalise the class
		public function init() {
			
			// Hook into 'init' to register the custom taxonomy - 'User'
			add_action( 'init', array( $this, 'register_user_taxonomy' ) );
			
			// Hook into 'after_switch_theme' to add terms(usernames) to the 
			// custom taxonomy 'User'. 
			// This hook is chosen because it runs everytime we switch to this theme.
			add_action( 'after_switch_theme', array( $this, 'add_users_to_taxonomy' ) );
			
			add_action( 'init', array( $this, 'register_task_post_type' ) );
		}
		
		
		/**
		 * Register the custom taxonomy - 'User'
		 * 
		 * @since 0.0.1 
		 */
		public function register_user_taxonomy() {
			
			// Define all the lables for the custom taxonomy
			$labels = array(
				'name'						 => 'Users',
				'singular_name'				 => 'User',
				'search_items'				 => 'Search Users',
				'all_items'					 => 'All Users',
				'edit_item'					 => 'Edit Users',
				'update_item'				 => 'Update User',
				'add_new_item'				 => 'Add New User',
				'new_item_name'				 => 'New User Name',
				'menu_name'					 => 'User',
				'view_item'					 => 'View User',
				'popular_items'				 => 'Popular User',
				'separate_items_with_commas' => 'Separate users with commas',
				'add_or_remove_items'		 => 'Add or remove user',
				'choose_from_most_used'		 => 'Choose from the most used users',
				'not_found'					 => 'No users found'
			);

			// Register the taxonomy
			register_taxonomy(
					'User',						// taxonomy key
					'post',						// object type
					array(						// args
					'label'			 => __( 'User' ),
					'hierarchical'	 => false,
					'labels'		 => $labels
				)
			);
		}
		
		/**
		 * Fetch all the users on the side and add their usernames as 'terms' of the 
		 * 'User' taxonomy
		 * 
		 * @since 0.0.1
		 */
		public function add_users_to_taxonomy() {
			
			// Fetch a list of all usernames
			$blogusers = get_users( array( 'fields' => array( 'user_login' ) ) );

			foreach ( $blogusers as $user ) {
				
				// Check if the username already exists as a 'term'
				$term = term_exists( $user->user_login, 'User' );
				
				// If the 'term' doesn't exist, add it to the database.
				if ( $term == NULL ) {
					wp_insert_term( $user->user_login, 'User' );
				}
			}
		}
		

		function register_task_post_type() {
			$labels = array(
				'name'				 => __( 'Tasks',  					'twentyseventeen' ),
				'singular_name'		 => __( 'Task', 					'twentyseventeen' ),
				'menu_name'			 => __( 'Tasks',			 		'twentyseventeen' ),
				'name_admin_bar'	 => __( 'Task', 					'twentyseventeen' ),
				'add_new'			 => __( 'Add New', 					'twentyseventeen' ),
				'add_new_item'		 => __( 'Add New Task', 			'twentyseventeen' ),
				'new_item'			 => __( 'New Task', 				'twentyseventeen' ),
				'edit_item'			 => __( 'Edit Task', 				'twentyseventeen' ),
				'view_item'			 => __( 'View Task', 				'twentyseventeen' ),
				'all_items'			 => __( 'All Tasks', 				'twentyseventeen' ),
				'search_items'		 => __( 'Search Tasks', 			'twentyseventeen' ),
				'parent_item_colon'	 => __( 'Parent Tasks:', 			'twentyseventeen' ),
				'not_found'			 => __( 'No tasks found.', 			'twentyseventeen' ),
				'not_found_in_trash' => __( 'No tasks found in Trash.', 'twentyseventeen' )
			);

			$args = array(
				'labels'			 => $labels,
				'public'			 => true,
				'publicly_queryable' => true,
				'show_ui'			 => true,
				'show_in_menu'		 => true,
				'query_var'			 => true,
				'rewrite'			 => array( 'slug' => 'book' ),
				'capability_type'	 => 'post',
				'has_archive'		 => true,
				'hierarchical'		 => false,
				'menu_position'		 => null,
				'supports'			 => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
			);

			register_post_type( 'task', $args );
		}

	}

}