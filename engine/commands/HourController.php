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
use \app\yii\base\Event;
use yii\console\ExitCode;

/**
 * This command is for hour cron
 *
 * Class HourController
 * @package app\commands
 */
class HourController extends Controller
{

    public function actionIndex()
    {
        $mutexKey = __METHOD__;

        // make sure we only allow a single access from now onwards /
        if (!app()->mutex->acquire($mutexKey)) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        app()->trigger('console.command.hour.start', new Event([
            'params' => [
                'controller' => $this
            ]
        ]));

//        app()->consoleRunner->run('command-controller/index');

        app()->trigger('console.command.hour.end', new Event([
            'params' => [
                'controller' => $this
            ]
        ]));

        // release the mutex /
        app()->mutex->release($mutexKey);
        return ExitCode::OK;
    }
}
