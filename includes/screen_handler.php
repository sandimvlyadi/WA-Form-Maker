<?php

if ( !is_admin() ) {
	return;
}

function wafm_form_list_page() {
	wp_register_script( 'wafm_form_list', plugin_dir_url(WAFM_PLUGIN) . 'admin/js/wafm_form_list.js' );
	wp_enqueue_script( 'wafm_form_list', '', '', '', true );
	wp_localize_script( 'wafm_form_list', 'wafm', array(
	    'siteurl' => get_site_url('/'),
	    'apiSettings' => array(
			'root' => esc_url_raw( rest_url( 'wafm/v1' ) ),
			'namespace' => 'wafm/v1',
		),
	));
}

function wafm_reception_numbers_page() {
	wp_register_script( 'wafm_reception_numbers', plugin_dir_url(WAFM_PLUGIN) . 'admin/js/wafm_reception_numbers.js' );
	wp_enqueue_script( 'wafm_reception_numbers', '', '', '', true );
	wp_localize_script( 'wafm_reception_numbers', 'wafm', array(
	    'siteurl' => get_site_url('/'),
	    'apiSettings' => array(
			'root' => esc_url_raw( rest_url( 'wafm/v1' ) ),
			'namespace' => 'wafm/v1',
		),
		'imgurl' => plugin_dir_url(WAFM_PLUGIN) . 'public/images/',
	));
}

function wafm_follow_up_page() {
	wp_register_script( 'wafm_follow_up', plugin_dir_url(WAFM_PLUGIN) . 'admin/js/wafm_follow_up.js' );
	wp_enqueue_script( 'wafm_follow_up', '', '', '', true );
	wp_localize_script( 'wafm_follow_up', 'wafm', array(
	    'siteurl' => get_site_url('/'),
	    'apiSettings' => array(
			'root' => esc_url_raw( rest_url( 'wafm/v1' ) ),
			'namespace' => 'wafm/v1',
		),
		'fileurl' => plugin_dir_url(WAFM_PLUGIN) . 'public/files/',
	));
}

function wafm_facebook_pixel_page() {
	wp_register_script( 'wafm_facebook_pixel', plugin_dir_url(WAFM_PLUGIN) . 'admin/js/wafm_facebook_pixel.js' );
	wp_enqueue_script( 'wafm_facebook_pixel', '', '', '', true );
	wp_localize_script( 'wafm_facebook_pixel', 'wafm', array(
	    'siteurl' => get_site_url('/'),
	    'apiSettings' => array(
			'root' => esc_url_raw( rest_url( 'wafm/v1' ) ),
			'namespace' => 'wafm/v1',
		),
	));
}

function wafm_license_page() {
	wp_register_script( 'wafm_license', plugin_dir_url(WAFM_PLUGIN) . 'admin/js/wafm_license.js' );
	wp_enqueue_script( 'wafm_license', '', '', '', true );
	wp_localize_script( 'wafm_license', 'wafm', array(
	    'siteurl' => get_site_url('/'),
	    'apiSettings' => array(
			'root' => esc_url_raw( rest_url( 'wafm/v1' ) ),
			'namespace' => 'wafm/v1',
		),
	));
}

function dequeue_external_scripts() {
	global $wp_scripts;
	$core = array( 'common', 'admin-bar', 'utils', 'svg-painter', 'wp-auth-check', 'bootstrap', 'datatables', 'select2', 'fontawesome', 'notify' );
	foreach ( $wp_scripts->queue as $script ) {
		if( in_array( $script, $core ) ){
			// pass dequeueing script
		} else{
			if( strpos( $script, 'wafm' ) === false ){
				wp_dequeue_script( $script );
			}
		}
	}
}

$page = empty($_GET['page']) ? null : $_GET['page'];
if ($page != null) {
	if ($page === 'wafm_form_list') {
		add_action( 'admin_enqueue_scripts', 'wafm_form_list_page' );
	}

	if ($page === 'wafm_reception_numbers') {
		add_action( 'admin_enqueue_scripts', 'wafm_reception_numbers_page' );
	}

	if ($page === 'wafm_follow_up') {
		add_action( 'admin_enqueue_scripts', 'wafm_follow_up_page' );
	}

	if ($page === 'wafm_facebook_pixel') {
		add_action( 'admin_enqueue_scripts', 'wafm_facebook_pixel_page' );
	}

	if ($page === 'wafm_license') {
		add_action( 'admin_enqueue_scripts', 'wafm_license_page' );
	}
}