<?php

function adminmenu() {
	add_menu_page(
		'WA Form Maker',
		'WA Form Maker',
		'',
		'wafm',
		'adminmenu_function',
		plugin_dir_url(WAFM_PLUGIN) . 'admin/images/whatsapp.png'
	);
}

function adminsubmenu() {
	add_submenu_page(
		'wafm',
		'Form List',
		'Form List',
		'manage_options',
		'wafm_form_list',
		'adminsubmenu_form_list_function'
	);

	add_submenu_page(
		'wafm',
		'Reception Numbers',
		'Reception Numbers',
		'manage_options',
		'wafm_reception_numbers',
		'adminsubmenu_reception_numbers_function'
	);

	add_submenu_page(
		'wafm',
		'Facebook Pixel',
		'Facebook Pixel',
		'manage_options',
		'wafm_facebook_pixel',
		'adminsubmenu_facebook_pixel_function'
	);
}

function adminmenu_function() {
	require_once WAFM_PLUGIN_DIR . '/admin/wafm.php';
}

function adminsubmenu_form_list_function() {
	require_once WAFM_PLUGIN_DIR . '/admin/form_list.php';
}

function adminsubmenu_reception_numbers_function() {
	require_once WAFM_PLUGIN_DIR . '/admin/reception_numbers.php';
}

function adminsubmenu_facebook_pixel_function() {
	require_once WAFM_PLUGIN_DIR . '/admin/facebook_pixel.php';
}

add_action( 'admin_menu', 'adminmenu' );
add_action( 'admin_menu', 'adminsubmenu' );