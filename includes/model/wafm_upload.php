<?php

class WafmUploadClass {

    function __construct() {
        if ( ! function_exists( 'wp_handle_upload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
    }

    function image( $data = array() ) {
        $result = array(
            'result'    => false,
            'msg'       => ''
        );

        $uploadedfile = $data['file'];
        $upload_overrides = array( 'test_form' => false );
        $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

        if ( $movefile && ! isset( $movefile['error'] ) ) {
            $result['result'] = true;
            $result['msg'] = 'Uploaded.';
            $result['data'] = $movefile;
        } else {
            $result['msg'] = $movefile['error'];
        }

        return $result;
    }

}