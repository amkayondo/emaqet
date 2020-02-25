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

use app\models\ListingPackage;
use app\models\ListingPackageSearch;
use yii\web\NotFoundHttpException;

/**
 * Controls the actions for ad packages section
 *
 * @Class AdsPackagesController
 * @package app\modules\admin\controllers
 */
class ListingsPackagesController extends \app\modules\admin\yii\web\Controller
{

    /**
     * Lists all packages
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ListingPackageSearch();
        $dataProvider = $searchModel->search(request()->queryParams);
        $dataProvider->pagination->pageSize=10;

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Listings Packages'),
            'pageHeading'    => t('app', 'Listings Packages'),
        ]);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a specific package
     *
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Listing Package {packageName}', ['packageName'=>$model->title]),
            'pageHeading'    => t('app', 'Listing Package {packageName}', ['packageName'=>$model->title]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Listings Packages'), 'url' => ['index']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new package to be used for new ads
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ListingPackage();

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Create Package'),
            'pageHeading'    => t('app', 'Create Package'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Listings Packages'), 'url' => ['index']] ,
                t('app', 'Create'),
            ],
        ]);

        if ($model->load(request()->post()) && $model->save()) {
            notify()->addSuccess(t('app','Your action is complete.'));
            return $this->redirect(['view', 'id' => $model->package_id]);
        } else {
            return $this->render('form', [
                'action'=> 'create',
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates a specific ad package
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Update {packageName}', ['packageName'=>$model->title]),
            'pageHeading'    => t('app', 'Package Info'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Listings Packages'), 'url' => ['index']] ,
                t('app', 'Update {packageName} Package', ['packageName'=>$model->title]),
            ],
        ]);

        if ($model->load(request()->post()) && $model->save()) {
            notify()->addSuccess(t('app','Your action is complete.'));
            return $this->redirect(['view', 'id' => $model->package_id]);
        } else {
            return $this->render('form', [
                'action'=> 'update',
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes a specific ad package
     *
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        notify()->addSuccess(t('app','Your action is complete.'));
        return $this->redirect(['/admin/listings-packages']);
    }

    /**
     * @param $id
     * @return static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = ListingPackage::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
