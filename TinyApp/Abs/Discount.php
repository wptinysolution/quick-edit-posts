<?php
/**
 * Special Offer.
 *
 * @package RadiusTheme\SB
 */

namespace TinySolutions\pqe\Abs;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Black Friday Offer.
 */
abstract class Discount {
	/**
	 * @var
	 */
	protected $options = [];

	/**
	 * Class Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_init', [ $this, 'show_notice' ] );
	}

	/**
	 * @return array
	 */
	abstract public function the_options(): array;

	/**
	 * @return void
	 */
	public function show_notice() {
		$defaults      = [
			'download_link'  => 'https://www.wptinysolutions.com/tiny-products/cpt-woo-integration/',
			'plugin_name'    => 'Custom Post Type Woocommerce Integration Pro',
			'image_url'      => cptwooint()->get_assets_uri( 'images/cpt-woo-icon-150x150.png' ),
			'option_name'    => '',
			'start_date'     => '',
			'end_date'       => '',
			'notice_for'     => 'Cyber Monday Deal!!',
			'notice_message' => ''
		];
		$options       = apply_filters( 'cptwooint_offer_notice', $this->the_options() );
		$this->options = wp_parse_args( $options, $defaults );
		$current = time();
		$start   = strtotime( $this->options['start_date'] );
		$end     = strtotime( $this->options['end_date'] );
		// Black Friday Notice
		if ( ! cptwooint()->has_pro() && $start <= $current && $current <= $end ) {
			if ( get_option( $this->options['option_name'] ) != '1' ) {
				if ( ! isset( $GLOBALS['cptwooint__notice'] ) ) {
					$GLOBALS['cptwooint__notice'] = 'cptwooint__notice';
					$this->offer_notice();
				}
			}
		}
	}

	/**
	 * Black Friday Notice.
	 *
	 * @return void
	 */
	private function offer_notice() {
		add_action(
			'admin_enqueue_scripts',
			function () {
				wp_enqueue_script( 'jquery' );
			}
		);

		add_action(
			'admin_notices',
			function () {
				?>
                <style>
                    .cptwooint-offer-notice {
                        --e-button-context-color: #2179c0;
                        --e-button-context-color-dark: #2271b1;
                        --e-button-context-tint: rgb(75 47 157/4%);
                        --e-focus-color: rgb(75 47 157/40%);
                        display: grid;
                        grid-template-columns: 100px auto;
                        padding-top: 25px;
                        padding-bottom: 22px;
                        column-gap: 15px;
                    }

                    .cptwooint-offer-notice img {
                        grid-row: 1 / 4;
                        align-self: center;
                        justify-self: center;
                    }

                    .cptwooint-offer-notice h3,
                    .cptwooint-offer-notice p {
                        margin: 0 !important;
                    }

                    .cptwooint-offer-notice .notice-text {
                        margin: 0 0 2px;
                        padding: 5px 0;
                        max-width: 100%;
                        font-size: 14px;
                    }

                    .cptwooint-offer-notice .button-primary,
                    .cptwooint-offer-notice .button-dismiss {
                        display: inline-block;
                        border: 0;
                        border-radius: 3px;
                        background: var(--e-button-context-color-dark);
                        color: #fff;
                        vertical-align: middle;
                        text-align: center;
                        text-decoration: none;
                        white-space: nowrap;
                        margin-right: 5px;
                        transition: all 0.3s;
                    }

                    .cptwooint-offer-notice .button-primary:hover,
                    .cptwooint-offer-notice .button-dismiss:hover {
                        background: var(--e-button-context-color);
                        border-color: var(--e-button-context-color);
                        color: #fff;
                    }

                    .cptwooint-offer-notice .button-primary:focus,
                    .cptwooint-offer-notice .button-dismiss:focus {
                        box-shadow: 0 0 0 1px #fff, 0 0 0 3px var(--e-button-context-color);
                        background: var(--e-button-context-color);
                        color: #fff;
                    }

                    .cptwooint-offer-notice .button-dismiss {
                        border: 1px solid;
                        background: 0 0;
                        color: var(--e-button-context-color);
                        background: #fff;
                    }
                </style>
                <div class="cptwooint-offer-notice notice notice-info is-dismissible"
                     data-cptwoointdismissable="cptwooint_offer">
                    <img alt="<?php echo esc_attr( $this->options['plugin_name'] ); ?>"
                         src="<?php echo esc_url( $this->options['image_url'] ); ?>"
                         width="100px"
                         height="100px"/>
                    <h3><?php echo sprintf( '%s – %s', esc_html( $this->options['plugin_name'] ), esc_html( $this->options['notice_for'] ) ); ?></h3>

                    <p class="notice-text">
						<?php echo $this->options['notice_message']; ?>
                    </p>
                    <p>
                        <a class="button button-primary"
                           href="<?php echo esc_url( $this->options['download_link'] ); ?>" target="_blank">Buy Now</a>
                        <a class="button button-dismiss" href="#">Dismiss</a>
                    </p>
                </div>
				<?php
			}
		);

		add_action(
			'admin_footer',
			function () {
				?>
                <script type="text/javascript">
                    (function ($) {
                        $(function () {
                            setTimeout(function () {
                                $('div[data-cptwoointdismissable] .notice-dismiss, div[data-cptwoointdismissable] .button-dismiss')
                                    .on('click', function (e) {
                                        e.preventDefault();
                                        $.post(ajaxurl, {
                                            'action': 'cptwooint_dismiss_offer_admin_notice',
                                            'nonce': <?php echo wp_json_encode( wp_create_nonce( 'cptwooint-offer-dismissible-notice' ) ); ?>
                                        });
                                        $(e.target).closest('.is-dismissible').remove();
                                    });
                            }, 1000);
                        });
                    })(jQuery);
                </script>
				<?php
			}
		);

		add_action(
			'wp_ajax_cptwooint_dismiss_offer_admin_notice',
			function () {
				check_ajax_referer( 'cptwooint-offer-dismissible-notice', 'nonce' );
				if ( ! empty( $this->options['option_name'] ) ) {
					update_option( $this->options['option_name'], '1' );
				}
				wp_die();
			}
		);
	}


}
