<?php

/*
* Plugin Name: WP_REQUEST_TYPE definition and usage example
* Plugin URI: https://wpspeeddoctor.com/plugins/
* Description: Define type of WP request
* Version: 1.0.0
* Update date: 2024-08-29
* Author: Jaro Kurimsky
* License: GPLv2 or later
*/	

defined( 'WP_REQUEST_TYPE') || define( 'WP_REQUEST_TYPE', get_wp_request_type() );

/**
 * Example #1
 */

switch( WP_REQUEST_TYPE ){
	
	case 'frontend':
		
		// requite files with code for the front-end
		break;
	
	case 'admin':

		// requite files with code for the admin area
		break;
			
	case 'ajax':

		//update/activate/deactivate hooks
		
		//for your own ajax requests
		break;

	default:

		// When you sure your code has to run on every request type.
		break;
	
}

/**
 * Example #2
 * When you have only front-end and admin code
 */

if( WP_REQUEST_TYPE === 'frontend'){

		//use require to load file that contains frontend code

}

/**
 * @var null
 * @return string -
 * - cron
 * - ajax
 * - admin
 * - login
 * - xmlrpc
 * - empty
 * - rest
 * - sitemap
 * - 404
 * - fe
*/
	
//use function name suffix or namespace to avoid conflict with the same named function
function get_wp_request_type(){ 
	
	switch(true){
	
		case isset( $_GET['wc-ajax'] ) || wp_doing_ajax():
			
			return 'ajax';
			break;

		case is_admin():

			return 'admin';
			break;

			
		case wp_doing_cron():

			return 'cron';
			break;

		case is_callable('login_header'):
		
			return 'login';
			break;
			
		case defined( 'XMLRPC_REQUEST'):

			return 'xmlrpc';
			break;

		case '' === $uri_path = strstr( $_SERVER['REQUEST_URI']??'', '?', true ) ?: $_SERVER['REQUEST_URI']??'':

			return 'empty';
			break;

		case str_contains( $uri_path,'/wp-json/' ):
			
			return 'rest';
			break;

		case str_contains( $uri_path, 'sitemap' ) && str_ends_with( $uri_path, '.xml'):

			return 'sitemap';
			break;

		case str_contains( $uri_path,'.'):

			return '404';
			break;

		default:
			
			return 'frontend';
			break;
	}

}
