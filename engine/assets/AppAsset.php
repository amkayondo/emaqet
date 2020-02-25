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

use app\models\options\Common;
use app\assets\CookieConsentAsset;
use yii\web\AssetBundle;

/**
 * Class AppAsset
 * @package app\assets
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $basePath = '@webroot';
    /**
     * @var string
     */
    public $baseUrl = '@web';
    /**
     * @var array
     */
    public $css = [
        'assets/site/css/style.css',
        'assets/site/css/app.css',
    ];
    /**
     * @var array
     */
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js',
        'assets/site/js/main.js',
    ];
    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'app\assets\FontsAsset',
        'app\assets\LazysizesAsset',
        'app\assets\JqueryPluginsAsset',
        'rmrevin\yii\fontawesome\cdn\AssetBundle',
        'twisted1919\notify\NotifyAsset',
        'app\assets\Select2Asset',
        'app\assets\MCustomScrollbarAsset',
        'kartik\select2\Select2Asset',
        'kartik\select2\ThemeKrajeeAsset',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ((new Common())->getShowCookieConsent()) {
            $this->depends[] = get_class(new CookieConsentAsset);
        }
        parent::init();
    }
}
