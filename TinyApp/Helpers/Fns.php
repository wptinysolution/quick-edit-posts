<?php
/**
 * Fns Helpers class
 *
 * @package  TinySolutions\pqe
 */

namespace TinySolutions\pqe\Helpers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Fns class
 */
class Fns {
	/**
	 * @var array
	 */
	private static $cache = [];

	/**
	 *  Verify nonce.
	 *
	 * @return bool
	 */
	public static function verify_nonce() {
		$nonce = isset( $_REQUEST[ pqe()->nonceId ] ) ? sanitize_text_field( wp_unslash( $_REQUEST[ pqe()->nonceId ] ) ) : null;
		if ( wp_verify_nonce( $nonce, pqe()->nonceId ) ) {
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
		$cache_key = 'pqe_get_options';
		if ( isset( self::$cache[ $cache_key ] ) ) {
			return self::$cache[ $cache_key ];
		}
		$defaults                  = [];
		$options                   = get_option( 'pqe_settings' );
		$potions                   = wp_parse_args( $options, $defaults );
		self::$cache[ $cache_key ] = $potions;
		return $potions;
	}

	/**
	 * Get Options.
	 *
	 * @return array
	 */
	public static function support_list() {
		// Get all meta keys saved in posts of the specified post type.
		$post_type_array = [
			[
				'value' => 'post',
				'label' => 'Posts',
			],
			[
				'value' => 'page',
				'label' => 'Page',
			],
			[
				'value' => 'attachment',
				'label' => 'Media/Attachment',
			],
		];
		$cpt_args        = [
			'public'   => true,
			'_builtin' => false,
		];
		$post_types      = get_post_types( $cpt_args, 'objects' );
		foreach ( $post_types as $key => $post_type ) {
			$posts_item        = [
				'value' => $post_type->name,
				'label' => $post_type->label,
			];
			$post_type_array[] = $posts_item;
		}
		return apply_filters( 'pqe_get_post_types', $post_type_array );
	}
	/**
	 * Get Options.
	 *
	 * @return array
	 */
	public static function free_list() {
		return [
			'post',
			'page',
			'book',
			'product',
			'lp_course',
			'attachment',
			'rtsb_builder',
			'e-landing-page',
			'elementor_library',
		];
	}
}
