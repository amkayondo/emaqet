<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%listing_package}}".
 *
 * @property int $package_id
 * @property string $title
 * @property int $price
 * @property int $listing_days
 * @property int $promo_days
 * @property string $promo_label_background_color
 * @property string $promo_label_text_color
 * @property string $promo_label_text
 * @property string $promo_sign
 * @property string $recommended_sign
 * @property int $auto_renewal
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Listing[] $listings
 */
class ListingPackage extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%listing_package}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'listing_days', 'promo_days', 'auto_renewal'], 'integer'],
            [['created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['promo_label_background_color', 'promo_label_text_color', 'promo_label_text'], 'string', 'max' => 25],
            [['promo_sign', 'recommended_sign'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'package_id' => Yii::t('app', 'Package ID'),
            'title' => Yii::t('app', 'Title'),
            'price' => Yii::t('app', 'Price'),
            'listing_days' => Yii::t('app', 'Listing Days'),
            'promo_days' => Yii::t('app', 'Promo Days'),
            'promo_label_background_color' => Yii::t('app', 'Promo Label Background Color'),
            'promo_label_text_color' => Yii::t('app', 'Promo Label Text Color'),
            'promo_label_text' => Yii::t('app', 'Promo Label Text'),
            'promo_sign' => Yii::t('app', 'Promo Sign'),
            'recommended_sign' => Yii::t('app', 'Recommended Sign'),
            'auto_renewal' => Yii::t('app', 'Auto Renewal'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings()
    {
        return $this->hasMany(Listing::className(), ['package_id' => 'package_id']);
    }

    /**
     * {@inheritdoc}
     * @return ListingPackageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ListingPackageQuery(get_called_class());
    }
}
