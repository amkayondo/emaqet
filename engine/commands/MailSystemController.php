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
use Yii;

/**
 * Class MailSystemController
 * @package app\commands
 */
class MailSystemController extends Controller
{

    /**
     * Processing queue of mail messages
     */
    public function actionIndex()
    {
        app()->mailQueue->process();
    }
}
