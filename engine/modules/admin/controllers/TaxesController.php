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

use app\models\Zone;
use app\models\Tax;
use app\models\TaxSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * Controls the actions for taxes section
 *
 * @Class TaxesController
 * @package app\modules\admin\controllers
 */
class TaxesController extends \app\modules\admin\yii\web\Controller
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
     * Lists all taxes
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TaxSearch();
        $dataProvider = $searchModel->search(request()->queryParams);
        $dataProvider->pagination->pageSize=10;

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Taxes'),
            'pageHeading'    => t('app', 'Taxes'),
        ]);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a specific tax
     *
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Tax {taxName}', ['taxName'=>$model->name]),
            'pageHeading'    => t('app', 'Tax {taxName}', ['taxName'=>$model->name]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Taxes'), 'url' => ['index']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new tax
     *
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new Tax();

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Create Tax'),
            'pageHeading'    => t('app', 'Create Tax'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Taxes'), 'url' => ['index']] ,
                t('app', 'Create'),
            ],
        ]);

        if ($model->load(request()->post()) && $model->save()) {
            notify()->addSuccess(t('app','Your action is complete.'));
            return $this->redirect(['view', 'id' => $model->tax_id]);
        } else {
            return $this->render('form', [
                'action'=> 'create',
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates a specific tax
     *
     * @param $id
     * @return string|Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Update {taxName}', ['taxName'=>$model->name]),
            'pageHeading'    => t('app', 'Update {taxName}', ['taxName'=>$model->name]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Taxes'), 'url' => ['index']] ,
                t('app', 'Update'),
            ],
        ]);

        if ($model->load(request()->post()) && $model->save()) {
            notify()->addSuccess(t('app','Your action is complete.'));
            return $this->redirect(['view', 'id' => $model->tax_id]);
        } else {
            return $this->render('form', [
                'action'=> 'update',
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes a specific tax
     *
     * @param $id
     * @return Response
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        notify()->addSuccess(t('app','Your action is complete.'));

        return $this->redirect(['/admin/taxes']);
    }

    /**
     * Gets a country zones
     *
     * @return array|Response
     */
    public function actionGetCountryZones()
    {
        /* allow only ajax calls */
        if (!request()->isAjax) {
            return $this->redirect(['admin']);
        }

        /* set the output to json */
        response()->format = Response::FORMAT_JSON;

        $countryId = request()->post('country_id');
        if (empty($countryId)) {
            return ['result' => 'error', 'html' => t('app', 'Something went wrong...')];
        }

        $countryZones = Zone::find()->select(['zone_id','name'])->where(['country_id' => (int)$countryId, 'status' => Zone::STATUS_ACTIVE])->all();

        return ['result' => 'success', 'response' => $countryZones];
    }

    /**
     * @param $id
     * @return static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Tax::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
