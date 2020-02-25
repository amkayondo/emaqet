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
use app\models\ZoneSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Controls the actions for zones section
 *
 * @Class ZonesController
 * @package app\modules\admin\controllers
 */
class ZonesController extends \app\modules\admin\yii\web\Controller
{

    const ZONES_PER_PAGE = 10;

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
     * Lists all zones
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel                        = new ZoneSearch();
        $dataProvider                       = $searchModel->search(request()->queryParams);
        $dataProvider->pagination->pageSize = self::ZONES_PER_PAGE;

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Zones'),
            'pageHeading'    => t('app', 'Zones'),
        ]);

        return $this->render('list', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
        ]);
    }

    /**
     * Displays a specific zone
     *
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Zone {zoneName}', ['zoneName'=>$model->name]),
            'pageHeading'    => t('app', 'Zone {zoneName}', ['zoneName'=>$model->name]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Zones'), 'url' => ['index']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new zone
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Zone();

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Create Zone'),
            'pageHeading'    => t('app', 'Create Zone'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Zones'), 'url' => ['index']] ,
                t('app', 'Create'),
            ],
        ]);

        if ($model->load(request()->post()) && $model->save()) {
            notify()->addSuccess(t('app', 'Your action is complete.'));
            return $this->redirect(['view', 'id' => $model->zone_id]);
        } else {
            return $this->render('form', [
                'action'    => 'create',
                'model'     => $model,
            ]);
        }
    }

    /**
     * Updates a specific zone
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Update {zoneName}', ['zoneName'=>$model->name]),
            'pageHeading'    => t('app', 'Update {zoneName}', ['zoneName'=>$model->name]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Zones'), 'url' => ['index']] ,
                t('app', 'Update'),
            ],
        ]);

        if ($model->load(request()->post()) && $model->save()) {
            notify()->addSuccess(t('app', 'Your action is complete.'));
            return $this->redirect(['view', 'id' => $model->zone_id]);
        } else {
            return $this->render('form', [
                'action'    => 'update',
                'model'     => $model,
            ]);
        }
    }

    /**
     * Deletes a specific zone
     *
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        notify()->addSuccess(t('app', 'Your action is complete.'));

        return $this->redirect(['/admin/zones']);
    }

    /**
     * @param $id
     * @param int $page
     * @return string
     */
    public function actionActivate($id, $page = 1)
    {
        $model =  $this->findModel($id);
        $model->activate();

        $searchModel                        = new ZoneSearch();
        $dataProvider                       = $searchModel->search(request()->queryParams);
        $dataProvider->pagination->pageSize = self::ZONES_PER_PAGE;
        $dataProvider->pagination->page     = $page -1;

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
        $model =  $this->findModel($id);
        $model->deactivate();

        $searchModel                        = new ZoneSearch();
        $dataProvider                       = $searchModel->search(request()->queryParams);
        $dataProvider->pagination->pageSize = self::ZONES_PER_PAGE;
        $dataProvider->pagination->page     = $page -1;

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
        if (($model = Zone::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return \yii\web\Response
     */
    public function actionActivateAll()
    {
        if (Zone::updateAll(['status' => Zone::STATUS_ACTIVE])) {
            notify()->addSuccess(t('app','All Zones has been activated!'));
        }
        else {
            notify()->addError(t('app','Something went wrong!'));
        }
        return $this->redirect(['/admin/zones']);

    }

    /**
     * @return \yii\web\Response
     */
    public function actionDeactivateAll()
    {
        if (Zone::updateAll(['status' => Zone::STATUS_INACTIVE])) {
            notify()->addWarning(t('app','All Zones has been deactivated!'));
        }
        else {
            notify()->addError(t('app','Something went wrong!'));
        }
        return $this->redirect(['/admin/zones']);
    }
}
