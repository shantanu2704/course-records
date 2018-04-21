<?php
/**
 * Displays user reactions in tasks
 *
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 * @package course-records
 */

require get_parent_theme_file_path( '/inc/template-utilities.php' );
$user_list_for_checkmarks         = get_list_of_users_for_task();
$user_list_for_other_reactions   = get_user_list_for_other_reactions();
?>
<div class="cr-reactions" id="cr-reactions" >
	<ul class="cr-post-reaction" id="cr-post-reaction"> Reactions : <?php get_reactions_on_post(); ?> </ul>
	<ul class="cr-complete-task" id="cr-complete-task"> Users who have completed the task: <?php user_list_complete_task( $user_list_for_checkmarks['complete'] ); ?> </ul>
	<ul class="cr-incomplete-task" id="cr-incomplete-task"> Users who haven't completed the task:<?php user_list_complete_task( $user_list_for_checkmarks['incomplete'] ); ?> </ul>
	<?php if ( ! empty( $user_list_for_other_reactions ) ) : ?> 
		<ul class="cr-other-reactions" id="cr-other-reactions"> <?php user_list_for_other_reactions( $user_list_for_other_reactions ); ?> </ul>
	<?php endif; ?>
</div>

