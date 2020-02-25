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

use app\models\UserForgotForm;
use app\models\UserLoginForm;
use app\models\User;

/**
 * Controls the actions for admin module
 *
 * @Class AdminController
 * @package app\modules\admin\controllers
 */
class AdminController extends \app\yii\web\Controller
{

    /**
     * @var string
     */
    public $layout = 'admin';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['access']);
        return $behaviors;
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
     * Login an admin user
     *
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $model = new UserLoginForm();

        if (app()->user->isGuest == false && app()->user->identity->email != false) {
            return $this->redirect(['dashboard/index']);
        }

        app()->trigger('admin.controllers.adminLogin.beforePerformAction');

        /* if form is submitted */
        if ($model->load(request()->post()) && $model->login()) {
            return $this->redirect(['dashboard/index']);
        }

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Admin Login'),
        ]);

        /* custom body class */
        $this->view->params['bodyClasses'] .= ' login-page';

        /* render the view */
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Forget password for an admin
     *
     * @return string|\yii\web\Response
     */
    public function actionForgot()
    {
        $model = new UserForgotForm();

        /* if form is submitted */
        if ($model->load(request()->post())) {
            if($model->sendEmail()) {
                notify()->addSuccess(t('app', 'Please check your email for confirmation!'));
            }
            return $this->redirect(['admin/index']);
        }

        /* view params */
        $this->setViewParams([
            'pageTitle' => view_param('pageTitle') . ' | ' . t('app', 'Forgot password'),
        ]);

        $this->setViewParams([
            'pageTitle'      => view_param('pageTitle') . ' | ' . t('app', 'Forgot Password'),
        ]);

        /* custom body class */
        $this->view->params['bodyClasses'] .= ' login-page';

        /* render the view */
        return $this->render('forgot', [
            'model' => $model,
        ]);
    }

    /**
     * Reset password action for an admin
     *
     * @param $key
     * @return \yii\web\Response
     */
    public function actionReset_password($key)
    {
        if (!($model = User::findByPasswordResetKey($key))) {
            notify()->addError(t('app', 'Invalid password reset key!'));
            return $this->redirect(['admin/index']);
        }

        $password = security()->generateRandomString(12);
        $model->fake_password = $password;
        $model->password_reset_key = null;
        $model->save(false);

        notify()->addSuccess(t('app', 'Your new password is: {password}', [
            'password' => sprintf('<b>%s</b>', $password),
        ]));

        return $this->redirect(['admin/index']);
    }

    /**
     * Logout action
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        user()->logout();
        return $this->redirect(user()->loginUrl);
    }
}
