<?php

//Add your namespace

// Using WPSD prefix as WP is exclusively used in WP core. 
// WP_URI_PATH should be added into WP core as many plugins many times are parsing URL to get URI Path
defined('WPSD_URI_PATH') || define('WPSD_URI_PATH', strstr( $_SERVER['REQUEST_URI']??'', '?', true ) ?: $_SERVER['REQUEST_URI']??'');


if( !defined( 'WPSD_REQUEST_TYPE' ) ){
	define( 'REQUEST_FRONTEND',	1 );
	define( 'REQUEST_AJAX',		2 );
	define( 'REQUEST_ADMIN',	3 );
	define( 'REQUEST_CRON',		4 );
	define( 'REQUEST_LOGIN',	5 );
	define( 'REQUEST_XMLRPC',	6 );
	define( 'REQUEST_EMPTY',	7 );
	define( 'REQUEST_REST',		8 );
	define( 'REQUEST_SITEMAP',	9 );
	define( 'REQUEST_DIRECT',	10 );
	define( 'REQUEST_404',		11 );
	define( 'REQUEST_FEED',		12 );
	define( 'REQUEST_CLI',		13 );
	define( 'WPSD_REQUEST_TYPE', get_wp_request_type() );
}

function get_wp_request_type(){

	switch(true){

		case wp_doing_ajax() || isset( $_GET['wc-ajax'] ):
			return REQUEST_AJAX;

		case is_admin():
			return REQUEST_ADMIN;

		case wp_doing_cron():
			return REQUEST_CRON;

		case is_callable( 'login_header' ):
			return REQUEST_LOGIN;

		case defined( 'XMLRPC_REQUEST' ):
			return REQUEST_XMLRPC;

		case defined( 'WP_CLI' ):
			return REQUEST_CLI;

		case WPSD_URI_PATH === '':
			return REQUEST_EMPTY;

		//wp_is_json_request() is making false positives for front-end requests
		case str_contains( WPSD_URI_PATH,'/wp-json/' ): 
			return REQUEST_REST;

		//fallthough solution for improved performance
		case ($extension = strstr( WPSD_URI_PATH,'.') ) === null:
		
		case $extension === '.xml' && str_contains( WPSD_URI_PATH, 'sitemap' ):
			return REQUEST_SITEMAP;

		case $extension === '.php':
			return REQUEST_DIRECT;

		case $extension !== false:
			return REQUEST_404;

		case str_ends_with( WPSD_URI_PATH, '/feed/' ) || str_ends_with( WPSD_URI_PATH, '/feed' ):
			return REQUEST_FEED;

		default:
			return REQUEST_FRONTEND;
	}
}

