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
		*/
		add_filter( 'admin_body_class', [ __CLASS__, 'custom_class' ] );
		add_action( 'get_edit_post_link', [ __CLASS__, 'redirect_after_edit_product' ], 20 );

		$options = Fns::get_options();
		if ( ! empty( $options['selected_post_types'] ) && count( $options['selected_post_types'] ) ) {
			foreach ( $options['selected_post_types'] as $item ) {
				if ( 'attachment' === $item ) {
					add_action( 'manage_media_columns', [ __CLASS__, 'custom_list_columns' ], 10, 2 );
				} else {
					add_filter( 'manage_edit-' . $item . '_columns', [ __CLASS__,  'custom_list_columns' ] );
				}
			}
		}
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
			$classes .= ' pqe-window-opened opacity-0';
		}
		return $classes;
	}
	/**
	 * Column Button.
	 *
	 * @param array $columns column name.
	 * @return mixed
	 */
	public static function custom_list_columns( $columns ) {
		$title_position  = array_search( 'title', array_keys( $columns ), true );
		$button_position = 3;
		if ( $title_position ) {
			$button_position = $title_position + 1;
		}
		return array_merge(
			array_slice( $columns, 0, $button_position ),
			[
				'qe_column' => esc_html__( 'Quick Edit', 'quick-edit-post' ),
			],
			array_slice( $columns, $button_position )
		);
	}
	/**
	 * @param array $links default plugin action link.
	 *
	 * @return array [array] plugin action link
	 */
	/**
		//public static function plugins_setting_links( $links ) {
		//	$links['mediaedit_settings'] = '<a href="' . admin_url( 'admin.php?page=pqe-admin' ) . '">' . esc_html__( 'Start Editing', 'quick-edit-post' ) . '</a>';
		//	//if ( ! Fns::is_plugins_installed( 'media-library-tools-pro/media-library-tools-pro.php' ) ) {
		//	//	// $links['pqe_pro'] = sprintf( '<a href="#" target="_blank" style="color: #39b54a; font-weight: bold;">' . esc_html__( 'Go Pro', 'wp-media' ) . '</a>' );
		//	//}
		//	return $links;
		//}
	 **/
	
}
