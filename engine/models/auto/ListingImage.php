<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%listing_image}}".
 *
 * @property int $image_id
 * @property int $listing_id
 * @property string $image_form_key
 * @property string $image_path
 * @property int $sort_order
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Listing $listing
 */
class ListingImage extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%listing_image}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['listing_id', 'sort_order'], 'integer'],
            [['created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['image_form_key'], 'string', 'max' => 8],
            [['image_path'], 'string', 'max' => 255],
            [['listing_id'], 'exist', 'skipOnError' => true, 'targetClass' => Listing::className(), 'targetAttribute' => ['listing_id' => 'listing_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'image_id' => Yii::t('app', 'Image ID'),
            'listing_id' => Yii::t('app', 'Listing ID'),
            'image_form_key' => Yii::t('app', 'Image Form Key'),
            'image_path' => Yii::t('app', 'Image Path'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListing()
    {
        return $this->hasOne(Listing::className(), ['listing_id' => 'listing_id']);
    }

    /**
     * {@inheritdoc}
     * @return ListingImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ListingImageQuery(get_called_class());
    }
}
