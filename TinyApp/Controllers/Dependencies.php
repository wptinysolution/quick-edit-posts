<?php

namespace TinySolutions\pqe\Controllers;

use TinySolutions\pqe\Traits\SingletonTrait;
use TinySolutions\pqe\Helpers\Fns;
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Dependencies
 */
class Dependencies {
	/**
	 * Singleton
	 */
	use SingletonTrait;

	const PLUGIN_NAME = 'Quick Edit Post';

	const MINIMUM_PHP_VERSION = '7.4';
	/**
	 *  Error.
	 *
	 * @var array
	 */
	private $missing = [];
	/**
	 * @var bool
	 */
	private $allOk = true;

	/**
	 * @return bool
	 */
	public function check() {
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'minimum_php_version' ] );
			$this->allOk = false;
		}

        //    if ( ! function_exists( 'is_plugin_active' ) ) {
        //        include_once ABSPATH . 'wp-admin/includes/plugin.php';
        //    }
        //    if ( ! function_exists( 'wp_create_nonce' ) ) {
        //        require_once ABSPATH . 'wp-includes/pluggable.php';
        //    }
        //
        //    if ( ! empty( $this->missing ) ) {
        //        add_action( 'admin_notices', [ $this, 'missing_plugins_warning' ] );
        //        $this->allOk = false;
        //    }
		return $this->allOk;
	}

	/**
	 * Admin Notice For Required PHP Version
	 */
	public function minimum_php_version() {
		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'quick-edit-post' ),
			'<strong>' . esc_html__( 'Custom Post Type Woocommerce Integration', 'quick-edit-post' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'quick-edit-post' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);
		?>
		<div class="notice notice-warning is-dismissible">
			<p>
				<?php echo wp_kses_post( $message ); ?>
			</p>
		</div>
		<?php
	}

	/**
	 * Adds admin notice.
	 */
	public function missing_plugins_warning() {
		foreach ( $this->missing as $plugin ) {
			?>
			<div class="cptwint-wrapper error notice_error">
				<p>
					<?php echo wp_kses_post( $plugin['message'] ); ?>
				</p>
			</div>
			<?php
		}
	}

	/**
	 * Check plugin installed or not.
	 *
	 * @param string $plugin_file_path path.
	 *
	 * @return bool
	 */
	public function is_plugins_installed( $plugin_file_path = null ) {
		$installed_plugins_list = get_plugins();

		return isset( $installed_plugins_list[ $plugin_file_path ] );
	}

}
