<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Quick Edit Post
 * Plugin URI:        https://wordpress.org/plugin/product-quick-edit
 * Description:       Quick Edit Post
 * Version:           0.0.1
 * Author:            Tiny Solutions
 * Author URI:        https://www.wptinysolutions.com/
 * Text Domain:       qep
 * Domain Path:       /languages
 *
 * @package TinySolutions\QEP
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Define media edit Constant.
 */
define( 'QEP_VERSION', '0.0.1' );

define( 'QEP_FILE', __FILE__ );

define( 'QEP_BASENAME', plugin_basename( QEP_FILE ) );

define( 'QEP_URL', plugins_url( '', QEP_FILE ) );

define( 'QEP_ABSPATH', dirname( QEP_FILE ) );

define( 'QEP_PATH', plugin_dir_path( __FILE__ ) );

/**
 * App Init.
 */
require_once 'TinyApp/app.php';
