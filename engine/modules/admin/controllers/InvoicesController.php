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

use app\models\Invoice;
use app\models\InvoiceSearch;
use app\modules\admin\yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Controls the actions for invoices section
 *
 * @Class InvoicesController
 * @package app\modules\admin\controllers
 */
class InvoicesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all the invoices
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(request()->queryParams);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Invoices'),
            'pageHeading'    => t('app', 'Invoices'),
        ]);

        return $this->render('list', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Generates a specific invoice as PDF
     *
     * @param $id
     * @return mixed
     */
    public function actionGeneratePdf($id)
    {
        return app()->generateInvoicePdf->generate($id);
    }

    /**
     * Sends a specific invoice
     *
     * @param $id
     * @return \yii\web\Response
     */
    public function actionSendInvoice($id)
    {
        if (app()->sendInvoice->send($id)) {
            notify()->addSuccess(t('app', 'Invoice was sent successfully!'));
        } else {
            notify()->addError(t('app', 'Something went wrong!'));
        }

        return $this->redirect(['invoices/index']);
    }

    /**
     * @param $id
     * @return static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
