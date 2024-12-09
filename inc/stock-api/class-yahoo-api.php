<?php

/**
 * Singleton for the API class to Yahoo Finance or whatever provider
 * Usage: $yahoo_api = Yahoo_API::get_instance();
 *
 * Deprecated. I will use direct calls calls to Yfinance from js using node-yahoo-finance2
 */
class Yahoo_API {

	/**
	 * The one true Yahoo_API instance
	 *
	 * @var Yahoo_API
	 */
	private static $instance;

	/**
	 * The base URL for the API
	 *
	 * @var string
	 */
	private $base_url = 'https://query2.finance.yahoo.com/v1/finance';

	/**
	 * Get the instance of Yahoo_API.
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
			// use any init if we need to init things once the instance is gnerated.
		}

		return self::$instance;
	}

	/**
	 * Initialize the class.
	 */
	protected function __construct() {
	}

	/**
	 * Searches for tickers based on a search term
	 * Usage: Yahoo_API::get_instance()->search_tickers( 'GOOGL' );
	 * Type of ticker info: { "exchange": "NMS", "shortname": "Apple Inc.", "quoteType": "EQUITY",
	 * "symbol": "AAPL", "index": "quotes", "score": 2953800, "typeDisp": "Equity",
	 * "longname": "Apple Inc.","symbol": "AAPL" }
	 *
	 * @param string $search_term Término de búsqueda
	 * @param boolean $single Returns one ticket and only if is exactly the same as the term
	 * @return array|object|null|false of tickers in $single is false. Just one Object ticker if @single is true.
	 * if error returns null, if nothing found returns empty array if $single is false,or false if $single is true.
	 */
	public function search_tickers( string $search_term, bool $single = false ): array|object|null|false {
			$args = array(
				'q'                => $search_term,
				'quotesCount'      => 30,
				'newsCount'        => 0,
				'enableFuzzyQuery' => false,
				'quotesQueryId'    => 'tss_match_phrase_query',
			);

			$url = add_query_arg( $args, $this->base_url . '/search' );

			// TODO: use cache or transients.
			// phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.wp_remote_get_wp_remote_get
			$response = wp_remote_get( $url, [
				'timeout' => 3,
				'headers' => array( 'Accept' => 'application/json' ),
			] );

		if ( is_wp_error( $response ) ) {
				return null;
		}

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		// Yahoo returns the list of tickers inside of 'quotes'. We only want the EQUITY, not options, futures...
		$results = ! empty( $data['quotes'] ) ? $data['quotes'] : array();
		$results = array_filter( $results, fn( $result ) => 'EQUITY' === $result['quoteType'] );
		$results = array_values( $results );

		if ( $single ) {
			$results = array_filter( $results, fn( $result ) => $result['symbol'] === $search_term );
			return count( $results ) ? $results[0] : false;
		}
		return $results;
	}
}
