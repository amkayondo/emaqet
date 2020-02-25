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

use app\models\options\Contact;
use app\models\Page;


/**
 * Controls the actions for settings section
 *
 * @Class ContactController
 * @package app\modules\admin\controllers
 */
class ContactController extends \app\modules\admin\yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * Controls general settings
     *
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $model  = new Contact();
        $page   = new Page();

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Contact Form'),
            'pageHeading'    => t('app', 'Contact'),
        ]);

        if ($model->load(request()->post()) && $model->save()) {
            return $this->refresh();
        } else {
            return $this->render('index', [
                'model' => $model,
                'pageModel' => $page
            ]);
        }
    }

}
