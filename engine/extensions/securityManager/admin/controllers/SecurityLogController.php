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

use app\extensions\securityManager\models\SecurityBlockedAccess;
use app\extensions\securityManager\models\SecurityLog;
use app\extensions\securityManager\models\SecurityLogSearch;
use yii\web\NotFoundHttpException;

/**
 * Class SecurityLogController
 * @package app\extensions\securityManager\admin\controllers
 */
class SecurityLogController extends \app\modules\admin\yii\web\Controller
{
    /**
     * Shows list of security logs of admin attempts
     *
     * @return string|\yii\web\Response
     */
    public function actionAdminAttempts()
    {
        $blockedAccessModel    = new SecurityBlockedAccess();
        $searchModel           = new SecurityLogSearch();
        $searchModel->log_type = SecurityLog::LOG_TYPE_ADMIN_FAILED_LOGIN;
        $dataProvider          = $searchModel->search(request()->queryParams);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Admin Failed Login Attempts'),
            'pageHeading'    => t('app', 'Admin Failed Login Attempts'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Extensions'), 'url' => ['/admin/extensions']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('@app/extensions/securityManager/admin/views/security-log/list', [
            'blockedAccessModel' => $blockedAccessModel,
            'searchModel'        => $searchModel,
            'dataProvider'       => $dataProvider,
            'logType'            => SecurityLog::LOG_TYPE_ADMIN_FAILED_LOGIN,
        ]);
    }

    /**
     * Shows list of security logs of customer attempts
     *
     * @return string|\yii\web\Response
     */
    public function actionCustomerAttempts()
    {
        $blockedAccessModel    = new SecurityBlockedAccess();
        $searchModel           = new SecurityLogSearch();
        $searchModel->log_type = SecurityLog::LOG_TYPE_CUSTOMER_FAILED_LOGIN;
        $dataProvider          = $searchModel->search(request()->queryParams);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Customer Failed Login Attempts'),
            'pageHeading'    => t('app', 'Customer Failed Login Attempts'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Extensions'), 'url' => ['/admin/extensions']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('@app/extensions/securityManager/admin/views/security-log/list', [
            'blockedAccessModel' => $blockedAccessModel,
            'searchModel'        => $searchModel,
            'dataProvider'       => $dataProvider,
            'logType'            => SecurityLog::LOG_TYPE_CUSTOMER_FAILED_LOGIN,
        ]);
    }

    /**
     *  View a specific Admin log
     *
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'View log #{itemName}', ['itemName'=>$model->log_id]),
            'pageHeading'    => t('app', 'View log #{itemName}', ['itemName'=>$model->log_id]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Extensions'), 'url' => ['/admin/extensions']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('@app/extensions/securityManager/admin/views/security-log/view', [
            'model' => $model,
        ]);
    }

    /**
     * Delete all logs by type
     *
     * @param $logType
     *
     * @return \yii\web\Response
     */
    public function actionClear($logType)
    {
        SecurityLog::deleteAll(['log_type' => $logType]);

        notify()->addSuccess(t('app', 'Your action is complete.'));

        $redirect = SecurityLog::LOG_TYPE_ADMIN_FAILED_LOGIN == $logType ? ['admin-attempts'] : ['customer-attempts'];

        return $this->redirect($redirect);
    }

    /**
     * Finds the SecurityLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param $id
     * @return SecurityLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SecurityLog::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
    }
}