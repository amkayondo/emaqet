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

namespace app\fieldbuilder\select;

use yii\web\AssetBundle;

class SelectAsset extends AssetBundle
{
    public $sourcePath = '@app/fieldbuilder/select/assets';

    public $css = [

    ];
    public $js = [
        'field.js',
    ];

    public $depends = [
        'app\assets\AdminLteAsset',
    ];
}