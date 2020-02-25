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

class LazysizesAsset extends AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = '@bower/lazysizes';

    /**
     * @var array
     */
    public $css = [
    ];

    /**
     * @var array
     */
    public $js = [
        'lazysizes.min.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
