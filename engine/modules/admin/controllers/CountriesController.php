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

use app\models\Country;
use app\models\CountrySearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Controls the actions for countries section
 *
 * @Class CountriesController
 * @package app\modules\admin\controllers
 */
class CountriesController extends \app\modules\admin\yii\web\Controller
{

    const COUNTRIES_PER_PAGE = 10;

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
     * Lists all countries
     *
     * @return string
     */
    public function actionIndex()
    {

        $searchModel                        = new CountrySearch();
        $dataProvider                       = $searchModel->search(request()->queryParams);
        $dataProvider->pagination->pageSize = self::COUNTRIES_PER_PAGE;

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Countries'),
            'pageHeading'    => t('app', 'Countries'),
        ]);

        return $this->render('list', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
        ]);
    }

    /**
     * Displays a specific country
     *
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Country {countryName}', ['countryName'=>$model->name]),
            'pageHeading'    => t('app', 'Country {countryName}', ['countryName'=>$model->name]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Countries'), 'url' => ['index']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new country entry
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Country();

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Create Country'),
            'pageHeading'    => t('app', 'Create Country'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Countries'), 'url' => ['index']] ,
                t('app', 'Create'),
            ],
        ]);

        if ($model->load(request()->post()) && $model->save()) {
            notify()->addSuccess(t('app','Your action is complete.'));
            return $this->redirect(['view', 'id' => $model->country_id]);
        } else {
            return $this->render('form', [
                'action'=> 'create',
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates a specific country
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Update {countryName}', ['countryName'=>$model->name]),
            'pageHeading'    => t('app', 'Update {countryName}', ['countryName'=>$model->name]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Countries'), 'url' => ['index']] ,
                t('app', 'Update'),
            ],
        ]);

        if ($model->load(request()->post()) && $model->save()) {
            notify()->addSuccess(t('app','Your action is complete.'));
            return $this->redirect(['view', 'id' => $model->country_id]);
        } else {
            return $this->render('form', [
                'action'=> 'update',
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes a specific country
     *
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        notify()->addSuccess(t('app','Your action is complete.'));

        return $this->redirect(['/admin/countries']);
    }

    /**
     * @param $id
     * @param int $page
     * @return string
     */

    public function actionActivate($id, $page = 1)
    {
        $model =   $this->findModel($id);
        $model->activate();

        $searchModel                        = new CountrySearch();
        $dataProvider                       = $searchModel->search(request()->queryParams);
        $dataProvider->pagination->pageSize = self::COUNTRIES_PER_PAGE;
        $dataProvider->pagination->page     = $page - 1;

        return $this->render('list', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @param int $page
     * @return string
     */
    public function actionDeactivate($id, $page = 1)
    {
        $model =   $this->findModel($id);
        $model->deactivate();

        $searchModel                        = new CountrySearch();
        $dataProvider                       = $searchModel->search(request()->queryParams);
        $dataProvider->pagination->pageSize = self::COUNTRIES_PER_PAGE;
        $dataProvider->pagination->page     = $page - 1;

        return $this->render('list', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Country::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return \yii\web\Response
     */
    public function actionActivateAll()
    {
        if (Country::updateAll(['status' => Country::STATUS_ACTIVE])) {
            notify()->addSuccess(t('app','All Countries has been activated!'));
        }
        else {
            notify()->addError(t('app','Something went wrong!'));
        }
        return $this->redirect(['/admin/countries']);

    }

    /**
     * @return \yii\web\Response
     */
    public function actionDeactivateAll()
    {
        if (Country::updateAll(['status' => Country::STATUS_INACTIVE])) {
            notify()->addWarning(t('app','All Countries has been deactivated!'));
        }
        else {
            notify()->addError(t('app','Something went wrong!'));
        }
        return $this->redirect(['/admin/countries']);
    }
}
