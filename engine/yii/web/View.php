<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.5
 */

namespace app\yii\web;

use app\models\options\Common;
use yii\helpers\Url;
use yii\web\View as BaseView;

/**
 * Class View
 * @package app\yii\web
 */
class View extends BaseView
{
    /**
     * @inheritdoc
     */
    public function beforeRender($viewFile, $params)
    {
        $commonSettings = new Common();

        // write title from parameter if is not set explicitly
        if (empty($this->title)) {
            $this->title = view_param('pageTitle');

            // set opengraph for general things like url, locale ... etc
            app()->on('app.header.beforeScripts', function () use ($commonSettings){
                echo '<meta property="fb:app_id" content="' . $commonSettings->siteFacebookId . '"/>' . PHP_EOL;
                echo '<meta property="og:title" content="' . $this->title . '" />' . PHP_EOL;
                echo '<meta property="og:site_name" content="' . $commonSettings->siteName . '" />' . PHP_EOL;
                echo '<meta property="twitter:title" content="' . $this->title . '">' . PHP_EOL;
                echo '<meta property="og:type" content="website"/>' . PHP_EOL;
                echo '<meta property="twitter:card" content="summary">' . PHP_EOL;
                echo '<meta property="og:locale" content="' . app()->formatter->locale . '" />' . PHP_EOL;
                echo '<meta property="og:url" content="' . Url::current([], true) . '" />' . PHP_EOL;
                echo '<meta property="twitter:domain" content="' . Url::current([], true) . '">' . PHP_EOL;

                // if image is passed then put opengraph otherwise image is logo
                if (empty(view_param('pageMetaImage'))) {
                    echo '<meta property="og:image" content="' . Url::base(true) . options()->get('app.settings.theme.siteLogo', \Yii::getAlias('/assets/site/img/logo.png')) . '" />' . PHP_EOL;
                    echo '<meta name="twitter:image" content="' . Url::base(true) . options()->get('app.settings.theme.siteLogo', \Yii::getAlias('/assets/site/img/logo.png')) . '">' . PHP_EOL;
                } else {
                    echo '<meta property="og:image" content="' . view_param('pageMetaImage') . '" />' . PHP_EOL;
                    echo '<meta name="twitter:image" content="' . view_param('pageMetaImage') . '">' . PHP_EOL;
                }
            });
        }

        // replace variable with value like {siteName}
        $this->title = str_replace('{siteName}', $commonSettings->siteName, $this->title);


        // write meta from parameter if is not set explicitly
        if (empty($this->metaTags)) {
            $this->registerMetaTag([
                'name' => 'description',
                'content' => view_param('pageMetaDescription'),
            ]);
            $this->registerMetaTag([
                'name' => 'keywords',
                'content' => view_param('pageMetaKeywords'),
            ]);

            app()->on('app.header.beforeScripts', function () {
                echo '<meta property="og:description" content="' . view_param('pageMetaDescription') . '" />' . PHP_EOL;
                echo '<meta property="twitter:description" content="' . view_param('pageMetaDescription') . '">' . PHP_EOL;
            });
        }

        return parent::beforeRender($viewFile, $params);
    }
}