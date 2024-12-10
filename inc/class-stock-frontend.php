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
	}


	// Ajax call to show the dividends data results. WIP
	public static function generate_table( $data ) {
		if ( empty( $data ) ) {
			return '<p>No hay datos para mostrar.</p>';
		}

		// Iniciar la tabla
		$html = '<table border="1">';

		// Generar el encabezado de la tabla
		$html   .= '<thead><tr>';
		$html   .= '<th>Title</th>'; // Columna para las llaves
		$columns = array_keys( current( $data ) ); // Obtener las columnas de la primera fila
		foreach ( $columns as $column ) {
			$html .= '<th>' . htmlspecialchars( $column ) . '</th>';
		}
		$html .= '</tr></thead>';

		// Generar las filas de la tabla
		$html .= '<tbody>';
		foreach ( $data as $title => $row ) {
			$html .= '<tr>';
			$html .= '<td>' . htmlspecialchars( $title ) . '</td>'; // Título de la fila (llave del array)
			foreach ( $row as $cell ) {
				$html .= '<td>' . htmlspecialchars( $cell ) . '</td>';
			}
			$html .= '</tr>';
		}
		$html .= '</tbody>';

		// Cerrar la tabla
		$html .= '</table>';

		return $html;
	}
}

Stock_Frontend::init();
