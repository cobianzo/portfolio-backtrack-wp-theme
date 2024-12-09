<?php

/**
 * Singleton for the API class to Yahoo Finance or whatever provider
 * Usage: $yahoo_api = Yahoo_API::get_instance();
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
	 * Busca tickers basándose en un término de búsqueda
	 *
	 * @param string $search_term Término de búsqueda
	 * @return array Tickers encontrados
	 */
	public function search_tickers( string $search_term ): array {
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
			$response = wp_remote_get(
				$url,
				array(
					'timeout' => 3,
					'headers' => array(
						'Accept' => 'application/json',
					),
				)
			);

		if ( is_wp_error( $response ) ) {
				return array();
		}

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		// Yahoo returns the list of tickers inside of 'quotes'. We only want the EQUITY, not options, futures...
		$results = ! empty( $data['quotes'] ) ? $data['quotes'] : array();
		$results = array_filter( $results, fn( $result ) => 'EQUITY' === $result['quoteType'] );
		$results = array_values( $results );
		return $results;
	}
}
