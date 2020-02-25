<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%category_field}}".
 *
 * @property int $field_id
 * @property int $type_id
 * @property int $category_id
 * @property string $label
 * @property string $unit
 * @property string $default_value
 * @property string $help_text
 * @property string $required
 * @property int $sort_order
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $category
 * @property CategoryFieldType $type
 * @property CategoryFieldOption[] $categoryFieldOptions
 * @property CategoryFieldValue[] $categoryFieldValues
 */
class CategoryField extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%category_field}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'category_id', 'created_at', 'updated_at'], 'required'],
            [['type_id', 'category_id', 'sort_order'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['label', 'default_value', 'help_text'], 'string', 'max' => 255],
            [['unit'], 'string', 'max' => 25],
            [['required'], 'string', 'max' => 3],
            [['status'], 'string', 'max' => 15],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'category_id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryFieldType::className(), 'targetAttribute' => ['type_id' => 'type_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'field_id' => Yii::t('app', 'Field ID'),
            'type_id' => Yii::t('app', 'Type ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'label' => Yii::t('app', 'Label'),
            'unit' => Yii::t('app', 'Unit'),
            'default_value' => Yii::t('app', 'Default Value'),
            'help_text' => Yii::t('app', 'Help Text'),
            'required' => Yii::t('app', 'Required'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(CategoryFieldType::className(), ['type_id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryFieldOptions()
    {
        return $this->hasMany(CategoryFieldOption::className(), ['field_id' => 'field_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryFieldValues()
    {
        return $this->hasMany(CategoryFieldValue::className(), ['field_id' => 'field_id']);
    }

    /**
     * {@inheritdoc}
     * @return CategoryFieldQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryFieldQuery(get_called_class());
    }
}
