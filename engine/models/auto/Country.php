<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%country}}".
 *
 * @property int $country_id
 * @property string $name
 * @property string $code
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Location[] $locations
 * @property Order[] $orders
 * @property Tax[] $taxes
 * @property Zone[] $zones
 */
class Country extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%country}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 150],
            [['code'], 'string', 'max' => 3],
            [['status'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'country_id' => Yii::t('app', 'Country ID'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocations()
    {
        return $this->hasMany(Location::className(), ['country_id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['country_id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaxes()
    {
        return $this->hasMany(Tax::className(), ['country_id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZones()
    {
        return $this->hasMany(Zone::className(), ['country_id' => 'country_id']);
    }

    /**
     * {@inheritdoc}
     * @return CountryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountryQuery(get_called_class());
    }
}
