<?php

namespace TinySolutions\pqe\Controllers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

class Installation {
	/**
	 * @return void
	 */
	public static function activate() {
		if ( ! get_option( 'pqe_plugin_version' ) ) {
			$options             = get_option( 'pqe_settings', [] );
			$get_activation_time = strtotime( 'now' );

			update_option( 'pqe_settings', $options );
			update_option( 'pqe_plugin_version', PQE_VERSION );
			update_option( 'pqe_plugin_activation_time', $get_activation_time );
		}
	}

	/**
	 * @return void
	 */
	public static function deactivation() { }
}
