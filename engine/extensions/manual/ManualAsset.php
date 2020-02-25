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

namespace app\extensions\manual;

use yii\web\AssetBundle;

/**
 * Class ManualAsset
 * @package app\extensions\manual
 */
class ManualAsset extends AssetBundle
{
    public $sourcePath = '@app/extensions/manual/assets';

    public $css = [

    ];
    public $js = [
        'manual.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}