<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $user_id
 * @property string $user_uid
 * @property int $group_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 * @property string $password_reset_key
 * @property string $timezone
 * @property string $avatar
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AdminActionLog[] $adminActionLogs
 * @property Group $group
 */
class User extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_id'], 'integer'],
            [['created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_uid'], 'string', 'max' => 13],
            [['first_name', 'last_name'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 150],
            [['password', 'auth_key', 'access_token'], 'string', 'max' => 64],
            [['password_reset_key'], 'string', 'max' => 32],
            [['timezone'], 'string', 'max' => 50],
            [['avatar'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::className(), 'targetAttribute' => ['group_id' => 'group_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'user_uid' => Yii::t('app', 'User Uid'),
            'group_id' => Yii::t('app', 'Group ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'access_token' => Yii::t('app', 'Access Token'),
            'password_reset_key' => Yii::t('app', 'Password Reset Key'),
            'timezone' => Yii::t('app', 'Timezone'),
            'avatar' => Yii::t('app', 'Avatar'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminActionLogs()
    {
        return $this->hasMany(AdminActionLog::className(), ['changed_by' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['group_id' => 'group_id']);
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
