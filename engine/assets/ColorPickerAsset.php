<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.6
 */

namespace app\assets;

use yii\web\AssetBundle;

class ColorPickerAsset extends AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/bootstrap-colorpicker/dist';

    /**
     * @var array
     */
    public $css = [
        'css/bootstrap-colorpicker.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'js/bootstrap-colorpicker.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'dmstr\web\AdminLteAsset',
    ];
}
