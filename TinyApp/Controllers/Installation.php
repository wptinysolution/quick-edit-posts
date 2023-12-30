<?php

namespace TinySolutions\qep\Controllers;

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
		if ( ! get_option( 'qep_plugin_version' ) ) {
			$options             = get_option( 'qep_settings', [] );
			$get_activation_time = strtotime( 'now' );

			update_option( 'qep_settings', $options );
			update_option( 'qep_plugin_version', QEP_VERSION );
			update_option( 'qep_plugin_activation_time', $get_activation_time );
		}
	}

	/**
	 * Deactivation.
	 *
	 * @return void
	 */
	public static function deactivation() { }
}
