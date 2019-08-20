<?php
/**
 * Plugin Name: WA Form Maker
 * Plugin URI:  https://waformmaker.com/
 * Description: Just help you to build some form and sent it as WA message.
 * Version:     1.0.1
 * Author:      Sandi Mulyadi & Ady Sheva
 * Author URI:  https://sandimulyadi.com/
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wa-form-maker
 * Domain Path: /languages

 WA Form Maker is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 2 of the License, or
 any later version.

 WA Form Maker is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.
 
 You should have received a copy of the GNU General Public License
 along with WA Form Maker. If not, see https://waformmaker.com/license/.
 */

define( 'WAFM_VERSION', '1.0.1' );
define( 'WAFM_REQUIRED_WP_VERSION', '4.9' );
define( 'WAFM_PLUGIN', __FILE__ );
define( 'WAFM_PLUGIN_BASENAME', plugin_basename( WAFM_PLUGIN ) );
define( 'WAFM_PLUGIN_NAME', trim( dirname( WAFM_PLUGIN_BASENAME ), '/' ) );
define( 'WAFM_PLUGIN_DIR', untrailingslashit( dirname( WAFM_PLUGIN ) ) );

require_once WAFM_PLUGIN_DIR . '/includes/menu.php';
require_once WAFM_PLUGIN_DIR . '/includes/css_js.php';
require_once WAFM_PLUGIN_DIR . '/includes/screen_handler.php';
require_once WAFM_PLUGIN_DIR . '/includes/routes.php';
require_once WAFM_PLUGIN_DIR . '/includes/shortcode_handler.php';

function create_table() {
	$wafm_list =	"CREATE TABLE `wafm_list` (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`created_at` datetime DEFAULT NULL,
						`modified_at` datetime DEFAULT NULL,
						`deleted_at` datetime DEFAULT NULL,
						`created_by` int(11) DEFAULT NULL,
						`modified_by` int(11) DEFAULT NULL,
						`deleted_by` int(11) DEFAULT NULL,
						`name` text NOT NULL,
						`group_link` text NULL,
						`id_number` int(11) NOT NULL DEFAULT '0',
						`message` text,
						`shortcode` text,
						`button_name` varchar(16) NOT NULL DEFAULT 'OPEN',
						`button_send` varchar(16) NOT NULL DEFAULT 'SEND',
						PRIMARY KEY (`id`)
					);";

	$wafm_list_detail = 	"CREATE TABLE `wafm_list_detail` (
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  `created_at` datetime DEFAULT NULL,
							  `deleted_at` datetime DEFAULT NULL,
							  `wafm_list_id` int(11) NOT NULL,
							  `field` text NOT NULL,
							  `value` text NOT NULL,
							  PRIMARY KEY (`id`)
							)";

	$wafm_number =	"CREATE TABLE `wafm_number` (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`created_at` datetime DEFAULT NULL,
						`modified_at` datetime DEFAULT NULL,
						`deleted_at` datetime DEFAULT NULL,
						`created_by` int(11) DEFAULT NULL,
						`modified_by` int(11) DEFAULT NULL,
						`deleted_by` int(11) DEFAULT NULL,
						`name` text NOT NULL,
						`number` text NOT NULL,
						`picture` text,
						PRIMARY KEY (`id`)
					);";

	$wafm_follow_up_number =	"CREATE TABLE `wafm_follow_up_number` (
									`id` int(11) NOT NULL AUTO_INCREMENT,
									`created_at` datetime DEFAULT NULL,
									`modified_at` datetime DEFAULT NULL,
									`deleted_at` datetime DEFAULT NULL,
									`created_by` int(11) DEFAULT NULL,
									`modified_by` int(11) DEFAULT NULL,
									`deleted_by` int(11) DEFAULT NULL,
									`name` text NOT NULL,
									`number` text NOT NULL,
									PRIMARY KEY (`id`)
								);";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $wafm_list );
	dbDelta( $wafm_list_detail );
	dbDelta( $wafm_number );
	dbDelta( $wafm_follow_up_number );
}

function pluginprefix_activation() {
	$wafm_db_version = '1.0.1';
	$wafm_db_current_version = get_option( 'wafm_db_version' );

	if ($wafm_db_version != $wafm_db_current_version) {
		create_table();

		add_option( 'wafm_db_version', $wafm_db_version );
		update_option( 'wafm_db_version', $wafm_db_version );
	}

	add_option('wafm_facebook_pixel_view_content', 'no');
	add_option('wafm_facebook_pixel_add_to_cart', 'no');
	add_option('wafm_facebook_pixel_initiate_checkout', 'no');
	add_option('wafm_facebook_pixel_purchase', 'no');

	add_option('wafm_license_email', 'email@domain.com');
	add_option('wafm_license_key', 'yourkey');

	add_option('wafm_rotate_id', 1);
}

register_activation_hook( __FILE__, 'pluginprefix_activation' );