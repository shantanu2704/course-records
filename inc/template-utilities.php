<?php

require get_parent_theme_file_path( '/modules/users/class-users.php' );
require get_parent_theme_file_path( '/modules/emoji/class-reactions.php' );

function get_reactions_on_post() {
	$reaction = new Reactions();
	$reactions = $reaction->get_reactions_on_post();
	foreach ( $reactions as $reaction_name => $reaction_count ) {
		echo ":" . $reaction_name . ":" . " - " . $reaction_count . "\n";
	}
}

function get_list_of_users() {
	$reaction = new Reactions();
	$users = new Users();
	
	return $users->get_user_list_for_task( $reaction->get_reactions() );
	
}