<?php
defined( 'ABSPATH' ) or die( '' ); // Prevents direct file access
/*
Plugin Name: ElexioPress
Description: System to connect Elexio data to WordPress
Version:     0.1
Author:      Brett Goodrich
Author URI:  brettgoodrich.com
*/

define( 'ElexioPress_Path', plugin_dir_path( __FILE__ ) );
$elexiopress_settings = get_option('elexiopress_keys');

include( ElexioPress_Path . 'elexiopress-admin.php' );
include( ElexioPress_Path . 'elexiopress-functions.php' );
?>
