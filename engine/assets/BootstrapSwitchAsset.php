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

namespace app\assets;

use yii\web\AssetBundle;

class BootstrapSwitchAsset extends AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = '@vendor/nostalgiaz/bootstrap-switch/dist';

    /**
     * @var array
     */
    public $css = [
        'css/bootstrap3/bootstrap-switch.min.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'js/bootstrap-switch.min.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}
