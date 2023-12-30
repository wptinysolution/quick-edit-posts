<?php
/**
 * Main FilterHooks class.
 *
 * @package TinySolutions\WM
 */

namespace TinySolutions\qep\Controllers\Hooks;

use TinySolutions\qep\Helpers\Fns;

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
		// add_filter( 'plugin_action_links_' . QEP_BASENAME, [ __CLASS__, 'plugins_setting_links' ] );
		*/
		add_filter( 'plugin_row_meta', [ __CLASS__, 'plugin_row_meta' ], 10, 2 );
		add_filter( 'manage_edit-product_columns', [ __CLASS__,  'custom_product_list_columns' ] );
		add_filter( 'admin_body_class', [ __CLASS__, 'custom_class' ], 99 );
		add_action( 'get_edit_post_link', [ __CLASS__, 'redirect_after_edit_product' ], 20 );
	}

	/**
	 * Redirect after edit
	 *
	 * @param string $link url.
	 * @return mixed|string
	 */
	public static function redirect_after_edit_product( $link ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		$is_product = ! empty( $_POST['_wp_http_referer'] ) && 'product' === sanitize_text_field( wp_unslash( $_POST['post_type'] ?? '' ) );
		if ( ! $is_product ) {
			return $link;
		}
		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		$parametersArray = explode( '&', sanitize_text_field( wp_unslash( $_POST['_wp_http_referer'] ) ) );
		// Initialize a variable to store the window value.
		$windowValue = null;
		// Iterate through the array to find the "window" parameter.
		foreach ( $parametersArray as $parameter ) {
			// Split each parameter into key and value using "=" as the delimiter.
			list($key, $value) = explode( '=', $parameter );
			// Check if the current key is "window".
			if ( 'window' === $key ) {
				$windowValue = $value;
				break; // Stop iterating once the "window" parameter is found.
			}
		}
		if ( $windowValue ) {
			$link .= '&window=open_window';
		}
		return $link;
	}
	/**
	 * Body class.
	 *
	 * @param string $classes class.
	 * @return mixed|string
	 */
	public static function custom_class( $classes ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( 'open_window' === sanitize_text_field( wp_unslash( $_GET['window'] ?? '' ) ) ) {
			$classes .= ' qep-window-opened opacity-0';
		}
		return $classes;
	}
	/**
	 * Column Button.
	 *
	 * @param array $columns column name.
	 * @return mixed
	 */
	public static function custom_product_list_columns( $columns ) {
		// Find the position of the 'sku' column.
		$sku_position = array_search( 'sku', array_keys( $columns ), true );
		// Insert the new column after 'sku'.
		return array_merge(
			array_slice( $columns, 0, $sku_position ),
			[
				'qe_column' => esc_html__( 'Edit', 'qep' ),
			],
			array_slice( $columns, $sku_position )
		);
	}
	/**
	 * @param array $links default plugin action link.
	 *
	 * @return array [array] plugin action link
	 */
	/**
		//public static function plugins_setting_links( $links ) {
		//	$links['mediaedit_settings'] = '<a href="' . admin_url( 'admin.php?page=qep-admin' ) . '">' . esc_html__( 'Start Editing', 'qep' ) . '</a>';
		//	//if ( ! Fns::is_plugins_installed( 'media-library-tools-pro/media-library-tools-pro.php' ) ) {
		//	//	// $links['qep_pro'] = sprintf( '<a href="#" target="_blank" style="color: #39b54a; font-weight: bold;">' . esc_html__( 'Go Pro', 'wp-media' ) . '</a>' );
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
		if ( QEP_BASENAME === $file ) {
			$report_url         = 'https://www.wptinysolutions.com/contact';
			$row_meta['issues'] = sprintf( '%2$s <a target="_blank" href="%1$s">%3$s</a>', esc_url( $report_url ), esc_html__( 'Facing issue?', 'qep' ), '<span style="color: red">' . esc_html__( 'Please open a support ticket.', 'qep' ) . '</span>' );
			return array_merge( $links, $row_meta );
		}
		return (array) $links;
	}
}
