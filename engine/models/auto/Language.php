<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%language}}".
 *
 * @property int $language_id
 * @property string $name
 * @property string $language_code
 * @property string $region_code
 * @property string $is_default
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Language extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%language}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['language_code', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['language_code', 'region_code'], 'string', 'max' => 2],
            [['is_default'], 'string', 'max' => 3],
            [['status'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'language_id' => Yii::t('app', 'Language ID'),
            'name' => Yii::t('app', 'Name'),
            'language_code' => Yii::t('app', 'Language Code'),
            'region_code' => Yii::t('app', 'Region Code'),
            'is_default' => Yii::t('app', 'Is Default'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return LanguageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LanguageQuery(get_called_class());
    }
}
