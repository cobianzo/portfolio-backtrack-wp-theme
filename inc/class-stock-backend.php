<?php

/**
 */
class Stock_Backend {

	public static function init() {
		add_action( 'wp_ajax_add_to_current_user_portfolio', [ __CLASS__, 'add_to_portfolio_ajax' ] );
		add_action( 'wp_ajax_nopriv_add_to_current_user_portfolio', [ __CLASS__, 'add_to_portfolio_ajax' ] );
		add_action( 'wp_ajax_remove_from_current_user_portfolio', [ __CLASS__, 'remove_from_portfolio_ajax' ] );
		add_action( 'wp_ajax_nopriv_remove_from_current_user_portfolio', [ __CLASS__, 'remove_from_portfolio_ajax' ] );

	}

	public static function add_to_portfolio_ajax() {
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
		if ( ! wp_verify_nonce( $nonce, 'dynamic_blocks_nonce_action' ) ) {
			wp_send_json_error( [ 'message' => 'Invalid nonce' ] );
		}

		// get the ticker
		$ticker = isset( $_POST['ticker'] ) ? sanitize_text_field( $_POST['ticker'] ) : '';
		// check if the ticker is valid
		if ( empty( $ticker ) ) {
			wp_send_json_error( [ 'message' => 'Invalid ticker' ] );
		}

		$success = self::add_to_current_user_portfolio( $ticker );
		if ( $success ) {
			wp_send_json_success( [ 'message' => 'Added to portfolio' ] );
		} else {
			wp_send_json_error( [ 'message' => 'User not logged in' ] );
		}
	}

	public static function remove_from_portfolio_ajax(){
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
		if ( ! wp_verify_nonce( $nonce, 'dynamic_blocks_nonce_action' ) ) {
			wp_send_json_error( [ 'message' => 'Invalid nonce' ] );
		}

		// get the ticker
		$ticker = isset( $_POST['ticker'] ) ? sanitize_text_field( $_POST['ticker'] ) : '';
		// check if the ticker is valid
		if ( empty( $ticker ) ) {
			wp_send_json_error( [ 'message' => 'Invalid ticker' ] );
		}

		$success = self::remove_from_current_user_portfolio( $ticker );
		if ( $success ) {
			wp_send_json_success( [ 'message' => 'Removed from portfolio' ] );
		} else {
			wp_send_json_error( [ 'message' => 'User not logged in' ] );
		}
	}
	// Now the CRUD
	// =========

	public static function add_to_current_user_portfolio( string $ticker ) {
		$user_id = get_current_user_id();
		if ( ! $user_id ) {
			return false;
		}
		$portfolio   = get_user_meta( $user_id, 'portfolio', true );
		$portfolio   = $portfolio ? $portfolio : [];
		$portfolio[] = $ticker;
		$portfolio   = array_unique( $portfolio );
		$return      = update_user_meta( $user_id, 'portfolio', $portfolio );
		return $return;
	}

	public static function remove_from_current_user_portfolio( string $ticker ) {
		$user_id = get_current_user_id();
		if ( ! $user_id ) {
			return false;
		}
		$portfolio   = get_user_meta( $user_id, 'portfolio', true );
		$portfolio = array_values( array_filter( $portfolio, function( $v ) use ( $ticker ) {
			return $v !== $ticker;
		} ) );
		if ( empty( $portfolio ) ) {
			return delete_user_meta( $user_id, 'portfolio' );
		} else {
			return update_user_meta( $user_id, 'portfolio', $portfolio );
		}
	}

	public static function is_in_current_user_portfolio( string $ticker ) {
		$user_id = get_current_user_id();
		if ( ! $user_id ) {
			return null;
		}

		$portfolio = get_user_meta( $user_id, 'portfolio', true );
		$portfolio = is_array($portfolio) ? $portfolio : [];
		return in_array( $ticker, $portfolio );
	}

}

Stock_Backend::init();
