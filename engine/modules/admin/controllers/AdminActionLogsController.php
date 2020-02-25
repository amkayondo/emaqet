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

use app\models\AdminActionLogSearch;
use app\modules\admin\yii\web\Controller;
use app\models\AdminActionLog;
use yii\web\NotFoundHttpException;

/**
 * Controls the actions for admin action logs section
 *
 * @Class AdminActionLogsController
 * @package app\modules\admin\controllers
 */
class AdminActionLogsController extends Controller
{
    /**
     * Lists all Admin logs
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminActionLogSearch();
        $dataProvider = $searchModel->search(request()->queryParams);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Admin Action Logs'),
            'pageHeading'    => t('app', 'Admin Action Logs'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Admin Action logs'), 'url' => ['index']] ,
            ],
        ]);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     *  View a specific Admin log
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Admin Action Logs'),
            'pageHeading'    => t('app', 'Details'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Admin Action logs'), 'url' => ['index']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes all logs
     *
     * @return \yii\web\Response
     */
    public function actionClear()
    {
        AdminActionLog::deleteAll();

        notify()->addSuccess(t('app','Your action is complete'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the AdminActionLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminActionLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdminActionLog::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
