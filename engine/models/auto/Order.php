<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property int $order_id
 * @property int $listing_id
 * @property int $customer_id
 * @property int $promo_code_id
 * @property string $order_title
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $company_name
 * @property string $company_no
 * @property string $vat
 * @property int $country_id
 * @property int $zone_id
 * @property string $city
 * @property string $zip
 * @property string $phone
 * @property int $discount
 * @property int $subtotal
 * @property int $total
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Invoice[] $invoices
 * @property Country $country
 * @property Customer $customer
 * @property Listing $listing
 * @property Zone $zone
 * @property OrderTax[] $orderTaxes
 * @property OrderTransaction[] $orderTransactions
 */
class Order extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['listing_id', 'customer_id', 'promo_code_id', 'country_id', 'zone_id', 'discount', 'subtotal', 'total'], 'integer'],
            [['first_name', 'last_name', 'city', 'zip', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['order_title', 'first_name', 'last_name', 'city'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 150],
            [['company_name'], 'string', 'max' => 30],
            [['company_no', 'vat', 'phone'], 'string', 'max' => 20],
            [['zip', 'status'], 'string', 'max' => 10],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'country_id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
            [['listing_id'], 'exist', 'skipOnError' => true, 'targetClass' => Listing::className(), 'targetAttribute' => ['listing_id' => 'listing_id']],
            [['zone_id'], 'exist', 'skipOnError' => true, 'targetClass' => Zone::className(), 'targetAttribute' => ['zone_id' => 'zone_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_id' => Yii::t('app', 'Order ID'),
            'listing_id' => Yii::t('app', 'Listing ID'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'promo_code_id' => Yii::t('app', 'Promo Code ID'),
            'order_title' => Yii::t('app', 'Order Title'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'company_name' => Yii::t('app', 'Company Name'),
            'company_no' => Yii::t('app', 'Company No'),
            'vat' => Yii::t('app', 'Vat'),
            'country_id' => Yii::t('app', 'Country ID'),
            'zone_id' => Yii::t('app', 'Zone ID'),
            'city' => Yii::t('app', 'City'),
            'zip' => Yii::t('app', 'Zip'),
            'phone' => Yii::t('app', 'Phone'),
            'discount' => Yii::t('app', 'Discount'),
            'subtotal' => Yii::t('app', 'Subtotal'),
            'total' => Yii::t('app', 'Total'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['order_id' => 'order_id']);
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
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customer_id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListing()
    {
        return $this->hasOne(Listing::className(), ['listing_id' => 'listing_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZone()
    {
        return $this->hasOne(Zone::className(), ['zone_id' => 'zone_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderTaxes()
    {
        return $this->hasMany(OrderTax::className(), ['order_id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderTransactions()
    {
        return $this->hasMany(OrderTransaction::className(), ['order_id' => 'order_id']);
    }

    /**
     * {@inheritdoc}
     * @return OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderQuery(get_called_class());
    }
}
