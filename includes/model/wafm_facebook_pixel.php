<?php

class WafmFacebookPixelClass {

    function save( $data = array() ) {
        $result = array(
            'result'    => true,
            'msg'       => 'Saved.'
        );

        update_option( 'wafm_facebook_pixel_view_content', $data['view_content'] );
        update_option( 'wafm_facebook_pixel_add_to_cart', $data['add_to_cart'] );
        update_option( 'wafm_facebook_pixel_initiate_checkout', $data['initiate_checkout'] );
        update_option( 'wafm_facebook_pixel_purchase', $data['purchase'] );

        return $result;
    }

}