<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%mail_template}}".
 *
 * @property int $template_id
 * @property int $template_type
 * @property string $name
 * @property string $slug
 * @property string $subject
 * @property int $isPlainContent
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 */
class MailTemplate extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mail_template}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['template_type', 'name', 'slug', 'subject', 'content', 'created_at', 'updated_at'], 'required'],
            [['template_type', 'isPlainContent'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug', 'subject'], 'string', 'max' => 80],
            [['name'], 'unique'],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'template_id' => Yii::t('app', 'Template ID'),
            'template_type' => Yii::t('app', 'Template Type'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'subject' => Yii::t('app', 'Subject'),
            'isPlainContent' => Yii::t('app', 'Is Plain Content'),
            'content' => Yii::t('app', 'Content'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MailTemplateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MailTemplateQuery(get_called_class());
    }
}
