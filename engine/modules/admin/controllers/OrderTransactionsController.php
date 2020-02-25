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

use app\models\OrderTransaction;
use app\models\OrderTransactionSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Controls the actions for orders transactions section
 *
 * @Class OrderTransactionsController
 * @package app\modules\admin\controllers
 */
class OrderTransactionsController extends \app\modules\admin\yii\web\Controller
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
     * Lists all the transactions
     *
     * @return string
     */
    public function actionIndex()
    {

        $searchModel = new OrderTransactionSearch();
        $dataProvider = $searchModel->search(request()->queryParams);
        $dataProvider->pagination->pageSize=10;
        $dataProvider->setSort([
            'defaultOrder' => ['transaction_id'=>SORT_DESC]
        ]);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Orders Transactions'),
            'pageHeading'    => t('app', 'Orders Transactions'),
        ]);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a specific transaction
     *
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Transaction #{transactionName}', ['transactionName'=>$model->transaction_id]),
            'pageHeading'    => t('app', 'Transaction #{transactionName}', ['transactionName'=>$model->transaction_id]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Orders Transactions'), 'url' => ['index']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = OrderTransaction::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
