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

use app\models\Order;
use app\models\OrderSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Controls the actions for orders section
 *
 * @Class OrdersController
 * @package app\modules\admin\controllers
 */
class OrdersController extends \app\modules\admin\yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all the orders
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(request()->queryParams);
        $dataProvider->pagination->pageSize=10;
        $dataProvider->setSort([
            'defaultOrder' => ['order_id'=>SORT_DESC]
        ]);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Orders'),
            'pageHeading'    => t('app', 'Orders'),
        ]);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a specific order
     *
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Order #{orderName}', ['orderName'=>$model->order_id]),
            'pageHeading'    => t('app', 'Order #{orderName}', ['orderName'=>$model->order_id]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Orders'), 'url' => ['index']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Updates a specific order
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Update Order #{orderName}', ['orderName'=>$model->order_id]),
            'pageHeading'    => t('app', 'Update Order #{orderName}', ['orderName'=>$model->order_id]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Orders'), 'url' => ['index']] ,
                t('app', 'Update'),
            ],
        ]);

        if ($model->load(request()->post()) && $model->save()) {
            notify()->addSuccess(t('app','Your action is complete.'));
            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('form', [
                'action'=> 'update',
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
