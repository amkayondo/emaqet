<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.3
 */

namespace app\extensions\watermark\admin\controllers;

use app\extensions\watermark\models\options\Watermark;

class WatermarkController extends \app\modules\admin\yii\web\Controller
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
        $model = new Watermark();

        if ($model->load(request()->post()) && $model->save()) {
            return $this->refresh();
        } else {
            $this->setViewParams([
                'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Ad image Watermark Settings'),
                'pageHeading'    => t('app', 'Ad image Watermark Settings'),
                'pageBreadcrumbs'=> [
                    ['label' => t('app', 'Extensions'), 'url' => ['/admin/extensions']] ,
                    t('app', 'Ad image Watermark Settings'),
                ],
            ]);

            return $this->render('@app/extensions/watermark/admin/views/index.php', [
                'model' => $model,
            ]);
        }

    }
}
