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

namespace app\extensions\adBanners;

use app\extensions\adBanners\helpers\AdBannersHelper;
use app\helpers\CommonHelper;
use yii\helpers\ArrayHelper;

/**
 * Class AdBanners
 * @package app\extensions\adBanners
 */
class Adbanners extends \app\init\Extension
{

    public $name = 'Advertising Banners';

    public $author = 'CodinBit Development Team';

    public $version = '1.1';

    public $description = 'Adds banners of advertising in pages';

    public $type = 'tools';

    public function run()
    {

        // register controller
        app()->on('app.modules.admin.init', function($event) {
            $event->params['module']->controllerMap['ad-banners'] = [
                'class' => 'app\extensions\adBanners\admin\controllers\AdBannersController'
            ];
        });

        app()->on('app.header.beforeScripts', function($event) {
            echo options()->get('app.extensions.adBanners.headScripts', '');
        });

        $locations = AdBannersHelper::getStaticAdBannersProperties();
        foreach ($locations as $location) {
            app()->on($location['event'], function($event) use ($location){
                echo options()->get('app.extensions.adBanners.' . $location['optionKey'], '');
            });
        }
    }

    /**
     * @inheritdoc
     */
    public function getPageUrl()
    {
        return url(['/admin/ad-banners']);
    }
}