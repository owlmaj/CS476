<?php
/**
 * Rest API Class, where we register/execute any REST API Routes
 *
 * @since 1.8.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Rest Api class.
 *
 * @since 1.8.0
 */
class OMAPI_Sites {

	/**
	 * The Base OMAPI Object
	 *
	 *  @since 1.8.0
	 *
	 * @var OMAPI
	 */
	protected $base;

	public function __construct( ) {
		$this->base = OMAPI::get_instance();
	}

	/**
	 * Refresh the site data.
	 *
	 * @since 1.8.0
	 *
	 * @param mixed $api_key If we want to use a custom API Key, pass it in
	 *
	 * @return array|null $sites An array of sites if the request is successful
	 */
	public function fetch( $api_key = null ) {
		$api = OMAPI_Api::build( 'v2', 'sites/origin', 'GET' );

		if ( $api_key ) {
			$api->set( 'apikey', $api_key );
		}

		$body  = $api->request();
		$sites = array(
			'ids'          => array(),
			'customApiUrl' => ''
		);

		if ( ! is_wp_error( $body ) && ! empty( $body->data ) ) {
			foreach ( $body->data as $site ) {
				$checkCnames    = true;
				$sites['ids'][] = (int) $site->numericId;

				$homeUrl = str_replace( array( 'https://', 'www.' ), '', esc_url_raw( home_url( '', 'https' ) ) );

				// If we have a custom CNAME, let's enable it and add the data to the output array.
				// We need to make sure that it matches the home_url to ensure that the correct domain
				// is loaded.
				$wildcardDomain = '*.' === substr( $site->domain, 0, 2 );
				if ( ( $homeUrl === $site->domain || $wildcardDomain ) && $site->settings->enableCustomCnames && $checkCnames ) {
					if ( ! $wildcardDomain ) {
						$checkCnames = false;
					}
					if ( $site->settings->cdnCname && $site->settings->cdnCnameVerified ) {
						$sites['customApiUrl'] = 'https://' . $site->settings->cdnUrl . '/app/js/api.min.js';
					} else if ( $site->settings->apiCname && $site->settings->apiCnameVerified ) {
						// Not sure if this will wreak havoc during verification of the domains, so leaving it commented out for now.
						// $sites['customApiUrl'] = 'https://' . $site->settings->apiUrl . '/a/app/js/api.min.js';
					}
				}
			}
		}

		return $sites;
	}
}
