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

use app\components\mail\template\TemplateType;
use app\models\MailTemplate;
use app\models\MailTemplateSearch;
use app\modules\admin\yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Controls the actions for mail templates section
 *
 * @Class MailTemplatesController
 * @package app\modules\admin\controllers
 */
class MailTemplatesController extends Controller
{
    /**
     * Lists all the templates
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MailTemplateSearch();
        $dataProvider = $searchModel->search(request()->queryParams);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Mail Templates'),
            'pageHeading'    => t('app', 'Mail Templates'),
        ]);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates a specific template
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $templateType = TemplateType::create($model->template_type);
        $vars = $templateType->getVarsList();

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Update Template {templateName}', ['templateName'=>$model->name]),
            'pageHeading'    => t('app', 'Update Template "{templateName}"', ['templateName'=>$model->name]),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Mail Templates'), 'url' => ['index']] ,
                t('app', 'Update'),
            ],
        ]);

        if ($model->load(request()->post()) && $model->save()) {
            notify()->addSuccess(t('app','Your action is complete.'));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'vars'  => $vars,
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
        if (($model = MailTemplate::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
