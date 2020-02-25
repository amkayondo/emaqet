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

use app\models\GroupRouteAccess;
use app\models\UserSearch;
use app\models\Group;
use app\models\GroupSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Controls the actions for groups section
 *
 * @Class GroupsController
 * @package app\modules\admin\controllers
 */
class GroupsController extends \app\modules\admin\yii\web\Controller
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
     * Lists all groups
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new GroupSearch();
        $dataProvider = $searchModel->search(request()->queryParams);
        $dataProvider->pagination->pageSize=10;

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Groups'),
            'pageHeading'    => t('app', 'Groups'),
        ]);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a specific group
     *
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $searchModel = new UserSearch(['group_id'=>$id]);
        $dataProvider = $searchModel->search(request()->queryParams);
        $dataProvider->pagination->pageSize=10;

        $model = $this->findModel($id);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Group {groupName}', ['groupName'=>$model->name]),
            'pageHeading'    => t('app', 'Group {groupName}', ['groupName'=>$model->name]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Groups'), 'url' => ['index']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new group
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Group();
        $routesAccess = $model->getAllRoutesAccess();

        if ($model->load(request()->post())) {
            $transaction = db()->beginTransaction();

            $error = false;
            try {

                if (!$model->save()) {
                    throw new \Exception(t('app', 'Your form has a few errors, please fix them and try again!'));
                }

                $routes = request()->post('GroupRouteAccess',[]);
                foreach ($routes as $routeName=>$access) {
                    $route = new GroupRouteAccess();
                    $route->group_id = $model->group_id;
                    $route->route = $routeName;
                    $route->access = $access;
                    $route->save();
                }
                $transaction->commit();

            } catch (\Exception $e) {

                $error = true;
                $transaction->rollBack();

            }

            if (!$error) {
                notify()->addSuccess(t('app','Your action is complete.'));
                return $this->redirect(['view', 'id' => $model->group_id]);
            }
        }

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Create Group'),
            'pageHeading'    => t('app', 'Create Group'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Groups'), 'url' => ['index']] ,
                t('app', 'Create'),
            ],
        ]);

        return $this->render('form', [
            'action'=> 'create',
            'model' => $model,
            'routesAccess' => $routesAccess,
        ]);
    }

    /**
     * Updates a specific group
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $routesAccess = $model->getAllRoutesAccess();

        if ($model->load(request()->post())) {
            $transaction = db()->beginTransaction();

            $error = false;
            try {

                if (!$model->save()) {
                    throw new \Exception(t('app', 'Your form has a few errors, please fix them and try again!'));
                }

                if ($routes = request()->post('GroupRouteAccess',[])) {
                    foreach ($routesAccess as $key => $value) {
                        foreach ($value['routes'] as $route) {
                            $route->group_id = $model->group_id;
                            $route->access   = GroupRouteAccess::ALLOW;
                            if (isset($routes[$route->route])) {
                                if ($model->group_id != 1) {
                                    $route->access = $routes[$route->route];
                                } else {
                                    throw new \Exception(t('app','Access for this group can not be modified!'));
                                }
                            }
                            $route->save();
                        }
                    }
                }
                $transaction->commit();

            } catch (\Exception $e) {

                $error = true;
                $transaction->rollBack();
                notify()->addError($e->getMessage());

            }

            if (!$error) {
                notify()->addSuccess(t('app','Your action is complete.'));
                return $this->redirect(['view', 'id' => $model->group_id]);
            }
        }

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Update {groupName}', ['groupName'=>$model->name]),
            'pageHeading'    => t('app', 'Update {groupName}', ['groupName'=>$model->name]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Groups'), 'url' => ['index']] ,
                t('app', 'Update'),
            ],
        ]);

        return $this->render('form', [
            'action'=> 'update',
            'model' => $model,
            'routesAccess' => $routesAccess,
        ]);
    }

    /**
     * Deletes a specific group
     *
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($id == 1) {
            throw new \yii\web\ForbiddenHttpException(t('app','This action is not allowed!'));
        }

        $model->delete();

        notify()->addSuccess(t('app','Your action is complete.'));

        return $this->redirect(['/admin/groups']);
    }

    /**
     * @param $id
     * @return static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
