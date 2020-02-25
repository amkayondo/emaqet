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

namespace app\extensions\securityManager\admin\controllers;

use app\extensions\securityManager\models\SecurityReason;
use app\extensions\securityManager\models\SecurityReasonSearch;
use yii\web\NotFoundHttpException;

/**
 * Class SecurityReasonController
 * @package app\extensions\securityManager\admin\controllers
 */
class SecurityReasonController extends \app\modules\admin\yii\web\Controller
{

    /**
     * Shows list of security logs of admin attempts
     *
     * @return string|\yii\web\Response
     */
    public function actionBanReasons()
    {
        $searchModel              = new SecurityReasonSearch();
        $searchModel->reason_type = SecurityReason::REASON_TYPE_BAN;
        $dataProvider             = $searchModel->search(request()->queryParams);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Ban Reasons'),
            'pageHeading'    => t('app', 'Ban Reasons'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Extensions'), 'url' => ['/admin/extensions']] ,
            ],
        ]);

        return $this->render('@app/extensions/securityManager/admin/views/security-reason/list', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'reasonType'   => SecurityReason::REASON_TYPE_BAN,
        ]);
    }

    /**
     * Shows list of security logs of customer attempts
     *
     * @return string|\yii\web\Response
     */
    public function actionInappropriateReportReasons()
    {
        $searchModel              = new SecurityReasonSearch();
        $searchModel->reason_type = SecurityReason::REASON_TYPE_INAPPROPRIATE_REPORT;
        $dataProvider             = $searchModel->search(request()->queryParams);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Inappropriate Report Reasons'),
            'pageHeading'    => t('app', 'Inappropriate Report Reasons'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Extensions'), 'url' => ['/admin/extensions']] ,
            ],
        ]);

        return $this->render('@app/extensions/securityManager/admin/views/security-reason/list', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'reasonType'   => SecurityReason::REASON_TYPE_INAPPROPRIATE_REPORT,
        ]);
    }

    /**
     * Creates a new security reason
     *
     * @param $reasonType
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate($reasonType)
    {
        $model              = new SecurityReason();
        $model->reason_type = $reasonType;

        if ($model->load(request()->post()) && $model->save()) {
            notify()->addSuccess(t('app', 'Your action is complete.'));

            $redirect = SecurityReason::REASON_TYPE_BAN == $reasonType ? ['ban-reasons'] : ['inappropriate-report-reasons'];

            return $this->redirect($redirect);
        } else {

            $this->setViewParams([
                'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Create Reason'),
                'pageHeading'    => t('app', 'Create Reason'),
                'pageBreadcrumbs'=> [
                    ['label' => t('app', 'Extensions'), 'url' => ['/admin/extensions']] ,
                ],
            ]);

            return $this->render('@app/extensions/securityManager/admin/views/security-reason/form', [
                'action' => 'create',
                'model'  => $model,
            ]);
        }
    }

    /**
     * Updates a specific security reason
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(request()->post()) && $model->save()) {
            notify()->addSuccess(t('app', 'Your action is complete.'));
            $redirect = SecurityReason::REASON_TYPE_BAN == $model->reason_type ? ['ban-reasons'] : ['inappropriate-report-reasons'];

            return $this->redirect($redirect);
        } else {
            $this->setViewParams([
                'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Update Reason'),
                'pageHeading'    => t('app', 'Update Reason'),
                'pageBreadcrumbs'=> [
                    ['label' => t('app', 'Extensions'), 'url' => ['/admin/extensions']] ,
                ],
            ]);

            return $this->render('@app/extensions/securityManager/admin/views/security-reason/form', [
                'action' => 'update',
                'model'  => $model,
            ]);
        }
    }

    /**
     * Deletes a specific record
     *
     * @param $id
     *
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        notify()->addSuccess(t('app', 'Your action is complete.'));
        $redirect = SecurityReason::REASON_TYPE_BAN == $model->reason_type ? ['ban-reasons'] : ['inappropriate-report-reasons'];

        return $this->redirect($redirect);
    }

    /**
     * Finds the SecurityReason model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param $id
     * @return SecurityReason the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SecurityReason::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
    }
}