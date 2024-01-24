<?php
/**
 * Main initialization class.
 *
 * @package TinySolutions\pqe
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
require_once TSPQE_PATH . 'vendor/autoload.php';

use TinySolutions\pqe\Traits\SingletonTrait;
use TinySolutions\pqe\Controllers\Installation;
use TinySolutions\pqe\Controllers\Dependencies;
use TinySolutions\pqe\Controllers\AssetsController;
use TinySolutions\pqe\Controllers\Hooks\FilterHooks;
use TinySolutions\pqe\Controllers\Hooks\ActionHooks;
use TinySolutions\pqe\Controllers\Admin\AdminMenu;
use TinySolutions\pqe\Controllers\Admin\Api;

if ( ! class_exists( Tinysolutions_PQE::class ) ) {
	/**
	 * Main initialization class.
	 */
	final class Tinysolutions_PQE {

		/**
		 * Nonce id
		 *
		 * @var string
		 */
		public $nonceId = 'tinysolutions_pqe_wpnonce';
		/**
		 * Singleton
		 */
		use SingletonTrait;

		/**
		 * Class Constructor
		 */
		private function __construct() {
			add_action( 'init', [ $this, 'language' ] );
			add_action( 'plugins_loaded', [ $this, 'init' ], 100 );
			// Register Plugin Active Hook.
			register_activation_hook( TSPQE_FILE, [ Installation::class, 'activate' ] );
			// Register Plugin Deactivate Hook.
			register_deactivation_hook( TSPQE_FILE, [ Installation::class, 'deactivation' ] );
		}

		/**
		 * Assets url generate with given assets file
		 *
		 * @param string $file File.
		 *
		 * @return string
		 */
		public function get_assets_uri( $file ) {
			$file = ltrim( $file, '/' );
			return trailingslashit( TSPQE_URL . '/assets' ) . $file;
		}

		/**
		 * Get the template path.
		 *
		 * @return string
		 */
		public function get_template_path() {
			return apply_filters( 'tinysolutions_pqe_template_path', 'templates/' );
		}

		/**
		 * Get the plugin path.
		 *
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( TSPQE_FILE ) );
		}

		/**
		 * Load Text Domain
		 */
		public function language() {
			load_plugin_textdomain( 'quick-edit-post', false, TSPQE_ABSPATH . '/languages/' );
		}

		/**
		 * Init
		 *
		 * @return void
		 */
		public function init() {
			if ( ! Dependencies::instance()->check() ) {
				return;
			}

			do_action( 'tinysolutions_pqe/before_loaded' );

			// Include File.
			AssetsController::instance();
			AdminMenu::instance();
			FilterHooks::init_hooks();
			ActionHooks::init_hooks();
			Api::instance();

			do_action( 'tinysolutions_pqe/after_loaded' );
		}

		/**
		 * If Need External Addons.
		 *
		 * @return string
		 */
		public function pro_version_link() {
			return '#';
		}
	}

	/**
	 * @return Tinysolutions_PQE
	 */
	function tinysolutions_pqe() {
		return Tinysolutions_PQE::instance();
	}

	tinysolutions_pqe();
}
