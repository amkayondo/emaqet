<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.5
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Class CookieConsentAsset
 * @package app\assets
 */
class CookieConsentAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $basePath = '@webroot';
    /**
     * @var string
     */
    public $baseUrl = '@web';
    /**
     * @var array
     */
    public $css = [
    ];
    /**
     * @var array
     */
    public $js = [
        'assets/common/cookie-consent/cookie.js',
    ];
    /**
     * @var array
     */
    public $depends = [];

}
