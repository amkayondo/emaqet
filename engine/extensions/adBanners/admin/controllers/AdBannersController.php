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

namespace app\extensions\adBanners\admin\controllers;

use app\extensions\adBanners\helpers\AdBannersHelper;
use app\extensions\adBanners\models\options\AdBanners;


class AdBannersController extends \app\modules\admin\yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * Controls general settings
     *
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $model = new AdBanners();

        if ($model->load(request()->post()) && $model->save()) {
            return $this->refresh();
        } else {
            $this->setViewParams([
                'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Ad Banners Settings'),
                'pageHeading'    => t('app', 'Ad Banners Settings'),
                'pageBreadcrumbs'=> [
                    ['label' => t('app', 'Extensions'), 'url' => ['/admin/extensions']] ,
                    t('app', 'Ad Banners Settings'),
                ],
            ]);

            return $this->render('@app/extensions/adBanners/admin/views/index.php', [
                'model' => $model,
                'properties' => AdBannersHelper::getStaticAdBannersProperties()
            ]);
        }
    }
}
