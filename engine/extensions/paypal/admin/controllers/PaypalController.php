<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.4
 */

namespace app\extensions\paypal\admin\controllers;

use app\extensions\paypal\models\Paypal;


class PaypalController extends \app\modules\admin\yii\web\Controller
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
        $model = new Paypal();

        if ($model->load(request()->post()) && $model->save()) {
            return $this->refresh();
        } else {
            $this->setViewParams([
                'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'PayPal Settings'),
                'pageHeading'    => t('app', 'PayPal Settings'),
                'pageBreadcrumbs'=> [
                    ['label' => t('app', 'Extensions'), 'url' => ['/admin/extensions']] ,
                    t('app', 'PayPal Settings'),
                ],
            ]);

            return $this->render('@app/extensions/paypal/admin/views/index.php', [
                'model' => $model
            ]);
        }
    }
}
