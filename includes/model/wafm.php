<?php

class WafmClass {

    function get_fields( $message = '' ) {
        $find = true;
        $fields = array();

        while ($find) {
            $ipos = stripos($message, "{{");
            $rpos = stripos($message, "}}");
            if($ipos === false or $rpos === false) {
                $find = false;
            } else{
                $name = substr($message, $ipos + 3, $rpos - $ipos - 4);
                $iipos = stripos($name, ":");
                $iiipos = stripos($name, "|");
                $a = substr($name, $iiipos + 1, $iipos - $iiipos - 2);
                array_push( 
                    $fields, 
                    array(
                        'strtoreplace' => substr($message, $ipos, $rpos - $ipos + 2),
                        'name' => $a
                    )
                );
                $message = substr($message, $rpos + 3);
            }
        }
        
        return $fields;
    }

    function get_options( $message = '' ) {
        $find = true;
        $options = array();

        while ($find) {
            $ipos = stripos($message, "[[");
            $rpos = stripos($message, "]]");
            if($ipos === false or $rpos === false) {
                $find = false;
            } else{
                $name = substr($message, $ipos + 3, $rpos - $ipos - 4);
                $iipos = stripos($name, ":");
                $iiipos = stripos($name, "|");
                $a = substr($name, $iiipos + 1, $iipos - $iiipos - 2);
                array_push( 
                    $options, 
                    array(
                        'strtoreplace' => substr($message, $ipos, $rpos - $ipos + 2),
                        'name' => $a
                    )
                );
                $message = substr($message, $rpos + 3);
            }
        }

        return $options;
    }

    function send( $data = array() ) {
        global $wpdb;
        $result = array(
            'result'    => false,
            'msg'       => ''
        );

        $id = $data['id'];
        parse_str($data['form'], $form);

        $q =    "SELECT 
                    a.`message`,
                    b.`number`,
                    a.`group_link`
                FROM 
                    `wafm_list` a
                LEFT JOIN
                    `wafm_number` b
                        ON
                    a.`id_number` = b.`id`
                WHERE 
                    a.`id` = '". $id ."' 
                        AND 
                    a.`deleted_at` IS NULL;";
        $r = $wpdb->get_results( $q );
        $a = '';
        $f = '';
        $v = '';
        if (count($r) > 0) {
            $result['result'] = true;
            $msg = $r[0]->message;
            $number = $r[0]->number;
            $fields = $this->get_fields( $msg );
            $options = $this->get_options( $msg );
            for ($i=0; $i < count($fields); $i++) { 
                foreach ($form as $key => $value) {
                    if (strpos($fields[$i]['name'], $key) !== false) {
                        if (strlen($fields[$i]['name']) == strlen($key)) {
                            $f .= $fields[$i]['name'] . ',';
                            $v .= empty( $value ) ? $fields[$i]['name'] : $value . ',';
                            $msg = str_replace($fields[$i]['strtoreplace'], empty( $value ) ? $fields[$i]['name'] : $value, $msg);
                        }
                    }
                }
            }
            for ($i=0; $i < count($options); $i++) { 
                foreach ($form as $key => $value) {
                    if (strpos($options[$i]['name'], $key) !== false) {
                        if (strlen($options[$i]['name']) == strlen($key)) {
                            $f .= $fields[$i]['name'] . ',';
                            $v .= empty( $value ) ? $fields[$i]['name'] : $value . ',';
                            $msg = str_replace($options[$i]['strtoreplace'], empty( $value ) ? $options[$i]['name'] : $value, $msg);
                        }
                    }
                }
            }
            $result['target'] = 'https://wa.me/'. $number .'?text='. urlencode($msg);
            $result['group_link'] = $r[0]->group_link;
        } else{
            $result['msg'] = 'Nothing found.';
        }

        if (count($r) > 0) {
            $res = $wpdb->insert(
                'wafm_list_detail',
                array(
                    'created_at' => current_time('mysql', 8),
                    'wafm_list_id' => $id,
                    'field' => rtrim($f, ','),
                    'value' => rtrim($v, ',')
                )
            );
        }

        return $result;
    }

}