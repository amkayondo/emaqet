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

namespace app\controllers;

use app\models\Page;
use yii\filters\VerbFilter;
use app\yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class PagesController
 * @package app\controllers
 */
class PagesController extends Controller
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
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays static page.
     *
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionIndex($slug)
    {
        $page = $this->findPageBySlug($slug);

        // show inactive pages just for admin
        if (app()->user->isGuest && $page->status == Page::STATUS_INACTIVE) {
            throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
        }

        $this->setViewParams([
            'pageTitle'                 => $page->title . ' - ' . '{siteName}',
            'pageMetaDescription'       => isset($page->description) ? $page->description : 'Default',
            'pageMetaKeywords'          => isset($page->keywords) ? $page->keywords : 'Default'
        ]);

        return $this->render('index', ['page' => $page]);
    }

    /**
     * Find static page by unique slug
     *
     * @param $slug
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findPageBySlug($slug)
    {
        if (($page = Page::findOne(['slug' => $slug])) !== null) {
            return $page;
        }
        throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
    }
}