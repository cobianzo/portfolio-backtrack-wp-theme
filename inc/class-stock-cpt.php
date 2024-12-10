<?php

/**
 * The CPT, for now, is generated using the plugin SCF.
 * @TODO: So it's defined in the DB, but we could export it into code. (we should)
 */
class Stock_CPT {

	public static function init() {
	}



	public static function get_stock_post_by_symbol( string $symbol ): int {
		$post_name = sanitize_title( $symbol );
		$post      = get_page_by_path( $post_name, OBJECT, 'stock' );

		if ( isset( $post->ID ) ) {
			return $post->ID;
		}

		return 0;
	}

	public static function get_stock_historical( string $symbol ): array|bool {
		$post_id = self::get_stock_post_by_symbol( $symbol );
		if ( ! $post_id ) {
			return false;
		}
		$historical = get_post_meta( $post_id, 'stock_historical', true );
		if ( ! $historical ) {
			return false;
		}

		return $historical;
	}

	// function to create a new CPT from a ticker name
	public static function create_stock_post( string $symbol ): int {

		// first we check if it exists
		$post_exists = self::get_stock_post_by_symbol( $symbol );
		if ( $post_exists ) {
			return $post_exists;
		}

		$post_data = array(
			'post_title'  => $symbol,
			'post_name'   => sanitize_title( $symbol ),
			'post_type'   => 'stock',
			'post_status' => 'publish',
		);

		// Insert the post into the database
		$post_id = wp_insert_post( $post_data );
		if ( is_wp_error( $post_id ) || ! is_numeric( $post_id ) ) {
			return 0;
		}

		return $post_id;
	}

	// update the historical of divs for a stock, including the date of last update.
	public static function update_stock_historical( string $symbol, array $data ): bool {

		// @TODO: What happens when the $data is a subset of the current data? Like, it's referring to years
		// that already exist in the post, giving old data? then it shouldnt update.

		$post_id = self::get_stock_post_by_symbol( $symbol );
		if ( ! $post_id ) {
			return false;
		}
		update_post_meta( $post_id, 'stock_historical', $data );
		update_post_meta( $post_id, 'stock_last_update', time() );

		$last_record = array_slice( $data, -1 )[0];
		update_post_meta( $post_id, 'stock_last_div_date', $last_record['last_div_date'] );

		return true;
	}
}

Stock_CPT::init();
