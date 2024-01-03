<?php
/**
 * Main ActionHooks class.
 *
 * @package TinySolutions\pqe
 */

namespace TinySolutions\pqe\Controllers\Hooks;

use TinySolutions\pqe\Helpers\Fns;

defined( 'ABSPATH' ) || exit();

/**
 * Main ActionHooks class.
 */
class ActionHooks {

	/**
	 * Init Hooks.
	 *
	 * @return void
	 */
	public static function init_hooks() {
		$options = Fns::get_options();
		if ( ! empty( $options['selected_post_types'] ) && count( $options['selected_post_types'] ) ) {
			foreach ( $options['selected_post_types'] as $item ) {
				add_action( 'manage_' . $item . '_posts_custom_column', [ __CLASS__, 'custom_product_list_column_content' ], 10, 2 );
			}
		}
	}

	/**
	 * Product column content
	 *
	 * @param string $column column name.
	 * @param int    $post_id product id.
	 * @return void
	 */
	public static function custom_product_list_column_content( $column, $post_id ) {
		if ( 'qe_column' === $column ) {
			$url = '/post.php?action=edit&post=' . $post_id;
			?>
			<button
				class="edit-button"
				type="button"
				data-url="<?php echo esc_url( admin_url( $url ) ); ?>"
			>
				Edit
			</button>
			<?php
		}
	}
}
