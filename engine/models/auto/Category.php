<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $category_id
 * @property int $parent_id
 * @property string $name
 * @property string $slug
 * @property string $icon
 * @property string $description
 * @property int $sort_order
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $parent
 * @property Category[] $categories
 * @property CategoryField[] $categoryFields
 * @property Listing[] $listings
 */
class Category extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort_order'], 'integer'],
            [['name', 'slug', 'sort_order', 'created_at', 'updated_at'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['slug'], 'string', 'max' => 110],
            [['icon'], 'string', 'max' => 20],
            [['meta_keywords'], 'string', 'max' => 160],
            [['meta_description'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
            [['slug'], 'unique'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_id' => 'category_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_id' => Yii::t('app', 'Category ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'icon' => Yii::t('app', 'Icon'),
            'description' => Yii::t('app', 'Description'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['category_id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryFields()
    {
        return $this->hasMany(CategoryField::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings()
    {
        return $this->hasMany(Listing::className(), ['category_id' => 'category_id']);
    }

    /**
     * {@inheritdoc}
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
}
