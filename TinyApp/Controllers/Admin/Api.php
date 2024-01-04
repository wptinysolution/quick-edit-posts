<?php

namespace TinySolutions\pqe\Controllers\Admin;

use TinySolutions\pqe\Helpers\Fns;
use TinySolutions\pqe\Traits\SingletonTrait;
use WP_Error;

class Api {

	/**
	 * Singleton
	 */
	use SingletonTrait;

	/**
	 * @var string
	 */
	private $namespacev1 = 'TinySolutions/pqe/v1';
	/**
	 * @var string
	 */
	private $resource_name = '/pqe';
	/**
	 * Construct
	 */
	private function __construct() {
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	/**
	 * Register our routes.
	 *
	 * @return void
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespacev1,
			$this->resource_name . '/getoptions',
			[
				'methods'             => 'GET',
				'callback'            => [ $this, 'get_options' ],
				'permission_callback' => [ $this, 'login_permission_callback' ],
			]
		);
		register_rest_route(
			$this->namespacev1,
			$this->resource_name . '/updateoptins',
			[
				'methods'             => 'POST',
				'callback'            => [ $this, 'update_option' ],
				'permission_callback' => [ $this, 'login_permission_callback' ],
			]
		);
		register_rest_route(
			$this->namespacev1,
			$this->resource_name . '/getPostTypes',
			[
				'methods'             => 'GET',
				'callback'            => [ $this, 'get_post_types' ],
				'permission_callback' => [ $this, 'login_permission_callback' ],
			]
		);
	}

	/**
	 * @return true
	 */
	public function login_permission_callback() {
		return current_user_can( 'manage_options' );
	}

	/**
	 * Update Options.
	 *
	 * @param object $request_data data.
	 * @return array
	 */
	public function update_option( $request_data ) {
		$result = [
			'updated' => false,
			'message' => esc_html__( 'Update failed. Maybe change not found. ', 'pqe-media-tools' ),
		];

		$parameters = $request_data->get_params();

		$the_settings = get_option( 'pqe_settings', [] );

		$the_settings['selected_post_types'] = ! empty( $parameters['selected_post_types'] ) ? $parameters['selected_post_types'] : [];

		$options = update_option( 'pqe_settings', $the_settings );

		$result['updated'] = boolval( $options );

		if ( $result['updated'] ) {
			$result['message'] = esc_html__( 'Updated.', 'pqe-media-tools' );
		}
		return $result;
	}

	/**
	 * @return false|string
	 */
	public function get_options() {
		return wp_json_encode( Fns::get_options() );
	}

	/**
	 * @return false|string
	 */
	public function get_post_types() {
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
			$post_type_array[] = [
				'value' => $post_type->name,
				'label' => $post_type->label,
			];
		}
		$post_type_array = apply_filters( 'pqe_get_post_types', $post_type_array );
		return wp_json_encode( $post_type_array );
	}
}
