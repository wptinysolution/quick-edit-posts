<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Quick Edit Post
 * Plugin URI:        https://wordpress.org/plugin/quick-edit-post
 * Description:       Quick Edit Post
 * Version:           0.0.1
 * Author:            Tiny Solutions
 * Author URI:        https://www.wptinysolutions.com/
 * Text Domain:       quick-edit-post
 * Domain Path:       /languages
 *
 * @package TinySolutions\PQE
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Define media edit Constant.
 */
define( 'PQE_VERSION', '0.0.1' );

define( 'PQE_FILE', __FILE__ );

define( 'PQE_BASENAME', plugin_basename( PQE_FILE ) );

define( 'PQE_URL', plugins_url( '', PQE_FILE ) );

define( 'PQE_ABSPATH', dirname( PQE_FILE ) );

define( 'PQE_PATH', plugin_dir_path( __FILE__ ) );

/**
 * App Init.
 */
require_once 'TinyApp/app.php';


