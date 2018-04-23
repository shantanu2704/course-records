<?php
/**
 * Template part for author details
 *
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 * @package course-records
 */

?>

<div class="author-avatar"> <?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?></div>
<span class="author-avatar"> <?php the_author(); ?></span>
