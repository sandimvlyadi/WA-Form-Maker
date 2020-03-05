<?php

class WafmLicenseClass {

    function save( $data = array() ) {
        $result = array(
            'result'    => false,
            'msg'       => ''
        );

        $ch = curl_init();
        $fields  = array(
            'key'       => $data['key'],
            'email'     => $data['email'],
            'string'    => $_SERVER['HTTP_HOST']
        );

        curl_setopt($ch, CURLOPT_URL,"https://link.aksendigital.id/check/license");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response  = curl_exec($ch);
        curl_close($ch); 

        $response = json_decode($response);
        if ($response->result) {
            update_option( 'wafm_license_email', $data['email'] );
            update_option( 'wafm_license_key', $data['key'] );

            $result['result'] = true;
            $result['msg'] = 'Activated.';
        } else{
            $result['msg'] = $response->content;
        }

        return $result;
    }

}
