<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%customer_store}}".
 *
 * @property int $store_id
 * @property string $slug
 * @property int $customer_id
 * @property string $store_name
 * @property string $company_name
 * @property string $company_no
 * @property string $vat
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Customer $customer
 */
class CustomerStore extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%customer_store}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'customer_id', 'store_name', 'company_name', 'created_at', 'updated_at'], 'required'],
            [['customer_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['slug'], 'string', 'max' => 110],
            [['store_name', 'company_name'], 'string', 'max' => 30],
            [['company_no', 'vat'], 'string', 'max' => 20],
            [['status'], 'string', 'max' => 15],
            [['slug'], 'unique'],
            [['store_name'], 'unique'],
            [['company_name'], 'unique'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'store_id' => Yii::t('app', 'Store ID'),
            'slug' => Yii::t('app', 'Slug'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'store_name' => Yii::t('app', 'Store Name'),
            'company_name' => Yii::t('app', 'Company Name'),
            'company_no' => Yii::t('app', 'Company No'),
            'vat' => Yii::t('app', 'Vat'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customer_id' => 'customer_id']);
    }

    /**
     * {@inheritdoc}
     * @return CustomerStoreQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerStoreQuery(get_called_class());
    }
}
