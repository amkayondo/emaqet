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

namespace app\extensions\securityManager\models;

use yii\helpers\ArrayHelper;

/**
 * Class SecurityLog
 * @package app\extensions\securityManager\models
 */
class SecurityLog extends \app\extensions\securityManager\models\auto\SecurityLog
{
    const LOG_TYPE_ADMIN_FAILED_LOGIN    = 1;
    const LOG_TYPE_CUSTOMER_FAILED_LOGIN = 2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['log_type', 'username', 'password'], 'required'],
            [['log_type'], 'integer'],
            [['ip_address'], 'string', 'max' => 40],
            [['user_agent'], 'string', 'max' => 255],
            [['username', 'country', 'city'], 'string', 'max' => 150],
            [['password'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'log_type'   => t('app', 'Log Type'),
            'ip_address' => t('app', 'Ip Address'),
            'username'   => t('app', 'Username'),
            'password'   => t('app', 'Password'),
            'user_agent' => t('app', 'User Agent'),
            'country'    => t('app', 'Country'),
            'city'       => t('app', 'City'),
            'created_at' => t('app', 'Created At'),
        ]);
    }

    /**
     * Get list of types
     *
     * @param null $type
     *
     * @return array|mixed
     */
    public static function getTypesList($type = null)
    {
        $logTypes = [
            self::LOG_TYPE_ADMIN_FAILED_LOGIN    => t('app', 'Failed Login Attempt of Admin'),
            self::LOG_TYPE_CUSTOMER_FAILED_LOGIN => t('app', 'Failed Login Attempt of Customer'),
        ];

        return $type ? $logTypes[$type] : $logTypes;
    }
}
