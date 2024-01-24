<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Quick Edit Post
 * Plugin URI:        https://wordpress.org/plugin/quick-edit-posts
 * Description:       Quick Edit Post
 * Version:           0.0.2
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
define( 'TSPQE_VERSION', '0.0.2' );

define( 'TSPQE_FILE', __FILE__ );

define( 'TSPQE_BASENAME', plugin_basename( TSPQE_FILE ) );

define( 'TSPQE_URL', plugins_url( '', TSPQE_FILE ) );

define( 'TSPQE_ABSPATH', dirname( TSPQE_FILE ) );

define( 'TSPQE_PATH', plugin_dir_path( __FILE__ ) );

/**
 * App Init.
 */
require_once 'TinyApp/app.php';


