<?php

require get_parent_theme_file_path( '/modules/users/class-users.php' );
require get_parent_theme_file_path( '/modules/emoji/class-reactions.php' );

if ( !function_exists( 'get_reactions_on_post' ) ) {

	function get_reactions_on_post() {
		$reaction = new Reactions();
		$reactions = $reaction->get_reactions();
		if ( is_array( $reactions ) && !empty( $reactions ) ) {
			$reactions_col = $reaction->get_reactions_on_post();
			if ( !empty( $reactions_col ) ) {
				foreach ( $reactions_col as $reaction_count => $reaction_name ) {
					echo "<li> :" . $reaction_name . ":" . " - " . $reaction_count . " </li>";
				}
			}
		} else {
			echo "None";
		}
	}

}

if ( !function_exists( 'get_list_of_users_for_task' ) ) {

	function get_list_of_users_for_task() {
		$reaction	 = new Reactions();
		$users		 = new Users();
		
		$reactions = $reaction->get_reactions();
		return $users->get_user_list_for_task( $reactions );
	}

}

if ( !function_exists( 'get_user_list_for_other_reactions' ) ) {

	function get_user_list_for_other_reactions() {
		$reaction = new Reactions();
		return $reaction->get_userlist_with_reactions();
	}

}

if ( !function_exists( 'user_list_complete_task' ) ) {

	function user_list_complete_task( $user_list_for_completed_task ) {
		if ( ! empty ($user_list_for_completed_task ) ) {
			foreach ( $user_list_for_completed_task as $user ) {
				echo "<li>" . $user . "</li>";
			}
		}
	}

}

if ( !function_exists( 'user_list_incomplete_task' ) ) {

	function user_list_incomplete_task( $user_list_for_incomplete_task ) {
		if ( ! empty( $user_list_for_incomplete_task ) ) {
			foreach ( $user_list_for_incomplete_task as $user ) {
				echo "<li>" . $user . "</li> \n";
			}
		}
	}

}

if ( !function_exists( 'user_list_for_other_reactions' ) ) {

	function user_list_for_other_reactions( $user_list ) {
		foreach ( $user_list as $key => $value ) {
			echo "<li>" . $key . "</li> \n";
			echo "\t <ul> \n";
			if ( ! empty( $user_list[ $key ] ) ) {
				foreach ( $user_list[ $key ] as $user ) {
					echo "<li>" .  $user . "</li> \n";
				}
			}
			echo "</ul> \n";
		}
	}

}