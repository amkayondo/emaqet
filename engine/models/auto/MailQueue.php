<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%mail_queue}}".
 *
 * @property int $id
 * @property string $subject
 * @property string $swift_message
 * @property int $attempts
 * @property int $message_template_type
 * @property string $last_attempt_time
 * @property string $time_to_send
 * @property string $sent_time
 * @property string $created_at
 */
class MailQueue extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mail_queue}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['swift_message', 'message_template_type', 'created_at'], 'required'],
            [['swift_message'], 'string'],
            [['attempts', 'message_template_type'], 'integer'],
            [['last_attempt_time', 'time_to_send', 'sent_time', 'created_at'], 'safe'],
            [['subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'subject' => Yii::t('app', 'Subject'),
            'swift_message' => Yii::t('app', 'Swift Message'),
            'attempts' => Yii::t('app', 'Attempts'),
            'message_template_type' => Yii::t('app', 'Message Template Type'),
            'last_attempt_time' => Yii::t('app', 'Last Attempt Time'),
            'time_to_send' => Yii::t('app', 'Time To Send'),
            'sent_time' => Yii::t('app', 'Sent Time'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MailQueueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MailQueueQuery(get_called_class());
    }
}
