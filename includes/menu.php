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

function checkKeServer( $data = array() )
{
	$ch = curl_init();
	$fields  = array(
		'key'    	=> $data['key'],
		'email'    	=> $data['email'],
		'string'  	=> $_SERVER['HTTP_HOST']
	);

	curl_setopt($ch, CURLOPT_URL,"https://id.my-aksen.com/check/license");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($fields));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response  = curl_exec($ch);
	curl_close($ch); 

	return json_decode($response);
}

function checkLicense() {
	$email = get_option( 'wafm_license_email' );
	$key = get_option( 'wafm_license_key' );
	$param = array(
		'key' 	=> $key,
		'email' => $email
	);

	$response = checkKeServer( $param );

	return $response;
}

function adminsubmenu() {
	$c = checkLicense();
	if ( $c->result ) {
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
			'Follow Up',
			'Follow Up',
			'manage_options',
			'wafm_follow_up',
			'adminsubmenu_follow_up_function'
		);

		add_submenu_page(
			'wafm',
			'Facebook Pixel',
			'Facebook Pixel',
			'manage_options',
			'wafm_facebook_pixel',
			'adminsubmenu_facebook_pixel_function'
		);

		add_submenu_page(
			'wafm',
			'License',
			'License',
			'manage_options',
			'wafm_license',
			'adminsubmenu_license_function'
		);
	} else {
		add_submenu_page(
			'wafm',
			'License',
			'License',
			'manage_options',
			'wafm_license',
			'adminsubmenu_license_function'
		);
	}
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

function adminsubmenu_follow_up_function() {
	require_once WAFM_PLUGIN_DIR . '/admin/follow_up.php';
}

function adminsubmenu_facebook_pixel_function() {
	require_once WAFM_PLUGIN_DIR . '/admin/facebook_pixel.php';
}

// function adminsubmenu_form_detail_function() {
// 	require_once WAFM_PLUGIN_DIR . '/admin/form_detail.php';
// }

function adminsubmenu_license_function() {
	require_once WAFM_PLUGIN_DIR . '/admin/license.php';
}

add_action( 'admin_menu', 'adminmenu' );
add_action( 'admin_menu', 'adminsubmenu' );