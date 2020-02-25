<?php

namespace app\extensions\securityManager\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Class SecurityBlockedAccess
 * @package app\extensions\securityManager\models
 */
class SecurityBlockedAccess extends \app\extensions\securityManager\models\auto\SecurityBlockedAccess
{
    /**
     * @var int count of days through which block expires
     */
    public $expiredPeriod;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip_address', 'expiredPeriod'], 'required'],
            [['expire'], 'safe'],
            [['ip_address'], 'string', 'max' => 45],
            ['ip_address', 'ip', 'subnet' => null],
            [['is_active'], 'boolean'],
            ['expiredPeriod', 'integer', 'min' => 1, 'max' => 9999],
            [['ip_address', 'is_active'], 'unique', 'targetAttribute' => ['ip_address', 'is_active'], 'message' => t('app', "IP address '{value}' is already blocked. You're able to check that at <a href='{url}' target='_blank'>Blocked IP Access</a> page.", ['url' => Url::to('/admin/security-blocked-access/index')])],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'ip_address'    => t('app', 'Ip Address'),
            'expire'        => t('app', 'Expire'),
            'is_active'     => t('app', 'Is Active'),
            'created_at'    => t('app', 'Created At'),
            'expiredPeriod' => t('app', 'Expired Period'),
        ]);
    }

    /**
     * Deactivate block by IP
     *
     * @return bool
     */
    public function deactivate()
    {
        if ($this->is_active) {
            $this->is_active = 0;

            return $this->save(false);
        }

        return true;
    }
}
