<?php
/**
*
* @package    EasyAds
* @author     CodinBit <contact@codinbit.com>
* @link       https://store.codinbit.com
* @copyright  2017 EasyAds (https://store.codinbit.com)
* @license    https://www.codinbit.com
* @since      1.0
*/

namespace app\helpers;

/**
* Class StringHelper
* @package app\helpers
*/
class LocationHelper
{
    /**
     * @return Coordinates
     */
    public static function getCoordinates($country, $zone, $city, $zip)
    {
        $coordinates = [];
        $location = [];

        (!empty($country)) ? $location[] = $country : $country = ' ';
        (!empty($zone)) ? $location[] = $zone : $zone = ' ';
        (!empty($city)) ? $location[] = $city : $city = ' ';
        (!empty($zip)) ? $location[] = $zip : $zip = '000000';

        $location = array_map('urlencode', array_filter(array_map('trim', $location)));
        $location = implode(',', $location);
        $response = app()->httpClient->get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $location,
            'sensor'  => 'false'
        ])->send();

        $body = json_decode($response->content);

        if (empty($body->status) || $body->status != "OK" || empty($body->results[0]->geometry->location)) {
            return $body;
        }
        $location = $body->results[0]->geometry->location;
        if (!isset($location->lat) || !isset($location->lng)) {
            return $location;
        }

        $coordinates['latitude'] = $location->lat;
        $coordinates['longitude'] = $location->lng;

        return $coordinates;
    }

}

?>