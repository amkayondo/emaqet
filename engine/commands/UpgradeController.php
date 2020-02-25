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

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use twisted1919\helpers\FileHelper;

/**
 * Class UpgradeController
 * @package app\commands
 */
class UpgradeController extends Controller
{
    /**
     * @var int
     */
    public $interactive = 1;

    /**
     * The command entry point
     */
    public function actionIndex()
    {
        /* if called from auto-update from same process */
        $latestVersion = defined('APP_AUTOUPDATE_VERSION') ? APP_AUTOUPDATE_VERSION : APP_VERSION;

        $version = options()->get('app.data.version', '1.0');
        if (version_compare($version, $latestVersion, '>=')) {
            /* inform about the action */
            $this->stdout(t('app', 'You are already at the latest version!') . "\n");
            return ExitCode::UNSPECIFIED_ERROR;
        }

        /* get the migration object */
        $migration = app()->migration;

        /* only if running in interactive mode */
        if ($this->interactive) {

            /* if the update process is initialised */
            $confirm = $this->confirm(t('app', 'Are you sure you want to upgrade the application from version {v1} to {v2}?', [
                    'v1' => $version,
                    'v2' => $latestVersion,
                ]) . "\n");

            if (!$confirm) {
                return ExitCode::UNSPECIFIED_ERROR;
            }
        }

        /* apply all the migrations */
        $migration->up(0);

        /* stop on error and print why */
        if ($migration->error) {

            $this->stderr(t('app', 'The upgrade failed with following message:') . "\n", Console::FG_RED, Console::UNDERLINE);
            $this->stdout($migration->error . "\n");

            $this->stderr(t('app', 'Here is a transcript of the process:') . "\n", Console::FG_RED, Console::UNDERLINE);
            $this->stdout($migration->output . "\n");

            return ExitCode::UNSPECIFIED_ERROR;

        }

        /* set the new application version */
        options()->set('app.data.version', $latestVersion);

        /* flush the caches */
        cache()->flush();


        if (!YII_ENV_DOCKER) {
            /* empty the assets cache */
            FileHelper::deleteDirectoryContents(realpath(\Yii::getAlias('@app/../assets/cache')));

            /* empty the assets twig cache */
            FileHelper::deleteDirectoryContents(\Yii::getAlias('@webroot/assets/twig/cache'), true);
        }

        /* put back the .gitignore file */
        $gitignore = file_get_contents(\Yii::getAlias('@app/data/gitignore-all-but-it.txt'));
        file_put_contents(\Yii::getAlias('@app/runtime/.gitignore'), $gitignore);
        file_put_contents(realpath(\Yii::getAlias('@app/../assets/cache/.gitignore')), $gitignore);

        /* inform about the action */
        $this->stdout(t('app', 'Congratulations, your application has been successfully upgraded to version {version}', [
                'version' => '<span class="badge">' . $latestVersion . '</span>',
            ]) . "\n");

        return ExitCode::OK;
    }
}
