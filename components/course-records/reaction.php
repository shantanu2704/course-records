<?php 
/**
 * Displays user reactions
 * @since 0.0.1
 */
$reactions = get_post_meta( get_the_ID(), '_cr_reactions' ); ?>
<div class="cr-reactions" id="cr-reactions" data-cr-reactions="
	 <?php
	 if ( isset( $reactions[ 0 ] ) ) {
		 foreach ( $reactions[ 0 ] as $reaction ) {
			 if ( isset( $reaction[ 'users' ] ) ) {
				 foreach ( $reaction[ 'users' ] as $user ) {
					 echo $user . "\n";
				 }
			 }
		 }
	 }
	 ?>">
	 <?php
		 if ( isset( $reactions[ 0 ] ) ) {
			 foreach ( $reactions[ 0 ] as $reaction ) {
				 echo ":" . $reaction[ 'name' ] . ":" . " : " . $reaction[ 'count' ] . "\n";
			 }
		 }
		 ?>
</div>
<?php