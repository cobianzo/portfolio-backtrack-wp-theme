<?php

/**
 * Create the endponts for js internal use, which call Yahoo API
 */
class Internal_Stock_API {

	public static function init(): void {
		add_action( 'rest_api_init', array( __CLASS__, 'register_endpoints' ) );
	}

	public static function register_endpoints(): void {

		require_once 'class-yahoo-api.php';

		// wp-json/stock-api/search?ticker=AAPL
		register_rest_route(
			'stock-api',
			'/search',
			array(
				'methods'             => 'GET',
				'callback'            => function ( WP_REST_Request $request ) {
					$yahoo_api = Yahoo_API::get_instance();
					// TODO: use cache or transients.
					$tickers = $yahoo_api->search_tickers( $request->get_param( 'ticker' ) );
					return $tickers;
				},
				'permission_callback' => '__return_true',
				'args'                => array(
					'ticker' => array(
						'required'          => true,
						'sanitize_callback' => function ( $ticker ) {
							return sanitize_text_field( $ticker );
						},
					),
				),
			)
		);
	}
}

Internal_Stock_API::init();
