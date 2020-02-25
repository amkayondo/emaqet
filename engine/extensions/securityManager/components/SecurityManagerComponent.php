<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.3
 */

namespace app\extensions\securityManager\components;

use app\extensions\securityManager\helpers\GeoIpHelper;
use app\extensions\securityManager\models\SecurityBlockedAccess;
use app\extensions\securityManager\models\SecurityLog;
use Yii;
use yii\console\ExitCode;
use yii\db\Expression;
use yii\validators\IpValidator;

/**
 * Class SecurityManagerComponent
 * @package app\extensions\securityManager\components
 */
class SecurityManagerComponent extends \yii\base\Component
{
    /**
     * Creates failed login log
     *
     * @param $loginForm
     * @param $logType
     *
     * @return bool whether the log is saved
     */
    public function logFailedLogin($loginForm, $logType)
    {
        if (!IS_CLI) {
            $userIp = request()->getUserIP();

            $log             = new SecurityLog();
            $log->log_type   = $logType;
            $log->ip_address = $userIp;
            $log->user_agent = request()->userAgent;
            $log->username   = $loginForm->email;
            $log->password   = $loginForm->password;
            if ($userIp) {
                $log->country = GeoIpHelper::getCountry($userIp);
                $log->city    = GeoIpHelper::getCity($userIp);
            }

            return $log->save(false);
        }

        return false;
    }

    /**
     * Checks whether the IP of current user is blocked
     *
     * @return bool whether the IP is in blocked list
     */
    public function isBlocked()
    {
        if (!IS_CLI) {
            $userIp = request()->getUserIP();

            $command    = app()->db->createCommand('SELECT ip_address FROM ' . SecurityBlockedAccess::getTableSchema()->fullName . ' WHERE is_active = 1');
            $blockedIps = $command->queryColumn();

            if (!empty($blockedIps)) {
                $validator = new IpValidator([
                    'subnet' => null,
                ]);
                $validator->setRanges($blockedIps);

                return $validator->validate($userIp);
            }
        }

        return false;
    }

    /**
     * Console command. Check if block is expired and deactivate it in case if needed
     */
    public function deactivateExpiredBlocks()
    {
        $expiredBlocks = SecurityBlockedAccess::find()->where(['is_active' => 1])->andWhere(
            ['<', 'expire', new Expression('NOW()')]
        )->all();

        /** @var SecurityBlockedAccess $block */
        foreach ($expiredBlocks as $block) {
            $block->deactivate();
        }
        echo t('app', "Expired blocks were deactivated.");

        return ExitCode::OK;
    }
}