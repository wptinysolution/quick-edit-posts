<?php
/**
 * Main ActionHooks class.
 *
 * @package TinySolutions\pqe
 */

namespace TinySolutions\pqe\Controllers\Hooks;

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
		add_action( 'manage_product_posts_custom_column', [ __CLASS__, 'custom_product_list_column_content' ], 10, 2 );
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
				Quick Edit
			</button>
			<?php
		}
	}
}
