<?php

/**
 */
class Stock_Frontend {

	/**
	 * Initialize the Stock_Frontend class.
	 *
	 * This method sets up necessary hooks, actions, or filters to prepare the frontend
	 * functionality of the stock-related features.
	 */
	public static function init() {
		// define the ajax actions to call the render of the table from frontend.
		add_action( 'wp_ajax_generate_table', array( __CLASS__, 'generate_table' ) );
		add_action( 'wp_ajax_nopriv_generate_table', array( __CLASS__, 'generate_table' ) );
	}


	// Ajax call to show the dividends data results. WIP
	// options: titles_map and append
	public static function generate_table( $data = null, $options = [] ) {

		// evaluate nonce if Ajax @TODO:
		if ( empty( $data ) ) {
			$data = json_decode( sanitize_text_field( wp_unslash( $_POST['data'] ) ), true );
			$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			if ( ! wp_verify_nonce( $nonce, 'my_action' ) ) {
				wp_send_json_error( 'Error en la verificaci n de nonce.' );
			}

			if ( isset( $_POST['options'] ) ) {
				$options = json_decode( sanitize_text_field( wp_unslash( $_POST['options'] ) ), true );
			}
		}

		$titles_map = isset( $options['titles_map'] ) ? $options['titles_map'] : null;
		$append     = isset( $options['append'] ) ? $options['append'] : null;

		// Validate $data. It must be an associative array
		if ( ! is_array( $data ) ) {
			$data = [];
		}

		// Iniciar la tabla
		ob_start();
		?>
		<table class="table-auto w-full text-left border-collapse border border-gray-500 shadow-md">
			<thead>
				<tr class="bg-gray-100 border-b border-gray-500">
					<th class="px-4 py-2"><?php
						$title = isset( $titles_map['Title'] ) ? $titles_map['Title'] : 'Title';
						echo esc_html( $title );
					?></th>
					<?php
						$columns = array_keys( current( $data ) );
						foreach ( $columns as $column ) {
							$column_title = isset( $titles_map[ $column ] ) ? $titles_map[ $column ] : $column;
							?>
							<th class="px-4 py-2"><?php echo esc_html( $column_title ); ?></th>
							<?php
						}
					?>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ( $data as $key_cell => $row ) {
						?>
						<tr class="hover:bg-gray-200">
							<td class="px-4 py-2"><?php echo esc_html( $key_cell ); ?></td>
							<?php
								foreach ( $row as $title => $cell ) {
									?>
									<td class="px-4 py-2"><?php
										echo esc_html( $cell );
										echo isset( $append[$title] ) ? $append[$title] : '';
									?></td>
									<?php
								}
							?>
						</tr>
						<?php
					}
				?>
			</tbody>
		</table>
		<?php
		$html = ob_get_clean();

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			wp_send_json_success( $html );
			exit;
		}

		return $html;
	}
}

Stock_Frontend::init();