<?php
/**
 * Class Dynamic_Partials
 *
 * @package    WordPress
 * @subpackage Portfolio_Theme
 * @since      1.0.0
 */

class Dynamic_Partials {

	public array $blocks = array();
	const BLOCK_NAMESPACE = 'coco';

	/**
	 * Init the blocks with the name of every file inside ./blocks folder
	 */
	public function __construct() {
		// 1. Scan all blocks in the subfolder 'blocks'
		$blocks_dir = __DIR__ . '/blocks';

		if ( is_dir( $blocks_dir ) ) {
			$block_files = glob( $blocks_dir . '/*.php' );
			foreach ( $block_files as $block_file ) {
				// For every template part, we will create a dynamic block for it.
				$this->blocks[] = pathinfo( $block_file, PATHINFO_FILENAME );
			}
		}

		$this->register_hooks();
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function register_hooks(): void {
		add_action( 'init', array( $this, 'register_blocks_as_template_parts' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'register_editor_script_for_block' ) );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function register_blocks_as_template_parts(): void {
		foreach ( $this->blocks as $block_name ) {
			$namespaced_blockname = sprintf( '%s/%s', self::BLOCK_NAMESPACE, $block_name );
			$block_title          = ucwords( str_replace( '-', ' ', $block_name ) );
			register_block_type(
				$namespaced_blockname, // eg. coco/part-ticker-lookup
				array(
					'title'           => $block_title, // eg. Part Ticker Lookup
					'category'        => 'widgets',
					'render_callback' => function ( array $attributes ) use ( $block_name ): string {
						ob_start();
						include __DIR__ . "/blocks/$block_name.php";
						return ob_get_clean();
					},
				)
			);

			// Registrar un script vacío para evitar problemas.
			$script_name = "script-$block_name";
			$deps        = array( 'wp-blocks', 'wp-element', 'wp-editor' );
			wp_register_script( $script_name, '', $deps, '1.0.0', true );
		}
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function register_editor_script_for_block(): void {
		foreach ( $this->blocks as $block_name ) {
			$namespaced_blockname = sprintf( '%s/%s', self::BLOCK_NAMESPACE, $block_name );
			$script_name = "script-$block_name";
			wp_enqueue_script( $script_name );

			$script_inline = <<<JS
	(function(blocks, element) {
			blocks.registerBlockType( '$namespaced_blockname', {
					title: 'Bloque Simple',
					icon: 'smiley',
					category: 'common',
					edit: function() {
							return element.createElement('div', {}, 'Hola desde el editor');
					},
					save: function() {
							return null;
					}
			});
	})(window.wp.blocks, window.wp.element);
JS;

			wp_add_inline_script( $script_name, $script_inline, 'after' );
		}
	}
}

$dynamic_partials = new Dynamic_Partials();
