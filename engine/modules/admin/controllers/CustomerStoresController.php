<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.0.1
 */

namespace app\modules\admin\controllers;

use app\models\CustomerStore;
use app\models\CustomerStoreSearch;
use yii\web\NotFoundHttpException;

/**
 * Controls the actions for stores section
 *
 * @Class CustomerStoresController
 * @package app\modules\admin\controllers
 */
class CustomerStoresController extends \app\modules\admin\yii\web\Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {

        $searchModel = new CustomerStoreSearch();
        $dataProvider = $searchModel->search(request()->queryParams);
        $dataProvider->pagination->pageSize=10;

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Stores'),
            'pageHeading'    => t('app', 'Stores'),
        ]);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Store {storeName}', ['storeName'=>$model->store_name]),
            'pageHeading'    => t('app', 'Store {storeName}', ['storeName'=>$model->store_name]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Stores'), 'url' => ['index']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Update {storeName}', ['storeName'=>$model->store_name]),
            'pageHeading'    => t('app', 'Update {storeName}', ['storeName'=>$model->store_name]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Stores'), 'url' => ['index']] ,
                t('app', 'Update'),
            ],
        ]);

        if ($model->load(request()->post()) && $model->save()) {
            notify()->addSuccess(t('app','Your action is complete.'));
            return $this->redirect(['view', 'id' => $model->store_id]);
        } else {
            return $this->render('form', [
                'action'=> 'update',
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $model =  $this->findModel($id);
        $model->delete();
        notify()->addSuccess(t('app','Your action is complete.'));

        return $this->redirect(['/admin/customer-stores']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionActivate($id)
    {
        $model =  $this->findModel($id);
        $model->activate();
        notify()->addSuccess(t('app','Your action is complete.'));

        return $this->redirect(['/admin/customers']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDeactivate($id)
    {
        $model =  $this->findModel($id);
        $model->deactivate();
        notify()->addSuccess(t('app','Your action is complete.'));

        return $this->redirect(['/admin/customers']);
    }

    /**
     * @param $id
     * @return static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = CustomerStore::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
