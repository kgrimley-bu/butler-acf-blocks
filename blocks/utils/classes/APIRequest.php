<?php
/**
 * `Class` that holds multiple methods of retrieving data.
 *
 * Each `method` in this `class` returns a different set of data, but use `curl` to query an API.
 * Useful for the many different blocks that need to query separate APIs.
 *
 * List of methods:
 *      - `get_news_data( $params='', $endpoint='posts' )` for use when retrieving news data from https://stories.butler.edu
 */
class APIRequest {

	/**
	 * Gets News Data from the specified endpoint with parameters.
	 *
	 * Queries the API hosted on https://stories.butler.edu using `curl` using the supplied `params` and `endoint`.
	 * This will return a `json` object if the return code is `200`. Otherwise, it will return `false`.
	 *
	 * @param string $params Optional. Accepts a variety of parameters, including how many stories to include per page i.e. `"per_page=3"`. Default `""`.
	 * @param string $endpoint Optional. Default `"posts"`.
	 * @return mixed | boolean Returns a JSON object if the request's return code is `200`, otherwise returns `false`.
	 */
	public function get_news_data( $params = '', $endpoint = 'posts' ) {

		$get_url = 'https://stories.butler.edu/wp-json/wp/v2/' . $endpoint . '?' . $params . '&_embed&_envelope';
		$curl = curl_init();

		curl_setopt_array(
			$curl,
			array(
				CURLOPT_URL => $get_url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
			)
		);

		$response = curl_exec( $curl );
		$httpcode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );

		curl_close( $curl );

		// return data only if we have a 200 code
		if ( $httpcode == 200 ) {
			return json_decode( $response );
		} else {
			return false;
		}
	}

	public function get_event_data( $params ) {
		$curl = curl_init();
		curl_setopt_array(
			$curl,
			array(
				CURLOPT_URL => 'https://events.butler.edu/admin/api/' . $params,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
					'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJid2lsbGlzIiwic24iOiJXaWxsaXMiLCJwZXJtaXNzaW9ucyI6WyJhZG1pbiJdLCJnaXZlbm5hbWUiOiJCcnVjZSIsImVtcGxpZCI6IjAwMDAwMDAwMSIsIm1haWwiOiJid2lsbGlzQGJ1dGxlci5lZHUiLCJpc3MiOiJhdXRoLWJhY2tlbmQifQ.dc0wzdXAg9RhR0lYI-HE_ZSRPkc6VjXIey0hpJK_Ci0',
				),
			)
		);

		$response = curl_exec( $curl );
		$httpcode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );

		curl_close( $curl );

		// return data only if we have a 200 code
		if ( $httpcode == 200 ) {
			return json_decode( $response )->data;
		} else {
			return false;
		}
	}
}
