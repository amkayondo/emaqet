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

namespace app\modules\admin\controllers;

/**
 * Controls the actions for dashboard section
 *
 * @Class DashboardController
 * @package app\modules\admin\controllers
 */
class DashboardController extends \app\modules\admin\yii\web\Controller
{
    /**
     * Lists all widgets in dashboard
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Dashboard'),
            'pageHeading'    => t('app', 'Dashboard'),
        ]);

        return $this->render('index', [
            'model' => '',
        ]);
    }

}
