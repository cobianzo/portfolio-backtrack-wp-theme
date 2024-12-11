<?php

/**
 * Actions relative to the Model User, in wp_user data.
 * Including CRUD to add/remove portfolio for the user.
 */
class User_Controller {

	/**
	 * Init the class, hooking the actions.
	 *
	 * @return void
	 */
	public static function init(): void {
		add_action( 'wp_ajax_add_to_current_user_portfolio', [ __CLASS__, 'add_to_portfolio_ajax' ] );
		add_action( 'wp_ajax_nopriv_add_to_current_user_portfolio', [ __CLASS__, 'add_to_portfolio_ajax' ] );
		add_action( 'wp_ajax_remove_from_current_user_portfolio', [ __CLASS__, 'remove_from_portfolio_ajax' ] );
		add_action( 'wp_ajax_nopriv_remove_from_current_user_portfolio', [ __CLASS__, 'remove_from_portfolio_ajax' ] );
	}

	/**
	 * Add the ticker to the current user's portfolio via AJAX.
	 *
	 * @return void
	 */
	public static function add_to_portfolio_ajax(): void {
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
		if ( ! wp_verify_nonce( $nonce, 'dynamic_blocks_nonce_action' ) ) {
			wp_send_json_error( [ 'message' => 'Invalid nonce' ] );
		}

		$ticker = isset( $_POST['ticker'] ) ? sanitize_text_field( $_POST['ticker'] ) : '';
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

	/**
	 * Remove the ticker from the current user's portfolio via AJAX.
	 *
	 * @return void
	 */
	public static function remove_from_portfolio_ajax(): void {
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
		if ( ! wp_verify_nonce( $nonce, 'dynamic_blocks_nonce_action' ) ) {
			wp_send_json_error( [ 'message' => 'Invalid nonce' ] );
		}

		$ticker = isset( $_POST['ticker'] ) ? sanitize_text_field( $_POST['ticker'] ) : '';
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

	/**
	 * Add a ticker to the current user's portfolio.
	 *
	 * @param string $ticker The ticker symbol to add.
	 * @return bool True on success, false on failure.
	 */
	public static function add_to_current_user_portfolio( string $ticker ): mixed {
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

	/**
	 * Remove a ticker from the current user's portfolio.
	 *
	 * @param string $ticker The ticker symbol to remove.
	 * @return bool True on success, false on failure.
	 */
	public static function remove_from_current_user_portfolio( string $ticker ) {
		$user_id = get_current_user_id();
		if ( ! $user_id ) {
			return false;
		}
		$portfolio = get_user_meta( $user_id, 'portfolio', true );
		$portfolio = array_values( array_filter( $portfolio, function ( $v ) use ( $ticker ) {
			return $v !== $ticker;
		} ) );
		if ( empty( $portfolio ) ) {
			return delete_user_meta( $user_id, 'portfolio' );
		} else {
			return update_user_meta( $user_id, 'portfolio', $portfolio );
		}
	}

	/**
	 * Helper: Check if a ticker is in the current user's portfolio.
	 *
	 * @param string $ticker The ticker symbol to check.
	 * @return bool|null True if in portfolio, false if not, null if not logged in.
	 */
	public static function is_in_current_user_portfolio( string $ticker ) {
		$user_id = get_current_user_id();
		if ( ! $user_id ) {
			return null;
		}

		$portfolio = get_user_meta( $user_id, 'portfolio', true );
		$portfolio = is_array( $portfolio ) ? $portfolio : [];
		return in_array( $ticker, $portfolio );
	}

	/**
	 * Retrieve the list of all tickers in the current user's portfolio.
	 *
	 * @return array|null An array of ticker symbols, or null if not logged in.
	 */
	public static function get_current_user_portfolio(): ?array {
		$user_id = get_current_user_id();
		if ( ! $user_id ) {
			return null;
		}

		$portfolio = get_user_meta( $user_id, 'portfolio', true );
		return is_array( $portfolio ) ? $portfolio : [];
	}
}

User_Controller::init();
