<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%category_field_type}}".
 *
 * @property int $type_id
 * @property string $name
 * @property string $class_name
 * @property string $description
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CategoryField[] $categoryFields
 */
class CategoryFieldType extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%category_field_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'class_name', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['class_name', 'description'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'type_id' => Yii::t('app', 'Type ID'),
            'name' => Yii::t('app', 'Name'),
            'class_name' => Yii::t('app', 'Class Name'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryFields()
    {
        return $this->hasMany(CategoryField::className(), ['type_id' => 'type_id']);
    }

    /**
     * {@inheritdoc}
     * @return CategoryFieldTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryFieldTypeQuery(get_called_class());
    }
}
