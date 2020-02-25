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
 * Class SecurityBannedCustomer
 * @package app\extensions\securityManager\models
 */
class SecurityBannedCustomer extends \app\extensions\securityManager\models\auto\SecurityBannedCustomer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_email', 'ban_reason'], 'required'],
            [['customer_email'], 'string', 'max' => 150],
            [['customer_email'], 'email'],
            [['ban_reason'], 'string', 'max' => 130],
            [['customer_email'], 'unique', 'message' => t('app', "Customer with email '{value}' has already been banned.")],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'customer_email' => t('app', 'Customer Email'),
            'ban_reason'     => t('app', 'Ban Reason'),
            'created_at'     => t('app', 'Created At'),
        ]);
    }
}
