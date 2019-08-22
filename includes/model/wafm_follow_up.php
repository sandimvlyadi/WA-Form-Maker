<?php

class WafmFollowUpClass {

	function _get($data = array())
    {
    	$q = "SELECT * FROM `wafm_follow_up_number` ";

        if ( $data['search']['value'] && !isset( $data['all'] ) ) {
        	$s = sanitize_text_field( $data['search']['value'] );
            $q .= "WHERE (`name` LIKE '%". $s ."%' OR `number` LIKE '%". $s ."%') AND `deleted_at` IS NULL ";
        } else{
        	$q .= "WHERE `deleted_at` IS NULL ";
        }

        if (isset($data['order'])) {
        	$dir = sanitize_text_field( $data['order'][0]['dir'] );
        	$col = sanitize_text_field( $data['columns'][$data['order'][0]['column']]['data'] );
        	if ( $data['order'][0]['column'] != 0 ) {
                $q .= "ORDER BY `". $col ."` ". $dir ." ";
        	} else{
        		$q .= "ORDER BY `id` ". $dir ." ";
        	}
        } else{
        	$q .= "ORDER BY `id` DESC ";
        }

        return $q;
    }

    function _list($data = array())
    {
    	global $wpdb;
        $q = $this->_get( $data );
        $q .= "LIMIT ". sanitize_text_field( $data['start'] ) .", ". sanitize_text_field( $data['length'] );
        $r = $wpdb->get_results( $q );

        return $r;
    }

    function _filtered($data = array())
    {
    	global $wpdb;
        $q = $this->_get( $data );
        $r = $wpdb->get_results( $q );

        return count( $r );
    }

    function _all($data = array())
    {
    	global $wpdb;
        $data['all'] = true;
        $q = $this->_get( $data );
        $r = $wpdb->get_results( $q );

        return count( $r );
    }

	function datatables( $data = array() ) {
		$result = array(
            'draw'              => 1,
            'recordsTotal'      => 0,
            'recordsFiltered'   => 0,
            'data'              => array(),
            'result'            => false,
            'msg'               => ''
        );

        $list = $this->_list( $data );
        if ( count( $list ) > 0 ) {
            $result = array(
                'draw'              => $data['draw'],
                'recordsTotal'      => $this->_all( $data ),
                'recordsFiltered'   => $this->_filtered( $data ),
                'data'              => $list,
                'result'            => true,
                'msg'               => 'Loaded.',
                'start'             => (int) $data['start'] + 1
            );
        } else{
            $result['msg'] = 'No data left.';
        }

        return $result;
	}

    function save( $data = array() ) {
        global $wpdb;
        $user_id = apply_filters( 'determine_current_user', false );
        wp_set_current_user( $user_id );

        $result = array(
            'result'    => false,
            'msg'       => ''
        );

        if($data['number'][0] == '0'){
            $data['number'] = '62' . substr($data['number'], 1);
        }

        if($data['number'][0] == '+'){
            $data['number'] = substr($data['number'], 1);
        }

        $res = false;
        if ($data['id'] == 0) {
            $res = $wpdb->insert(
                'wafm_follow_up_number',
                array(
                    'created_at' => current_time('mysql', 8),
                    'created_by' => get_current_user_id(),
                    'name' => $data['name'],
                    'number' => $data['number']
                )
            );
        } else{
            $res = $wpdb->update(
                'wafm_follow_up_number',
                array(
                    'modified_at' => current_time('mysql', 8),
                    'modified_by' => get_current_user_id(),
                    'name' => $data['name'],
                    'number' => $data['number']
                ),
                array(
                    'id' => $data['id']
                )
            );
        }

        if (!$res) {
            $result['msg'] = 'Something wrong while saving your data.';
        } else{
            $result['result'] = true;
            $result['msg'] = 'Saved.';
        }

        return $result;
    }

    function edit( $id = 0 ) {
        global $wpdb;

        $result = array(
            'result'    => false,
            'msg'       => ''
        );

        $q = "SELECT * FROM `wafm_follow_up_number` WHERE `id` = '". $id ."' AND `deleted_at` IS NULL;";
        $r = $wpdb->get_results( $q );
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r[0];
        } else{
            $result['msg'] = 'Nothing found.';
        }

        return $result;
    }

    function delete( $data = array() ) {
        global $wpdb;
        $user_id = apply_filters( 'determine_current_user', false );
        wp_set_current_user( $user_id );

        $result = array(
            'result'    => false,
            'msg'       => ''
        );

        $res = $wpdb->update(
            'wafm_follow_up_number',
            array(
                'deleted_at' => current_time('mysql', 8),
                'deleted_by' => get_current_user_id()
            ),
            array(
                'id' => $data['id']
            )
        );

        if (!$res) {
            $result['msg'] = 'Something wrong while deleting your data.';
        } else{
            $result['result'] = true;
            $result['msg'] = 'Deleted.';
        }

        return $result;
    }

    function select( $id = 0 ) {
        global $wpdb;

        $result = array(
            'result'    => false,
            'msg'       => ''
        );

        $q = '';
        if ($id == 0) {
        	$q = "SELECT * FROM `wafm_follow_up_number` WHERE `deleted_at` IS NULL;";
        } else{
        	$q = "SELECT * FROM `wafm_follow_up_number` WHERE `id` = '". $id ."' AND `deleted_at` IS NULL;";
        }
        
        $r = $wpdb->get_results( $q );
        if (count($r) > 0) {
            $result['result'] = true;
            $result['data'] = $r;
        } else{
            $result['msg'] = 'Nothing found.';
        }

        return $result;
    }

    function send( $data = array() ) {
        global $wpdb;

        $result = array(
            'result'    => false,
            'msg'       => ''
        );

        $id = $data['id'];
        $msg = $data['message'];

        $q = "SELECT * FROM `wafm_follow_up_number` WHERE `id` = '". $id ."' AND `deleted_at` IS NULL;";
        $r = $wpdb->get_results( $q );
        if (count($r) > 0) {
            $result['result'] = true;
            $result['target'] = 'https://wa.me/'. $r[0]->number .'?text='. urlencode($msg);
        } else{
            $result['msg'] = 'Nothing found.';
        }

        return $result;
    }

    function clear( $data = array() ) {
        global $wpdb;
        $user_id = apply_filters( 'determine_current_user', false );
        wp_set_current_user( $user_id );

        $result = array(
            'result'    => false,
            'msg'       => ''
        );

        $delete = $wpdb->query("TRUNCATE TABLE `wafm_follow_up_number`;");

        if (!$delete) {
            $result['msg'] = 'Something wrong while deleting your data.';
        } else{
            $result['result'] = true;
            $result['msg'] = 'Deleted.';
        }

        return $result;
    }

}