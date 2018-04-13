<?php
/**
 * Displays user reactions
 * @since 0.0.1
 */
require get_parent_theme_file_path( '/inc/template-utilities.php' );
$user_list_for_checkmarks		 = get_list_of_users_for_task();
$user_list_for_other_reactions	 = get_user_list_for_other_reactions();
?>
<div class="cr-reactions" id="cr-reactions" >
	<ul class="cr-post-reaction" id="cr-post-reaction"> <?php get_reactions_on_post(); ?> </ul>
	<ul class="cr-complete-task" id="cr-complete-task"> <?php user_list_complete_task( $user_list_for_checkmarks[ 'complete' ] ); ?> </ul>
	<ul class="cr-incomplete-task" id="cr-incomplete-task"> <?php user_list_complete_task( $user_list_for_checkmarks[ 'incomplete' ] ); ?> </ul>
	<ul class="cr-other-reactions" id="cr-other-reactions"> <?php user_list_for_other_reactions( $user_list_for_other_reactions ); ?> </ul>
</div>

