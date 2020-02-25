<?php

namespace app\extensions\securityManager\models\auto;

use Yii;

/**
 * This is the model class for table "{{%security_blocked_access}}".
 *
 * @property int    $blocked_access_id
 * @property string $ip_address
 * @property string $expire
 * @property int    $is_active
 * @property string $created_at
 */
class SecurityBlockedAccess extends \app\extensions\securityManager\yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%security_blocked_access}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip_address', 'expire', 'created_at'], 'required'],
            [['expire', 'created_at'], 'safe'],
            [['ip_address'], 'string', 'max' => 45],
            [['is_active'], 'string', 'max' => 1],
            [['ip_address', 'is_active'], 'unique', 'targetAttribute' => ['ip_address', 'is_active']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'blocked_access_id' => 'Blocked Access ID',
            'ip_address'        => 'Ip Address',
            'expire'            => 'Expire',
            'is_active'         => 'Is Active',
            'created_at'        => 'Created At',
        ];
    }

    /**
     * @inheritdoc
     * @return SecurityBlockedAccessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SecurityBlockedAccessQuery(get_called_class());
    }
}
