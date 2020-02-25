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

use \app\yii\base\Event;
use yii\web\AssetBundle;


class AdAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'assets/site/js/ad.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'app\assets\JqueryPaymentAsset',
        'app\assets\OwlCarouselAsset',
        'app\assets\FlexSliderAsset',
        'app\assets\SortableAsset',
        'app\assets\FileinputAsset',
    ];

    public function init()
    {
        app()->trigger('app.ad.assets', new Event(['params' => [
            'asset' => $this
        ]]));
        parent::init();
    }
}
