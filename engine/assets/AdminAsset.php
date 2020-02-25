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

class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'assets/admin/css/admin.css',
    ];
    public $js = [
        'assets/admin/js/admin.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'dmstr\web\AdminLteAsset',
        'app\assets\BootstrapSwitchAsset',
        'app\assets\FileinputAsset',
        'app\assets\ColorPickerAsset',
        'app\assets\SpeakingurlAsset',
        'twisted1919\notify\NotifyAsset',
    ];
}
