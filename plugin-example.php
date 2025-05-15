<?php

//Add your namespace

/*
* Plugin Name: WP_REQUEST_TYPE definition and usage example
* Plugin URI: https://wpspeeddoctor.com/plugins/
* Description: Define the type of WP request
* Version: 1.1.0
* Update date: 2025-05-15
* Author: Jaro Kurimsky
* License: GPLv2 or later
*/	

require __DIR__.'/wp-request-type.php';

switch(WPSD_REQUEST_TYPE){

	case REQUEST_FRONTEND:

		//your code for front-end
		break;

	case REQUEST_ADMIN:

		//your code for the admin area
		break;

	case REQUEST_AJAX:

		//your code for AJAX
		break;
}
