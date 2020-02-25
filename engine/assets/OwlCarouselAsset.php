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

class OwlCarouselAsset extends AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = '@bower/owl.carousel/dist';

    /**
     * @var array
     */
    public $css = [
        'assets/owl.carousel.min.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'owl.carousel.min.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
