<?php

require_once WAFM_PLUGIN_DIR . '/includes/model/wafm_form_list.php';
require_once WAFM_PLUGIN_DIR . '/includes/model/wafm_reception_numbers.php';
require_once WAFM_PLUGIN_DIR . '/includes/model/wafm_follow_up.php';
require_once WAFM_PLUGIN_DIR . '/includes/model/wafm_upload.php';
require_once WAFM_PLUGIN_DIR . '/includes/model/wafm.php';
require_once WAFM_PLUGIN_DIR . '/includes/model/wafm_facebook_pixel.php';
require_once WAFM_PLUGIN_DIR . '/includes/model/wafm_license.php';

add_action( 'rest_api_init', 'routes_init' );

function routes_init() {
	$namespace = 'wafm/v1';

	register_rest_route( $namespace,
		'/wafm_form_list/datatables',
		array(
			array(
				'methods' => WP_REST_Server::READABLE,
				'callback' => 'wafm_form_list_datatables',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_form_list/details',
		array(
			array(
				'methods' => WP_REST_Server::READABLE,
				'callback' => 'wafm_form_list_details',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_form_list/export/(?P<id>\d+)',
		array(
			array(
				'methods' => WP_REST_Server::READABLE,
				'callback' => 'wafm_form_list_export',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_form_list/save',
		array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => 'wafm_form_list_save',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_form_list/edit/(?P<id>\d+)',
		array(
			array(
				'methods' => WP_REST_Server::READABLE,
				'callback' => 'wafm_form_list_edit',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_form_list/delete',
		array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => 'wafm_form_list_delete',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_reception_numbers/datatables',
		array(
			array(
				'methods' => WP_REST_Server::READABLE,
				'callback' => 'wafm_reception_numbers_datatables',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_reception_numbers/save',
		array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => 'wafm_reception_numbers_save',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_reception_numbers/edit/(?P<id>\d+)',
		array(
			array(
				'methods' => WP_REST_Server::READABLE,
				'callback' => 'wafm_reception_numbers_edit',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_reception_numbers/delete',
		array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => 'wafm_reception_numbers_delete',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_reception_numbers/select/(?P<id>\d+)',
		array(
			array(
				'methods' => WP_REST_Server::READABLE,
				'callback' => 'wafm_reception_numbers_select',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_follow_up/datatables',
		array(
			array(
				'methods' => WP_REST_Server::READABLE,
				'callback' => 'wafm_follow_up_datatables',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_follow_up/save',
		array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => 'wafm_follow_up_save',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_follow_up/edit/(?P<id>\d+)',
		array(
			array(
				'methods' => WP_REST_Server::READABLE,
				'callback' => 'wafm_follow_up_edit',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_follow_up/delete',
		array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => 'wafm_follow_up_delete',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_wafm_follow_up/select/(?P<id>\d+)',
		array(
			array(
				'methods' => WP_REST_Server::READABLE,
				'callback' => 'wafm_follow_up_select',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_follow_up/send',
		array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => 'wafm_follow_up_send',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_upload/image',
		array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => 'wafm_upload_image',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_upload/follow_up_import',
		array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => 'wafm_upload_follow_up_import',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm/send',
		array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => 'wafm_send',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_facebook_pixel/save',
		array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => 'wafm_facebook_pixel_save',
			)
		)
	);

	register_rest_route( $namespace,
		'/wafm_license/save',
		array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => 'wafm_license_save',
			)
		)
	);
}

function wafm_form_list_datatables( WP_REST_Request $request ) {
	$c = new WafmFormListClass();
	$r = $c->datatables( $request );
	return rest_ensure_response( $r );
}

function wafm_form_list_details( WP_REST_Request $request ) {
	$c = new WafmFormListClass();
	$r = $c->details( $request );
	return rest_ensure_response( $r );
}

function wafm_form_list_export( WP_REST_Request $request ) {
	$id = (int) $request->get_param( 'id' );
	$c = new WafmFormListClass();
	$r = $c->export( $id );

	if ($r['result']) {
		$d = $r['data'];
		$filename = 'export_' . time() . '.csv';

		$csv = $d[0]->field . "\n";
		for ($i=0; $i < count($d); $i++) { 
			$csv .= $d[$i]->value . "\n";
		}

		header("Content-type: application/vnd.ms-excel");
		header("Content-disposition: csv" . date("Y-m-d") . ".csv");
		header("Content-disposition: filename=".$filename);
		print $csv;
		exit;
	}

	return rest_ensure_response( $r );
}

function wafm_form_list_save( WP_REST_Request $request ) {
	$c = new WafmFormListClass();
	$r = $c->save( $request );
	return rest_ensure_response( $r );
}

function wafm_form_list_edit( WP_REST_Request $request ) {
	$id = (int) $request->get_param( 'id' );
	$c = new WafmFormListClass();
	$r = $c->edit( $id );
	return rest_ensure_response( $r );
}

function wafm_form_list_delete( WP_REST_Request $request ) {
	$c = new WafmFormListClass();
	$r = $c->delete( $request );
	return rest_ensure_response( $r );
}

function wafm_reception_numbers_datatables( WP_REST_Request $request ) {
	$c = new WafmReceptionNumbersClass();
	$r = $c->datatables( $request );
	return rest_ensure_response( $r );
}

function wafm_reception_numbers_save( WP_REST_Request $request ) {
	$c = new WafmReceptionNumbersClass();
	$r = $c->save( $request );
	return rest_ensure_response( $r );
}

function wafm_reception_numbers_edit( WP_REST_Request $request ) {
	$id = (int) $request->get_param( 'id' );
	$c = new WafmReceptionNumbersClass();
	$r = $c->edit( $id );
	return rest_ensure_response( $r );
}

function wafm_reception_numbers_delete( WP_REST_Request $request ) {
	$c = new WafmReceptionNumbersClass();
	$r = $c->delete( $request );
	return rest_ensure_response( $r );
}

function wafm_reception_numbers_select( WP_REST_Request $request ) {
	$id = (int) $request->get_param( 'id' );
	$c = new WafmReceptionNumbersClass();
	$r = $c->select( $id );
	return rest_ensure_response( $r );
}

function wafm_follow_up_datatables( WP_REST_Request $request ) {
	$c = new WafmFollowUpClass();
	$r = $c->datatables( $request );
	return rest_ensure_response( $r );
}

function wafm_follow_up_save( WP_REST_Request $request ) {
	$c = new WafmFollowUpClass();
	$r = $c->save( $request );
	return rest_ensure_response( $r );
}

function wafm_follow_up_edit( WP_REST_Request $request ) {
	$id = (int) $request->get_param( 'id' );
	$c = new WafmFollowUpClass();
	$r = $c->edit( $id );
	return rest_ensure_response( $r );
}

function wafm_follow_up_delete( WP_REST_Request $request ) {
	$c = new WafmFollowUpClass();
	$r = $c->delete( $request );
	return rest_ensure_response( $r );
}

function wafm_follow_up_select( WP_REST_Request $request ) {
	$id = (int) $request->get_param( 'id' );
	$c = new WafmFollowUpClass();
	$r = $c->select( $id );
	return rest_ensure_response( $r );
}

function wafm_follow_up_send( WP_REST_Request $request ) {
	$c = new WafmFollowUpClass();
	$r = $c->send( $request );
	return rest_ensure_response( $r );
}

function wafm_upload_image( WP_REST_Request $request ) {
	$c = new WafmUploadClass();
	$r = $c->image( $_FILES );
	return rest_ensure_response( $r );
}

function wafm_upload_follow_up_import( WP_REST_Request $request ) {
	$c = new WafmUploadClass();
	$r = $c->follow_up_import( $_FILES );
	return rest_ensure_response( $r );
}

function wafm_send( WP_REST_Request $request ) {
	$c = new WafmClass();
	$r = $c->send( $request );
	return rest_ensure_response( $r );
}

function wafm_facebook_pixel_save( WP_REST_Request $request ) {
	$c = new WafmFacebookPixelClass();
	$r = $c->save( $request );
	return rest_ensure_response( $r );
}

function wafm_license_save( WP_REST_Request $request ) {
	$c = new WafmLicenseClass();
	$r = $c->save( $_POST );
	return rest_ensure_response( $r );
}