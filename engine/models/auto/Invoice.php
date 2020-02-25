<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%invoice}}".
 *
 * @property int $invoice_id
 * @property int $order_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Order $order
 */
class Invoice extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%invoice}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'created_at', 'updated_at'], 'required'],
            [['order_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'order_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'invoice_id' => Yii::t('app', 'Invoice ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['order_id' => 'order_id']);
    }

    /**
     * {@inheritdoc}
     * @return InvoiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InvoiceQuery(get_called_class());
    }
}
