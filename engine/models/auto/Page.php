<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property int $page_id
 * @property string $title
 * @property string $slug
 * @property string $external_url
 * @property string $keywords
 * @property string $description
 * @property string $content
 * @property int $section
 * @property int $sort_order
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Page extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'slug', 'content', 'created_at', 'updated_at'], 'required'],
            [['content'], 'string'],
            [['section', 'sort_order'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 80],
            [['slug'], 'string', 'max' => 110],
            [['external_url'], 'string', 'max' => 255],
            [['keywords'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 160],
            [['status'], 'string', 'max' => 20],
            [['slug'], 'unique'],
            [['section', 'sort_order'], 'unique', 'targetAttribute' => ['section', 'sort_order']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'page_id' => 'Page ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'external_url' => 'External Url',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'content' => 'Content',
            'section' => 'Section',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }
}
