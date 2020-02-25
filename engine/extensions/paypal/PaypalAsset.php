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

namespace app\extensions\paypal;

use yii\web\AssetBundle;

/**
 * Class PaypalAsset
 * @package app\extensions\paypal
 */
class PaypalAsset extends AssetBundle
{
    public $sourcePath = '@app/extensions/paypal/assets';

    public $css = [

    ];
    public $js = [
        'paypal.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}