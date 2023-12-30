<?php

namespace TinySolutions\qep\Controllers;

use TinySolutions\qep\Traits\SingletonTrait;
use TinySolutions\qep\Helpers\Fns;
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

	const PLUGIN_NAME = 'Cpt Boilerplate';

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

		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		if ( ! function_exists( 'wp_create_nonce' ) ) {
			require_once ABSPATH . 'wp-includes/pluggable.php';
		}

		// Check WooCommerce.
		$woocommerce = 'woocommerce/woocommerce.php';

		if ( ! is_plugin_active( $woocommerce ) ) {
			if ( $this->is_plugins_installed( $woocommerce ) ) {
				$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $woocommerce . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $woocommerce );
				$message        = sprintf(
					'<strong>%s</strong> %s <strong>%s</strong> %s',
					esc_html( self::PLUGIN_NAME ),
					esc_html__( 'requires', 'qep' ),
					esc_html__( 'WooCommerce', 'qep' ),
					esc_html__( 'plugin to be active. Please activate WooCommerce to continue.', 'qep' )
				);
				$button_text    = esc_html__( 'Activate WooCommerce', 'qep' );
			} else {
				$activation_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' );
				$message        = sprintf(
					'<strong>%s</strong> %s <strong>%s</strong> %s',
					esc_html( self::PLUGIN_NAME ),
					esc_html__( 'requires', 'qep' ),
					esc_html__( 'WooCommerce', 'qep' ),
					esc_html__( 'plugin to be installed and activated. Please install WooCommerce to continue.', 'qep' )
				);
				$button_text    = esc_html__( 'Install WooCommerce', 'qep' );
			}
			$this->missing['woocommerce'] = [
				'name'       => 'WooCommerce',
				'slug'       => 'woocommerce',
				'file_name'  => $woocommerce,
				'url'        => $activation_url,
				'message'    => $message,
				'button_txt' => $button_text,
			];
			if ( $this->is_plugins_installed( $woocommerce ) ) {
				unset( $this->missing['woocommerce']['slug'] );
			}
		}

		if ( ! empty( $this->missing ) ) {
			add_action( 'admin_notices', [ $this, 'missing_plugins_warning' ] );

			$this->allOk = false;
		}

		return $this->allOk;
	}

	/**
	 * Admin Notice For Required PHP Version
	 */
	public function minimum_php_version() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'qep' ),
			'<strong>' . esc_html__( 'Custom Post Type Woocommerce Integration', 'qep' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'qep' ) . '</strong>',
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
		$missingPlugins = '';
		$counter        = 0;
		foreach ( $this->missing as $plugin ) {
			$counter++;
			if ( count( $this->missing ) === $counter ) {
				$sep = '';
			} elseif ( count( $this->missing ) - 1 === $counter ) {
				$sep = ' ' . esc_html__( 'and', 'qep' ) . ' ';
			} else {
				$sep = ', ';
			}
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
