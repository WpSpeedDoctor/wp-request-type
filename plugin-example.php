<?php

/*
* Plugin Name: WP_REQUEST_TYPE definition and usage example
* Plugin URI: https://wpspeeddoctor.com/plugins/
* Description: Define the type of WP request
* Version: 1.0.0
* Update date: 2024-09-21
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
	
}

/**
 * Example #2
 * When you have only front-end and admin code
 */

if( WP_REQUEST_TYPE === 'frontend' || WP_REQUEST_TYPE === 'admin' ){

		//use require to load file that contains frontend and admin code

}

/**
 * @return string -
 * - ajax
 * - admin
 * - cron
 * - login
 * - xmlrpc
 * - empty
 * - rest
 * - sitemap
 * - 404
 * - frontend
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
