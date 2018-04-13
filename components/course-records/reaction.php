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
	<ul class="cr-other-reactions" id="cr-other-reactions"> Reactions: <?php user_list_for_other_reactions( $user_list_for_other_reactions ); ?> </ul>
</div>

