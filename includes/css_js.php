<?php

// CSS
function wafm_style() {
	wp_register_style( 'bootstrap', plugin_dir_url(WAFM_PLUGIN) . 'admin/css/bootstrap.min.css' );
	wp_register_style( 'select2', plugin_dir_url(WAFM_PLUGIN) . 'admin/css/select2.min.css' );
	wp_register_style( 'datatables', plugin_dir_url(WAFM_PLUGIN) . 'admin/datatables/datatables.min.css' );
	wp_register_style( 'fontawesome', plugin_dir_url(WAFM_PLUGIN) . 'admin/fontawesome/css/all.min.css' );
	wp_register_style( 'wafm', plugin_dir_url(WAFM_PLUGIN) . 'admin/css/wafm.css' );

	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'select2' );
	wp_enqueue_style( 'datatables' );
	wp_enqueue_style( 'fontawesome' );
	wp_enqueue_style( 'wafm' );
}

function wafm_style_public() {
	wp_register_style( 'bootstrap', plugin_dir_url(WAFM_PLUGIN) . 'admin/css/bootstrap.min.css' );
	wp_register_style( 'fontawesome', plugin_dir_url(WAFM_PLUGIN) . 'admin/fontawesome/css/all.min.css' );
	wp_register_style( 'wafm', plugin_dir_url(WAFM_PLUGIN) . 'admin/css/wafm.css' );
	wp_register_style( 'wafm-form', plugin_dir_url(WAFM_PLUGIN) . 'public/css/wafm-form.css' );

	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'fontawesome' );
	wp_enqueue_style( 'wafm' );
	wp_enqueue_style( 'wafm-form' );
}

// End of CSS

// *** *** *** *** *** *** *** *** *** *** *** *** ***

// JS
function wafm_script() {
	wp_register_script( 'bootstrap', plugin_dir_url(WAFM_PLUGIN) . 'admin/js/bootstrap.min.js' );
	wp_register_script( 'datatables', plugin_dir_url(WAFM_PLUGIN) . 'admin/datatables/datatables.min.js' );
	wp_register_script( 'select2', plugin_dir_url(WAFM_PLUGIN) . 'admin/js/select2.full.min.js' );
	wp_register_script( 'fontawesome', plugin_dir_url(WAFM_PLUGIN) . 'admin/fontawesome/js/all.min.js' );
	wp_register_script( 'notify', plugin_dir_url(WAFM_PLUGIN) . 'admin/js/bootstrap-notify.min.js' );
	wp_register_script( 'wafm', plugin_dir_url(WAFM_PLUGIN) . 'admin/js/wafm.js' );

	wp_enqueue_script( 'bootstrap', '', '', '', true );
	wp_enqueue_script( 'datatables', '', '', '', true );
	wp_enqueue_script( 'select2', '', '', '', true );
	wp_enqueue_script( 'fontawesome', '', '', '', true );
	wp_enqueue_script( 'notify', '', '', '', true );
	wp_enqueue_script( 'wafm', '', '', '', true );
	wp_localize_script( 'wafm', 'wafm', array(
	    'siteurl' => get_site_url('/'),
	    'apiSettings' => array(
			'root' => esc_url_raw( rest_url( 'wafm/v1' ) ),
			'namespace' => 'wafm/v1',
		),
	));
}

function wafm_script_public() {
	wp_register_script( 'bootstrap', plugin_dir_url(WAFM_PLUGIN) . 'admin/js/bootstrap.min.js' );
	wp_register_script( 'fontawesome', plugin_dir_url(WAFM_PLUGIN) . 'admin/fontawesome/js/all.min.js' );
	wp_register_script( 'notify', plugin_dir_url(WAFM_PLUGIN) . 'admin/js/bootstrap-notify.min.js' );
	wp_register_script( 'wafm', plugin_dir_url(WAFM_PLUGIN) . 'admin/js/wafm.js' );

	wp_enqueue_script( 'bootstrap', '', '', '', true );
	wp_enqueue_script( 'fontawesome', '', '', '', true );
	wp_enqueue_script( 'notify', '', '', '', true );
	wp_enqueue_script( 'wafm', '', '', '', true );
	wp_localize_script( 'wafm', 'wafm', array(
	    'siteurl' => get_site_url('/'),
	    'apiSettings' => array(
			'root' => esc_url_raw( rest_url( 'wafm/v1' ) ),
			'namespace' => 'wafm/v1',
		),
		'fbPixelViewContent' => plugin_dir_url(WAFM_PLUGIN) . 'public/js/wafm_facebook_pixel_view_content.js',
		'fbPixelAddToCart' => plugin_dir_url(WAFM_PLUGIN) . 'public/js/wafm_facebook_pixel_add_to_cart.js',
		'fbPixelInitiateCheckout' => plugin_dir_url(WAFM_PLUGIN) . 'public/js/wafm_facebook_pixel_initiate_checkout.js',
		'fbPixelPurchase' => plugin_dir_url(WAFM_PLUGIN) . 'public/js/wafm_facebook_pixel_purchase.js',
	));
}

// End of JS

if ( is_admin() ) {
	$page = empty($_GET['page']) ? null : $_GET['page'];
	if ($page != null) {
		if (strpos($page, 'wafm') !== false) {
			add_action( 'admin_enqueue_scripts', 'wafm_style' );
			add_action( 'admin_enqueue_scripts', 'wafm_script' );
		}
	}
} else{
	add_action( 'wp_enqueue_scripts', 'wafm_style_public' );
	add_action( 'wp_enqueue_scripts', 'wafm_script_public' );
}