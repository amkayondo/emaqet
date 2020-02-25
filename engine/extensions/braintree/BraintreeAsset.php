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

namespace app\extensions\braintree;

use yii\web\AssetBundle;

/**
 * Class BraintreeAsset
 * @package app\extensions\braintree
 */
class BraintreeAsset extends AssetBundle
{
    public $sourcePath = '@app/extensions/braintree/assets';

    public $css = [

    ];
    public $js = [
        'braintree.js',
        'https://js.braintreegateway.com/web/3.12.1/js/client.min.js',
        'https://js.braintreegateway.com/web/3.12.1/js/hosted-fields.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}