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

use app\extensions\securityManager\models\SecurityInappropriateReport;
use app\extensions\securityManager\models\SecurityInappropriateReportSearch;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * Class SecurityInappropriateReportController
 * @package app\extensions\securityManager\admin\controllers
 */
class SecurityInappropriateReportController extends \app\modules\admin\yii\web\Controller
{
    /**
     * Shows list of inappropriate reports
     *
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $searchModel  = new SecurityInappropriateReportSearch();
        $dataProvider = $searchModel->search(request()->queryParams);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Inappropriate Reports'),
            'pageHeading'    => t('app', 'Inappropriate Reports'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Extensions'), 'url' => ['/admin/extensions']] ,
                t('app', 'List'),
            ],
        ]);

        return $this->render('@app/extensions/securityManager/admin/views/inappropriate-report/list', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
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
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Inappropriate report on ad {itemName}', ['itemName'=>$model->ad->title]),
            'pageHeading'    => t('app', 'Inappropriate report on ad "{itemName}"', ['itemName'=>$model->ad->title]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Extensions'), 'url' => ['/admin/extensions']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('@app/extensions/securityManager/admin/views/inappropriate-report/view', [
            'action' => 'view',
            'model'  => $model,
        ]);
    }

    /**
     * Updates inappropriate report
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(request()->post()) && $model->save(false)) {
            notify()->addSuccess(t('app', 'Your action is complete.'));

            return $this->redirect(['view', 'id' => $model->inappropriate_report_id]);
        } else {
            // set current report in editing state to avoid changing by few users
            if (SecurityInappropriateReport::STATUS_PENDING == $model->status) {
                $model->status     = SecurityInappropriateReport::STATUS_IN_PROGRESS;
                $model->updated_by = app()->user->identity->getFullName();
                if ($model->save(false)) {
                    $model->refresh();
                }
            }

            $this->setViewParams([
                'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Update Inappropriate report on ad {itemName}', ['itemName'=>$model->ad->title]),
                'pageHeading'    => t('app', 'Update Inappropriate report on ad "{itemName}"', ['itemName'=>$model->ad->title]),
                'pageBreadcrumbs'=> [
                    ['label' => t('app', 'Extensions'), 'url' => ['/admin/extensions']] ,
                    t('app', 'Update'),
                ],
            ]);

            return $this->render('@app/extensions/securityManager/admin/views/inappropriate-report/view', [
                'action' => 'update',
                'model'  => $model,
            ]);
        }
    }

    /**
     * Finds the SecurityInappropriateReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param $id
     * @return SecurityInappropriateReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SecurityInappropriateReport::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
    }
}