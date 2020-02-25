<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%mail_account}}".
 *
 * @property int $account_id
 * @property string $account_name
 * @property string $hostname
 * @property string $username
 * @property string $password
 * @property int $port
 * @property string $encryption
 * @property int $timeout
 * @property string $from
 * @property string $reply_to
 * @property string $used_for
 * @property string $created_at
 * @property string $updated_at
 */
class MailAccount extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mail_account}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['account_name', 'hostname', 'username', 'password', 'port', 'from', 'used_for', 'created_at', 'updated_at'], 'required'],
            [['port', 'timeout'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['account_name', 'hostname', 'username', 'password', 'encryption', 'from', 'reply_to', 'used_for'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'account_id' => Yii::t('app', 'Account ID'),
            'account_name' => Yii::t('app', 'Account Name'),
            'hostname' => Yii::t('app', 'Hostname'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'port' => Yii::t('app', 'Port'),
            'encryption' => Yii::t('app', 'Encryption'),
            'timeout' => Yii::t('app', 'Timeout'),
            'from' => Yii::t('app', 'From'),
            'reply_to' => Yii::t('app', 'Reply To'),
            'used_for' => Yii::t('app', 'Used For'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MailAccountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MailAccountQuery(get_called_class());
    }
}
