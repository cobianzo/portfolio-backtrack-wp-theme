<?php
/**
 * Class Dynamic_Partials
 *
 * @package    WordPress
 * @subpackage Portfolio_Theme
 * @since      1.0.0
 */

class Dynamic_Partials {

	public array $blocks  = [];
	const BLOCK_NAMESPACE = 'coco';

	/**
	 * Init the blocks with the name of every file inside ./blocks folder
	 */
	public function __construct() {
		// 1. Scan all blocks in the subfolder 'blocks'
		$blocks_dir = __DIR__ . '/blocks';

		if ( is_dir( $blocks_dir ) ) {
			$block_files = glob( $blocks_dir . '/*.php' );
			foreach ( (array) $block_files as $block_file ) {
				// For every template part, we will create a dynamic block for it.
				$this->blocks[] = pathinfo( (string) $block_file, PATHINFO_FILENAME );
			}
		}

		$this->register_hooks();
	}

	/**
	 * Hooks calls
	 *
	 * @return void
	 */
	public function register_hooks(): void {
		add_action( 'init', array( $this, 'register_blocks_as_template_parts' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'register_editor_script_for_block' ) );
		add_action( 'enqueue_block_editor_assets', function () {
			// CSS for the placeholder for the block in the Editor.
			add_action( 'admin_enqueue_scripts',
				function ( $hook ) {
						$css = <<<CSS
						.coco-dynamic-block-wrapper {
							padding: var(--wp--preset--spacing--20);
							border-radius: 5px;
							border: 5px ridge blanchedalmond;
							background: var(--wp--preset--color--accent-5, #033000);
							min-height: 300px;
							place-items: center center;
						}
						CSS;
						wp_add_inline_style( 'wp-block-library', $css );
				}
			);
		} );
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

			$register_block_options = [
				'title'           => $block_title, // eg. Part Ticker Lookup
				'category'        => 'widgets',
				'render_callback' => fn ( array $attributes ): string => self::get_partial_as_html_string( $block_name ),
			];

			// Check if the view script exists and register it if it does.


			$view_script_path = get_stylesheet_directory() . "/build/$block_name.js";
			if ( file_exists( $view_script_path ) ) {
				$view_script_handle = "view-script-$block_name";
				$view_script_url    = get_stylesheet_directory_uri() . "/build/$block_name.js";
				$asset_file = include get_stylesheet_directory() . "/build/$block_name.asset.php";
				$dependencies = empty( $asset_file['dependencies'] ) ? [] : $asset_file['dependencies'];
				$version = empty( $asset_file['version'] ) ? [] : $asset_file['version'];
				wp_register_script( $view_script_handle, $view_script_url, $dependencies, $version, true );
				$register_block_options['view_script'] = $view_script_handle;
			} else {
				ddie( 'error in  ' . $view_script_path );
			}

			register_block_type(
				$namespaced_blockname, // eg. coco/part-ticker-lookup
				$register_block_options
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
			$block_title          = ucwords( str_replace( '-', ' ', $block_name ) );
			$script_name          = "script-$block_name";
			wp_enqueue_script( $script_name );

			// Retrieve all the html fro the php template and use it as a string.
			$html = self::get_partial_as_html_string( $block_name );
			$html = addslashes( $html ); // Escapa comillas simples y dobles
			$html = preg_replace( '/\r?\n|\r/', ' ', $html ); // Reemplaza los saltos de línea por espacios


			$script_inline = <<<JS
	(function(blocks, element) {
			blocks.registerBlockType( '$namespaced_blockname', {
					title: '$block_title',
					icon: 'smiley',
					category: 'common',
					edit: function() {
							return element.createElement('div',
								{ className: 'coco-dynamic-block-wrapper' },
								'Partial: $block_title'
							);
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

	/**
	 * Include the php file for the block and return the output as a string.
	 * The php file should print the html.
	 *
	 * @param string $block_name The name of the block.
	 * @return string The HTML string.
	 */
	public static function get_partial_as_html_string( string $block_name ): string {
		ob_start();
		include __DIR__ . "/blocks/$block_name.php";
		$html = ob_get_clean();
		return (string) $html;
	}
}

$dynamic_partials = new Dynamic_Partials();
