<?php

namespace app\extensions\securityManager\models\auto;

use Yii;

/**
 * This is the model class for table "{{%security_banned_customer}}".
 *
 * @property int    $banned_customer_id
 * @property string $customer_email
 * @property string $ban_reason
 * @property string $created_at
 */
class SecurityBannedCustomer extends \app\extensions\securityManager\yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%security_banned_customer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_email', 'ban_reason', 'created_at'], 'required'],
            [['created_at'], 'safe'],
            [['customer_email'], 'string', 'max' => 150],
            [['ban_reason'], 'string', 'max' => 130],
            [['customer_email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'banned_customer_id' => 'Banned Customer ID',
            'customer_email'     => 'Customer Email',
            'ban_reason'         => 'Ban Reason',
            'created_at'         => 'Created At',
        ];
    }

    /**
     * @inheritdoc
     * @return SecurityBannedCustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SecurityBannedCustomerQuery(get_called_class());
    }
}
