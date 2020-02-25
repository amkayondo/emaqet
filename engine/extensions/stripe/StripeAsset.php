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

namespace app\extensions\stripe;

use yii\web\AssetBundle;

class StripeAsset extends AssetBundle
{
    public $sourcePath = '@app/extensions/stripe/assets';

    public $css = [
        'stripe.css'

    ];
    public $js = [
        'stripe.js',
        'https://js.stripe.com/v3/',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}