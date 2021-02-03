<?php

namespace NBolender\MapKit;

/**
 * Class WebSnapshot
 *
 * @package NBolender\MapKit
 * @author Nathan Bolender
 * @license https://github.com/nbolender/mapkit-web-snapshot/master/LICENSE
 * @link https://github.com/nbolender/mapkit-web-snapshot
 */
class WebSnapshot {
	public static $snapshot_base_url = 'https://snapshot.apple-mapkit.com';
	public static $snapshot_uri = '/api/v1/snapshot';
	public static $json_params = [
		'annotations',
		'overlays',
		'imgs',
	];

	/**
	 * Generates a signed URL to an Apple Maps snapshot image.
	 *
	 * @param string $teamId Apple Developer Team ID
	 * @param string $keyId Apple MapKit Key ID
	 * @param string $private_key Contents of, or path to, private key file
	 * @param string $center The center of the map, specified as either coordinates or an address
	 * @param array $additional_params A keyed array of any additional map parameters; JSON parameters will be automatically encoded
	 * @return false|string
	 */
	public static function signedURL($teamId, $keyId, $private_key, $center, $additional_params = []) {
		foreach (static::$json_params as $param) {
			if (isset($additional_params[$param])) {
				$additional_params[$param] = json_encode($additional_params[$param]);
			}
		}

		$params = array_merge([
			'center' => $center,
			'teamId' => $teamId,
			'keyId' => $keyId,
		], $additional_params);

		$request_uri = static::$snapshot_uri . '?' . http_build_query($params);

		if (!$key = openssl_pkey_get_private($private_key)) {
			return false;
		}

		if (!openssl_sign($request_uri, $signature, $key, OPENSSL_ALGO_SHA256)) {
			return false;
		}

		return static::$snapshot_base_url . $request_uri . '&signature=' . urlencode(base64_encode($signature));
	}
}
