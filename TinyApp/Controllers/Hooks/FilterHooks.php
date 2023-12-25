<?php
/**
 * Main FilterHooks class.
 *
 * @package TinySolutions\WM
 */

namespace TinySolutions\pqe\Controllers\Hooks;

use TinySolutions\pqe\Helpers\Fns;

defined( 'ABSPATH' ) || exit();

/**
 * Main FilterHooks class.
 */
class FilterHooks {
	/**
	 * Init Hooks.
	 *
	 * @return void
	 */
	public static function init_hooks() {
		/*
		// Plugins Setting Page.
		// add_filter( 'plugin_action_links_' . PQE_BASENAME, [ __CLASS__, 'plugins_setting_links' ] );
		*/
		add_filter( 'plugin_row_meta', [ __CLASS__, 'plugin_row_meta' ], 10, 2 );
	}

	/**
	 * @param array $links default plugin action link.
	 *
	 * @return array [array] plugin action link
	 */
	/**
		//public static function plugins_setting_links( $links ) {
		//	$links['mediaedit_settings'] = '<a href="' . admin_url( 'admin.php?page=pqe-admin' ) . '">' . esc_html__( 'Start Editing', 'pqe' ) . '</a>';
		//	//if ( ! Fns::is_plugins_installed( 'media-library-tools-pro/media-library-tools-pro.php' ) ) {
		//	//	// $links['pqe_pro'] = sprintf( '<a href="#" target="_blank" style="color: #39b54a; font-weight: bold;">' . esc_html__( 'Go Pro', 'wp-media' ) . '</a>' );
		//	//}
		//	return $links;
		//}
	 **/
	/**
	 *
	 * @param string $links LINKS.
	 * @param string $file file path.
	 *
	 * @return array
	 */
	public static function plugin_row_meta( $links, $file ) {
		if ( PQE_BASENAME === $file ) {
			$report_url         = 'https://www.wptinysolutions.com/contact';
			$row_meta['issues'] = sprintf( '%2$s <a target="_blank" href="%1$s">%3$s</a>', esc_url( $report_url ), esc_html__( 'Facing issue?', 'tsmlt-media-tools' ), '<span style="color: red">' . esc_html__( 'Please open a support ticket.', 'tsmlt-media-tools' ) . '</span>' );
			return array_merge( $links, $row_meta );
		}
		return (array) $links;
	}
}
