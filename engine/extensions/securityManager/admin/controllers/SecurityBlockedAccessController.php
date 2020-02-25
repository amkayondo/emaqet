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
use app\extensions\securityManager\models\SecurityBlockedAccessSearch;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\bootstrap\ActiveForm;

/**
 * Class SecurityBlockedAccessController
 * @package app\extensions\securityManager\admin\controllers
 */
class SecurityBlockedAccessController extends \app\modules\admin\yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\AjaxFilter',
                'only'  => ['block-access', 'validate-block-access'],
            ],
        ];
    }

    /**
     * Shows list of security logs of admin attempts
     *
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $model        = new SecurityBlockedAccess();
        $searchModel  = new SecurityBlockedAccessSearch();
        $dataProvider = $searchModel->search(request()->queryParams);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Create Block Access'),
            'pageHeading'    => t('app', 'Create Block Access'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Extensions'), 'url' => ['/admin/extensions']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('@app/extensions/securityManager/admin/views/blocked-access/list', [
            'model'        => $model,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Delete all logs by type
     *
     * @return \yii\web\Response
     */
    public function actionClear()
    {
        SecurityBlockedAccess::deleteAll();

        notify()->addSuccess(t('app', 'Your action is complete.'));

        return $this->redirect(['index']);
    }

    /**
     * Block access by IP address for the period
     *
     * @return array \yii\web\Response::FORMAT_JSON
     */
    public function actionBlockAccess()
    {
        app()->response->format        = Response::FORMAT_JSON;
        $result                        = ['isSuccess' => '', 'message' => ''];
        $blockedAccessModel            = new SecurityBlockedAccess();
        $blockedAccessModel->is_active = 1;

        if ($blockedAccessModel->load(request()->post()) && $blockedAccessModel->validate()) {
            $expireDate = new \DateTime();
            $expireDate->modify("+ $blockedAccessModel->expiredPeriod day");
            $blockedAccessModel->expire = $expireDate->format('Y-m-d H:i:s');

            if ($blockedAccessModel->save(false)) {
                $result['isSuccess'] = true;
                $result['message']   = t('app', 'Your action is complete.');
            } else {
                $result['isSuccess'] = false;
                $result['message']   = t('app', 'Something went wrong.');
            }
        }

        return $result;
    }

    /**
     * Validates block access model by ajax
     *
     * @return array
     */
    public function actionValidateBlockAccess()
    {
        app()->response->format = Response::FORMAT_JSON;

        $blockedAccessModel            = new SecurityBlockedAccess();
        $blockedAccessModel->is_active = 1;

        if ($blockedAccessModel->load(request()->post())) {
            return ActiveForm::validate($blockedAccessModel);
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
        $this->findModel($id)->delete();

        notify()->addSuccess(t('app', 'Your action is complete.'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the SecurityBlockedAccess model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param $id
     * @return SecurityBlockedAccess the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SecurityBlockedAccess::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
    }
}