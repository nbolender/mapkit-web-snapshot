# nbolender/mapkit-web-snapshot

PHP library that generates a signed URL to an Apple Maps Web Snapshot.

## Install
```bash
composer require nbolender/mapkit-web-snapshot
```

## Usage
```php
use NBolender\MapKit\WebSnapshot;

$teamId = 'XXXXXXXXXX'; // Apple Developer Team ID
$keyId = 'XXXXXXXXXX'; // Apple MapKit Key ID
$private_key = '-----BEGIN PRIVATE KEY-----
...
-----END PRIVATE KEY-----'; // Contents of, or path to, private key file
$center = 'One Apple Park Way, Cupertino, CA 95014'; // The center of the map, specified as either coordinates or an address

// (Optional) A keyed array of any additional map parameters; JSON parameters will be automatically encoded
$additional_parameters = [
    'z' => 12,
    'size' => '300x300',
    't' => 'standard',
    'colorScheme' => 'dark',
    'annotations' => [
        [
            'color' => 'ff0000',
            'markerStyle' => 'balloon',
            'point' => 'center',
        ],
    ],
];

$url = WebSnapshot::signedURL($teamId, $keyId, $private_key, $additional_parameters);
echo $url;
```

## Apple Documentation

* [Maps Web Snapshots Documentation](https://developer.apple.com/documentation/snapshots)
* [Web Service Endpoint & Supported Parameters](https://developer.apple.com/documentation/snapshots/create_a_maps_web_snapshot)

## License

This project is open-source software and licensed under the MIT license.

## Credits

This project is developed by [Nathan Bolender](https://github.com/nbolender). Special thanks to [Thomas Schoffelen](https://github.com/tschoffelen) and his [MapKit JWT library](https://github.com/flexible-agency/mapkit-jwt), which was referenced for this project.
