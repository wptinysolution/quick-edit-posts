<?php

namespace TinySolutions\pqe\Controllers;

use TinySolutions\pqe\Helpers\Fns;
use TinySolutions\pqe\Traits\SingletonTrait;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * AssetsController
 */
class AssetsController {

	/**
	 * Singleton
	 */
	use SingletonTrait;

	/**
	 * Plugin version
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Ajax URL
	 *
	 * @var string
	 */
	private $ajaxurl;

	/**
	 * Class Constructor
	 */
	public function __construct() {
		$this->version = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? time() : PQE_VERSION;
		/**
		 * Admin scripts.
		 */
		add_action( 'admin_enqueue_scripts', [ $this, 'backend_assets' ], 1 );
	}


	/**
	 * Registers Admin scripts.
	 *
	 * @return void
	 */
	public function backend_assets() {
		// Check if we are on the WooCommerce product list table page.
		global $pagenow;
		$scripts = [
			[
				'handle' => 'pqe-settings',
				'src'    => pqe()->get_assets_uri( 'js/backend/admin-settings.js' ),
				'deps'   => [],
				'footer' => true,
			],
			[
				'handle' => 'qe-app',
				'src'    => pqe()->get_assets_uri( 'js/backend/qe-app.js' ),
				'deps'   => [ 'jquery' ],
				'footer' => true,
			],
		];

		$styles = [
			[
				'handle' => 'qe-app',
				'src'    => pqe()->get_assets_uri( 'css/backend/qe-app.css' ),
			],
		];

		// Register public scripts.
		foreach ( $scripts as $script ) {
			wp_register_script( $script['handle'], $script['src'], $script['deps'], $this->version, $script['footer'] );
		}

		// Register public styles.
		foreach ( $styles as $style ) {
			wp_register_style( $style['handle'], $style['src'], '', $this->version );
		}

		$options   = Fns::get_options();
		$post_type = sanitize_text_field( wp_unslash( $_GET['post_type'] ?? '' ) );
		if ( ! $post_type ) {
			$post_type = get_post_type( absint( $_GET['post'] ?? 0 ) );
		}

		$types = [];
		if ( ! empty( $options['selected_post_types'] ) && count( $options['selected_post_types'] ) ) {
			$types = $options['selected_post_types'];
		}
		if ( 'edit.php' === $pagenow && in_array( $post_type, $types, true ) ) {
			// Enqueue the script only on the WooCommerce product list table page.
			wp_enqueue_style( 'qe-app' );
			wp_enqueue_script( 'qe-app' );
		}
		$current_screen = get_current_screen();
		if ( isset( $current_screen->id ) && 'toplevel_page_pqe-admin' === $current_screen->id ) {
			wp_enqueue_style( 'pqe-settings' );
			wp_enqueue_script( 'pqe-settings' );
			wp_localize_script(
				'pqe-settings',
				'pqeParams',
				[
					'ajaxUrl'      => esc_url( admin_url( 'admin-ajax.php' ) ),
					'adminUrl'     => esc_url( admin_url() ),
					'restApiUrl'   => esc_url_raw( rest_url() ),
					'rest_nonce'   => wp_create_nonce( 'wp_rest' ),
					pqe()->nonceId => wp_create_nonce( pqe()->nonceId ),
				]
			);

		}
	}
}
