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

    function follow_up_import( $data = array() ) {
        $result = array(
            'result'    => false,
            'msg'       => ''
        );

        $uploadedfile = $data['file'];
        $upload_overrides = array( 'test_form' => false );
        $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

        if ( $movefile && ! isset( $movefile['error'] ) ) {
            global $wpdb;
            $user_id = apply_filters( 'determine_current_user', false );
            wp_set_current_user( $user_id );

            $result['result'] = true;
            $result['msg'] = 'Imported.';
            $result['data'] = $movefile;

            $file = $movefile['file'];
            $i = 0;
            $handle = fopen($file, "r");
            while (($row = fgetcsv($handle, 2048))) {
                $i++;
                if ($i == 1) continue;
                $name = $row[0];
                $number = $row[1];

                if($number[0] == '0'){
                    $number = '62' . substr($number, 1);
                }
        
                if($number[0] == '+'){
                    $number = substr($number, 1);
                }

                $res = $wpdb->insert(
                    'wafm_follow_up_number',
                    array(
                        'created_at' => current_time('mysql', 8),
                        'created_by' => get_current_user_id(),
                        'name' => $name,
                        'number' => $number
                    )
                );
            }

            fclose($handle);
        } else {
            $result['msg'] = $movefile['error'];
        }

        return $result;
    }

}