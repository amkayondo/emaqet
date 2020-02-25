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

use Yii;
use app\models\MailQueue;
use app\models\MailQueueSearch;
use app\modules\admin\yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Controls the actions for mail queue section
 *
 * @Class MailQueueController
 * @package app\modules\admin\controllers
 */
class MailQueueController extends Controller
{
    /**
     * Lists all the items in the queue
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MailQueueSearch();
        $dataProvider = $searchModel->search(request()->queryParams);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Mail Queue'),
            'pageHeading'    => t('app', 'Mail Queue'),
        ]);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Send manually queue
     */
    public function actionSendMail()
    {
        if (app()->mailQueue->process()) {
          notify()->addSuccess(t('app', 'Queue messages were successfully sent!'));
        } else {
            notify()->addError(t('app', 'Something went wrong, Queue messages encouraged a problem while sending!'));
        }
        return $this->redirect(['/admin/mail-queue']);
    }

    /**
     * Delete manually queue
     */
    public function actionDeleteAll()
    {
        if (MailQueue::deleteAll()) {
            notify()->addSuccess(t('app','Queue messages were successfully deleted!'));
        }
        else {
            notify()->addError(t('app','Something went wrong, No messages in the Queue or Queue messages encouraged a problem while deleting!'));
        }
        return $this->redirect(['/admin/mail-queue']);
    }


}
