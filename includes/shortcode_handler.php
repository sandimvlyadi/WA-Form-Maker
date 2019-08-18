<?php

require_once WAFM_PLUGIN_DIR . '/includes/model/wafm_form_list.php';

function field_generator( $data = array() ) {
	$id = $data['id'];
	$button = $data['button'];
	$send = $data['send'];
	$title = $data['title'];

	$result = "<div class='row'><div class='col text-center'><button name='btn_modal' class='btn btn-default btn-lg mb-3' data-toggle='modal' data-target='#wafmModal". $id ."'><i class='fab fa-whatsapp'></i> ". $button ."</button></div></div>";
	$result .= "<div class='modal fade' id='wafmModal". $id ."' role='dialog' aria-labelledby='wafmTitle". $data['id'] ."' aria-hidden='true'><div class='modal-dialog modal-dialog-centered' role='document'><div class='modal-content'><div class='modal-header text-center d-block'><i class='fab fa-whatsapp text-white fa-2x'></i> <h5 class='modal-title d-inline-block text-white' id='wafmLongTitle'>". $title ."</h5><button type='button' class='close text-white' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><div class='modal-body'>";
	$result .= "<form id='wafmData". $id ."'>";

	$fields = $data['fields'];
	for ($i=0; $i < count($fields); $i++) { 
		$field = $fields[$i];
		$ipos = stripos($field, ":");
		$a = substr($field, 0, $ipos - 1);
		$iipos = stripos($a, "|");
		$aa = substr($a, $iipos + 1, strlen($a) - $iipos + 1);
		$icon = str_replace("^", "", substr($a, 0, $iipos));
		$b = substr($field, $ipos + 2, strlen($field) - $ipos + 2);

		if (strpos($a, "^") === false) {
			$result .= "<div class='input-group mb-3'><div class='input-group-prepend'><span class='input-group-text'><i class='". $icon ."'></i></span></div><input name='". $aa ."' type='text' class='form-control form-control-wafm' placeholder='". $b ."'></div>";
		} else{
			$result .= "<div class='input-group mb-3'><div class='input-group-prepend'><span class='input-group-text'><i class='". $icon ."'></i></span></div><input name='". $aa ."' type='text' class='form-control form-control-wafm' placeholder='". $b ." (required)' required></div>";
		}
	}

	$options = $data['options'];
	for ($i=0; $i < count($options); $i++) { 
		$option = $options[$i];
		$ipos = stripos($option, ":");
		$rpos = strrpos($option, ":");
		$a = substr($option, 0, $ipos - 1);
		$iipos = stripos($a, "|");
		$aa = substr($a, $iipos + 1, strlen($a) - $iipos + 1);
		$icon = str_replace("^", "", substr($a, 0, $iipos));
		$name = substr($option, $ipos + 2, $rpos - $ipos - 2);
		$b = substr($option, $rpos + 2, strlen($option) - $rpos + 2);

		if (strpos($a, "^") === false) {
			$result .= "<div class='input-group mb-3'><div class='input-group-prepend'><span class='input-group-text'><i class='". $icon ."'></i></span></div><select name='". $aa ."' class='form-control'>";
			$result .= "<option value=''>- Choose ". $name ." -</option>";
			$bb = explode(",", $b);
			for ($j=0; $j < count($bb); $j++) { 
				$result .= "<option value='". $bb[$j] ."'>". $bb[$j] ."</option>";
			}
			$result .= "</select>";
			$result .= "</div>";
		} else{
			$result .= "<div class='input-group mb-3'><div class='input-group-prepend'><span class='input-group-text'><i class='". $icon ."'></i></span></div><select name='". $aa ."' class='form-control'>";
			$bb = explode(",", $b);
			for ($j=0; $j < count($bb); $j++) { 
				$result .= "<option value='". $bb[$j] ."'>". $bb[$j] ."</option>";
			}
			$result .= "</select>";
			$result .= "</div>";
		}
	}

	$result .= "</form></div>";
	$result .= "<div class='modal-footer justify-content-center'><button id='". $id ."' name='btn_send' type='button' class='btn btn-default btn-lg'><i class='fab fa-whatsapp'></i> ". $send ."</button></div>";
	$result .= "</div></div></div>";

	$data = array(
		'view_content' => get_option('wafm_facebook_pixel_view_content'),
		'add_to_cart' => get_option('wafm_facebook_pixel_add_to_cart'),
		'initiate_checkout' => get_option('wafm_facebook_pixel_initiate_checkout'),
		'purchase' => get_option('wafm_facebook_pixel_purchase')
	);

	$result .= "<div class='wafm-facebook-pixel'><input type='hidden' name='view_content' value='". $data['view_content'] ."'><input type='hidden' name='add_to_cart' value='". $data['add_to_cart'] ."'><input type='hidden' name='initiate_checkout' value='". $data['initiate_checkout'] ."'><input type='hidden' name='purchase' value='". $data['purchase'] ."'></div>";

	// if ($data['view_content'] == 'yes') {
	// 	$result .= "<script>fbq('track', 'ViewContent');</script>";
	// }

	// if ($data['add_to_cart'] == 'yes') {
	// 	$result .= "<script>fbq('track', 'AddToCart');</script>";
	// }

	// if ($data['initiate_checkout'] == 'yes') {
	// 	$result .= "<script>fbq('track', 'InitiateCheckout');</script>";
	// }

	// if ($data['purchase'] == 'yes') {
	// 	$result .= "<script>fbq('track', 'Purchase');</script>";
	// }

	return $result;
}

function wafm_function( $atts ) {
	$param = shortcode_atts( array(
		'id' => 0,
		'title' => '',
	), $atts );

	$c = new WafmFormListClass();
	$r = $c->select( $param['id'] );
	if ( $r['result'] ) {
		$message = $r['data'][0]->message;
		$button = $r['data'][0]->button_name;
		$send = $r['data'][0]->button_send;
		$title = $r['data'][0]->name;
		$fields = array();
		$options = array();

		$find = true;
		while( $find ) {
			$ipos = stripos($message, "{{");
			$rpos = stripos($message, "}}");
			if($ipos === false or $rpos === false) {
			  	$find = false;
			} else {
			  	array_push($fields, substr($message, $ipos + 3, $rpos - $ipos - 4));
			  	$message = substr($message, $rpos + 2);
			}
		}

		$message = $r['data'][0]->message;
		$find = true;
		while( $find ) {
			$ipos = stripos($message, "[[");
			$rpos = stripos($message, "]]");
			if($ipos === false or $rpos === false) {
			  	$find = false;
			} else {
			  	array_push($options, substr($message, $ipos + 3, $rpos - $ipos - 4));
			  	$message = substr($message, $rpos + 2);
			}
		}

		$data = array(
			'id' => $param['id'],
			'fields' => $fields,
			'options' => $options,
			'button' => $button,
			'send' => $send,
			'title' => $title
		);

		return field_generator( $data );
	} else{
		return "<b>WAFM code was wrong.</b>";
	}
}

add_shortcode( 'wafm', 'wafm_function' );