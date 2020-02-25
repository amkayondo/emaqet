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
 * Class SvgHelper
 * @package app\helpers
 */
class SvgHelper
{
    /**
     * @param $name
     * @return string
     */
    public static function getByName($name)
    {
        $svg      = '';
        $basePath = \Yii::getAlias('@webroot/assets/site/svg');
        if (is_file($svgFile = $basePath . '/' . $name . '.svg')) {
            $svg = file_get_contents($svgFile);
        }

        return $svg;
    }
}