<?php

namespace app\extensions\securityManager\models\auto;

use Yii;

/**
 * This is the model class for table "{{%security_log}}".
 *
 * @property int    $log_id
 * @property int    $log_type
 * @property string $ip_address
 * @property string $user_agent
 * @property string $username
 * @property string $password
 * @property string $country
 * @property string $city
 * @property string $created_at
 */
class SecurityLog extends \app\extensions\securityManager\yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%security_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip_address', 'log_type', 'created_at'], 'required'],
            [['log_type'], 'integer'],
            [['created_at'], 'safe'],
            [['ip_address'], 'string', 'max' => 20],
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
        return [
            'log_id'     => 'Log ID',
            'log_type'   => 'Log Type',
            'ip_address' => 'Ip Address',
            'user_agent' => 'User Agent',
            'username'   => 'Username',
            'password'   => 'Password',
            'country'    => 'Country',
            'city'       => 'City',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @inheritdoc
     * @return SecurityLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SecurityLogQuery(get_called_class());
    }
}
