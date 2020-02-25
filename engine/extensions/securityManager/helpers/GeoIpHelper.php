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

namespace app\extensions\securityManager\helpers;

use GeoIp2\Database\Reader;
use Yii;

/**
 * Class GeoIpHelper
 * @package app\helpers
 */
class GeoIpHelper
{

    /**
     * Retrieves name of country from GeoLite2 db by ip address
     *
     * @param $ipAddress
     *
     * @return string|bool name of country or false
     */
    public static function getCountry($ipAddress)
    {
        $countryDb = Yii::getAlias('@app') . '/data/maxmind/GeoLite2-Country.mmdb';

        if (file_exists($countryDb)) {
            // uses 'try catch' to avoid throwing of error in case if ip doesn't found in database
            try {
                $reader       = new Reader($countryDb);
                $record       = $reader->country($ipAddress);
                $countryNames = $record->country->names;

                // there is list of locales, but we use just en by default
                if (!empty($countryNames['en'])) {
                    return $countryNames['en'];
                }
            } catch (\Exception $e) {
                // ignore exception
            }
        }

        return false;
    }

    /**
     * Retrieves name of city from GeoLite2 db by ip address
     *
     * @param $ipAddress
     *
     * @return string|bool name of city or false
     */
    public static function getCity($ipAddress)
    {
        $cityDb = Yii::getAlias('@app') . '/data/maxmind/GeoLite2-City.mmdb';

        if (file_exists($cityDb)) {
            // uses 'try catch' to avoid throwing of error in case if ip doesn't found in database
            try {
                $reader    = new Reader($cityDb);
                $record    = $reader->city($ipAddress);
                $cityNames = $record->city->names;

                // there is list of locales, but we use just en by default
                if (!empty($cityNames['en'])) {
                    return $cityNames['en'];
                }
            } catch (\Exception $e) {
                // ignore exception
            }
        }

        return false;
    }
}

?>