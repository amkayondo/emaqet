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

namespace app\modules\admin\yii\web;

use app\helpers\FileSystemHelper;
use app\yii\web\Controller as BaseController;
use yii\helpers\Html;

/**
 * Class Controller
 * @package app\yii\web
 */
class Controller extends BaseController
{

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (user()->isGuest) {
            return response()->redirect(url(['/admin']))->send();
        }

        if (!user()->identity->canAccess($this->route)) {
            throw new \yii\web\ForbiddenHttpException(t('app','This action is not allowed!'));
        }

        // Show notification if email accounts are missing
        if (app()->mailSystem->getAccounts() == 0) {
            notify()->addWarning(t('app', 'Important: Email System in missing Email Accounts!'));
            notify()->addWarning(t('app', 'You will need to add at least one account and assign it to templates for the Email System to work properly.') . ' ' . Html::a(t('app','Fix Issue'),url(['/admin/mail-accounts'])));
        }

        // show notification if install folder is present
        $installPath = \Yii::getAlias('@webroot/install');
        if ((file_exists($installPath) || is_dir($installPath)) && !YII_ENV_DOCKER) {
            notify()->addError(t('app', 'Important note: Please remove install folder: {path}',['path' => $installPath]));
        }

        // extensions parser
        $extensions = FileSystemHelper::getDirectoryNames(\Yii::getAlias('@app/extensions'));
        foreach ($extensions as $extension){
            $className = 'app\extensions\\' . $extension . '\\' . ucfirst(strtolower($extension));
            if (class_exists($className)) {
                $instance = new $className();

                // check if ext has update and show message
                $extensionVersion = options()->get('app.extensions.' . $extension . '.version', '');
                if (empty($extensionVersion)) {
                    $extensionVersion = $instance->version;
                    options()->set('app.extensions.' . $extension . '.version', $extensionVersion);
                }
                if (version_compare($instance->version, $extensionVersion, '>')) {
                    notify()->addInfo(t('app', '{extension} extension needs an update, please visit Extensions Manager to update!',
                        ['extension' => $instance->name]
                    ));
                }
            }
        }

        // show notification
        if (options()->get('app.settings.license.message', '') != '') {
            notify()->addError(options()->get('app.settings.license.message', ''));
        }

        // Default language for datepicker
        container()->set('yii\jui\DatePicker',[
           'language' => 'en-GB'
        ]);

        return parent::beforeAction($action);
    }

}
