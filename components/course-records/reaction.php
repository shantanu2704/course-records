<?php
/**
 * Displays user reactions
 *
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 * @package course-records
 */

?>

<?php
require get_parent_theme_file_path( '/inc/template-utilities.php' );
$user_list_for_other_reactions = get_user_list_for_other_reactions();
?>
<div class="cr-reactions" id="cr-reactions" >
	<ul class="cr-post-reaction" id="cr-post-reaction"> Reactions: <?php get_reactions_on_post(); ?> </ul>
	<?php if ( ! empty( $user_list_for_other_reactions ) ) : ?> 
		<ul class="cr-other-reactions" id="cr-other-reactions"> <?php user_list_for_other_reactions( $user_list_for_other_reactions ); ?> </ul>
	<?php endif; ?>
</div>

