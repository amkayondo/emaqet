<?php

namespace app\extensions\securityManager\models\auto;

use Yii;

/**
 * This is the model class for table "{{%security_reason}}".
 *
 * @property int    $reason_id
 * @property int    $reason_type
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class SecurityReason extends \app\extensions\securityManager\yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%security_reason}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reason_type', 'description', 'created_at', 'updated_at'], 'required'],
            [['reason_type'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['description'], 'string', 'max' => 130],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reason_id'   => 'Reason ID',
            'reason_type' => 'Reason Type',
            'description' => 'Description',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return SecurityReasonQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SecurityReasonQuery(get_called_class());
    }
}
