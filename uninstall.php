<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

delete_option( 'wafm_db_version' );

global $wpdb;
$wpdb->query( "DROP TABLE IF EXISTS `wafm_list`" );
$wpdb->query( "DROP TABLE IF EXISTS `wafm_number`" );