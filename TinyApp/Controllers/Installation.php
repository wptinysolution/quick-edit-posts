<?php

namespace TinySolutions\pqe\Controllers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
/**
 * Installation
 */
class Installation {
	/**
	 * Activate
	 *
	 * @return void
	 */
	public static function activate() {
		if ( ! get_option( 'tinysolutions_pqe_plugin_version' ) ) {
			$get_activation_time = strtotime( 'now' );
			update_option( 'tinysolutions_pqe_plugin_version', TSPQE_VERSION );
			update_option( 'tinysolutions_pqe_plugin_activation_time', $get_activation_time );
		}
	}

	/**
	 * Deactivation.
	 *
	 * @return void
	 */
	public static function deactivation() { }
}
