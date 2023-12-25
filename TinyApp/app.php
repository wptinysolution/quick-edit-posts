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
require_once PQE_PATH . 'vendor/autoload.php';

use TinySolutions\pqe\Traits\SingletonTrait;
use TinySolutions\pqe\Controllers\Installation;
use TinySolutions\pqe\Controllers\Dependencies;
use TinySolutions\pqe\Controllers\AssetsController;
use TinySolutions\pqe\Controllers\Hooks\FilterHooks;
use TinySolutions\pqe\Controllers\Hooks\ActionHooks;
use TinySolutions\pqe\Controllers\Admin\AdminMenu;
use TinySolutions\pqe\Controllers\Admin\Api;

if ( ! class_exists( PQE::class ) ) {
	/**
	 * Main initialization class.
	 */
	final class PQE {

		/**
		 * Nonce id
		 *
		 * @var string
		 */
		public $nonceId = 'pqe_wpnonce';
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
			register_activation_hook( PQE_FILE, [ Installation::class, 'activate' ] );
			// Register Plugin Deactivate Hook.
			register_deactivation_hook( PQE_FILE, [ Installation::class, 'deactivation' ] );
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
			return trailingslashit( PQE_URL . '/assets' ) . $file;
		}

		/**
		 * Get the template path.
		 *
		 * @return string
		 */
		public function get_template_path() {
			return apply_filters( 'pqe_template_path', 'templates/' );
		}

		/**
		 * Get the plugin path.
		 *
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( PQE_FILE ) );
		}

		/**
		 * Load Text Domain
		 */
		public function language() {
			load_plugin_textdomain( 'pqe', false, PQE_ABSPATH . '/languages/' );
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

			do_action( 'pqe/before_loaded' );

			// Include File.
			AssetsController::instance();
			AdminMenu::instance();
			FilterHooks::init_hooks();
			ActionHooks::init_hooks();
			Api::instance();

			do_action( 'pqe/after_loaded' );
		}

		/**
		 * Checks if Pro version installed
		 *
		 * @return boolean
		 */
		public function has_pro() {
			return function_exists( 'pqep' );
		}

		/**
		 * PRO Version URL.
		 *
		 * @return string
		 */
		public function pro_version_link() {
			return '#';
		}
	}

	/**
	 * @return Cptint
	 */
	function pqe() {
		return PQE::instance();
	}

	pqe();
}
