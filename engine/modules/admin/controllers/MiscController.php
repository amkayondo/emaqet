<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.4
 */

namespace app\modules\admin\controllers;
use app\helpers\CommonHelper;

/**
 * Controls the actions for Misc section
 *
 * @Class MiscController
 * @package app\modules\admin\controllers
 */
class MiscController extends \app\modules\admin\yii\web\Controller
{

    /**
     * @return string
     */
    public function actionIndex()
    {
        if (request()->getQueryString('show')) {
            if (CommonHelper::functionExists('phpinfo')) {
                phpinfo();
            }
            exit;
        }

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'PHP Info'),
            'pageHeading'    => t('app', 'PHP Info'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'PHP Info'), 'url' => ['index']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('index', []);
    }

    /**
     * @return string
     */
    public function actionCron()
    {
        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Cron Jobs'),
            'pageHeading'    => t('app', 'Cron Jobs'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'Cron Jobs'), 'url' => ['index']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('cron', []);
    }

    /**
     * @return string
     */
    public function actionChangelog()
    {
        $changelog = '';
        if (is_file($file = get_alias('@webroot/CHANGELOG'))) {
            $changelog = file_get_contents($file);
        }

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'ChangeLog'),
            'pageHeading'    => t('app', 'ChangeLog'),
            'pageBreadcrumbs'=> [
                ['label' => t('app', 'ChangeLog'), 'url' => ['index']] ,
                t('app', 'View'),
            ],
        ]);

        return $this->render('changelog', [
            'changelog' => $changelog
        ]);
    }
}
