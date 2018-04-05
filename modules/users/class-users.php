<?php

/**
 * Course Records
 * 
 * @author Shantanu Desai <shantanu2846@gmail.com>
 * @since 0.0.1
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) )	exit();

if ( !class_exists( 'Users' ) ) {

	/**
	 * Slack Input
	 *
	 * @since 0.0.1
	 */
	class Users {
		
		/**
		 * An array to hold all the Slack IDs
		 * @var array
		 * @since 0.0.1 
		 */
		private $slack_user_ids;
		
		/**
		 * An array to hold all usernames
		 * @var array 
		 * @since 0.0.1 
		 */
		private $usernames;

		/**
		 * Constructor
		 */
		public function __construct() {
			
			$slack_user_ids = array (
				'<@U9H7QT561>',	// Archana
				'<@U9E46DFUH>',	// Chandni
				'<@U9HUZURK2>',	// Gaurav
				'<@U9GTQ3J85>',	// Naweed
				'<@U9K4V3AUE>',	// Jitender
				'<@U9EFHHDM0>',	// Kamlesh
				'<@U9E76V412>',	// Parth
				'<@U9DHNB324>',	// Sasi
				'<@U9ATTAU00>',	// Saurabh
				'<@U9HEB6PMX>',	// Sheeba
				'<@U9EB4N9EH>',	// Tushar
				'<@U9K0JAMDZ>',	// VIshal
				'<@U9GMWL93L>',	// Wpshades
				'<@U9DQ94KM3>',	// must-read
				'<!channel>',		// channel
				'<@U9DS10XPG>',	// Akka
			);
			
			$this->slack_user_ids = apply_filters( 'cr_slack_user_ids', $slack_user_ids );

			$usernames = array(
				'@Archana',
				'@Chandni',
				'@Gaurav',
				'@Naweed',
				'@Jitender',
				'@Kamlesh',
				'@Parth',
				'@Sasi',
				'@Saurabh',
				'@Sheeba',
				'@Tushar',
				'@VIshal',
				'@Wpshades',
				'@must-read',
				'@channel',
				'@Akka',
			);

			$this->usernames = apply_filters( 'cr_usernames', $usernames );
		}

	}

}