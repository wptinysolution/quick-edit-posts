<?php
/**
 * Fns Helpers class
 *
 * @package  TinySolutions\qep
 */

namespace TinySolutions\qep\Helpers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Fns class
 */
class Fns {

	/**
	 *  Verify nonce.
	 *
	 * @return bool
	 */
	public static function verify_nonce() {
		$nonce = isset( $_REQUEST[ qep()->nonceId ] ) ? sanitize_text_field( wp_unslash( $_REQUEST[ qep()->nonceId ] ) ) : null;
		if ( wp_verify_nonce( $nonce, qep()->nonceId ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Check is plugin instilled.
	 *
	 * @param string $plugin_file_path Is plugins Installed.
	 *
	 * @return bool
	 */
	public static function is_plugins_installed( $plugin_file_path = null ) {
		$installed_plugins_list = get_plugins();

		return isset( $installed_plugins_list[ $plugin_file_path ] );
	}


	/**
	 * Get Options.
	 *
	 * @return array
	 */
	public static function get_options() {
		$defaults = [];
		$options  = get_option( 'qep_settings' );
		return wp_parse_args( $options, $defaults );
	}
}
