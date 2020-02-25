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

namespace app\extensions\securityManager\controllers;

use app\extensions\securityManager\models\SecurityInappropriateReport;
use yii\web\Controller;
use Yii;

/**
 * Class SecurityManagerController
 * @package app\extensions\securityManager\controllers
 */
class SecurityManagerController extends Controller
{
    /**
     * Inappropriate report processing
     *
     * @return string|\yii\web\Response
     */
    public function actionInappropriateReport()
    {
        $model         = new SecurityInappropriateReport();
        $model->status = SecurityInappropriateReport::STATUS_PENDING;

        if ($model->load(request()->post()) && $model->save()) {
            notify()->addSuccess(t('app', 'Thank you! Your report is accepted for processing.'));
        } else {
            notify()->addError(t('app', 'Something went wrong! Please contact us with any other of available ways.'));
        }

        return $this->redirect(request()->referrer);
    }
}