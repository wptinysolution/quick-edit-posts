<?php
/**
 * Main initialization class.
 *
 * @package TinySolutions\qep
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
require_once QEP_PATH . 'vendor/autoload.php';

use TinySolutions\qep\Traits\SingletonTrait;
use TinySolutions\qep\Controllers\Installation;
use TinySolutions\qep\Controllers\Dependencies;
use TinySolutions\qep\Controllers\AssetsController;
use TinySolutions\qep\Controllers\Hooks\FilterHooks;
use TinySolutions\qep\Controllers\Hooks\ActionHooks;
use TinySolutions\qep\Controllers\Admin\AdminMenu;
use TinySolutions\qep\Controllers\Admin\Api;

if ( ! class_exists( QEP::class ) ) {
	/**
	 * Main initialization class.
	 */
	final class QEP {

		/**
		 * Nonce id
		 *
		 * @var string
		 */
		public $nonceId = 'qep_wpnonce';
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
			register_activation_hook( QEP_FILE, [ Installation::class, 'activate' ] );
			// Register Plugin Deactivate Hook.
			register_deactivation_hook( QEP_FILE, [ Installation::class, 'deactivation' ] );
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
			return trailingslashit( QEP_URL . '/assets' ) . $file;
		}

		/**
		 * Get the template path.
		 *
		 * @return string
		 */
		public function get_template_path() {
			return apply_filters( 'qep_template_path', 'templates/' );
		}

		/**
		 * Get the plugin path.
		 *
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( QEP_FILE ) );
		}

		/**
		 * Load Text Domain
		 */
		public function language() {
			load_plugin_textdomain( 'qep', false, QEP_ABSPATH . '/languages/' );
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

			do_action( 'qep/before_loaded' );

			// Include File.
			AssetsController::instance();
			AdminMenu::instance();
			FilterHooks::init_hooks();
			ActionHooks::init_hooks();
			Api::instance();

			do_action( 'qep/after_loaded' );
		}

		/**
		 * Checks if Pro version installed
		 *
		 * @return boolean
		 */
		public function has_pro() {
			return function_exists( 'qepp' );
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
	 * @return QEP
	 */
	function qep() {
		return QEP::instance();
	}

	qep();
}
