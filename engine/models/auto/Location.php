<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%location}}".
 *
 * @property int $location_id
 * @property int $country_id
 * @property int $zone_id
 * @property string $city
 * @property string $zip
 * @property string $latitude
 * @property string $longitude
 * @property int $retries
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Listing[] $listings
 * @property Country $country
 * @property Zone $zone
 */
class Location extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%location}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_id', 'zone_id', 'created_at', 'updated_at'], 'required'],
            [['country_id', 'zone_id', 'retries'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['city'], 'string', 'max' => 100],
            [['zip'], 'string', 'max' => 10],
            [['status'], 'string', 'max' => 15],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'country_id']],
            [['zone_id'], 'exist', 'skipOnError' => true, 'targetClass' => Zone::className(), 'targetAttribute' => ['zone_id' => 'zone_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'location_id' => Yii::t('app', 'Location ID'),
            'country_id' => Yii::t('app', 'Country ID'),
            'zone_id' => Yii::t('app', 'Zone ID'),
            'city' => Yii::t('app', 'City'),
            'zip' => Yii::t('app', 'Zip'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'retries' => Yii::t('app', 'Retries'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings()
    {
        return $this->hasMany(Listing::className(), ['location_id' => 'location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['country_id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZone()
    {
        return $this->hasOne(Zone::className(), ['zone_id' => 'zone_id']);
    }

    /**
     * {@inheritdoc}
     * @return LocationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LocationQuery(get_called_class());
    }
}
