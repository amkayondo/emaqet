<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%order_transaction}}".
 *
 * @property int $transaction_id
 * @property int $order_id
 * @property string $gateway
 * @property string $type
 * @property string $transaction_reference
 * @property string $gateway_response
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Order $order
 */
class OrderTransaction extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order_transaction}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id'], 'integer'],
            [['gateway_response'], 'string'],
            [['created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['gateway'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 20],
            [['transaction_reference'], 'string', 'max' => 100],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'order_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'transaction_id' => Yii::t('app', 'Transaction ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'gateway' => Yii::t('app', 'Gateway'),
            'type' => Yii::t('app', 'Type'),
            'transaction_reference' => Yii::t('app', 'Transaction Reference'),
            'gateway_response' => Yii::t('app', 'Gateway Response'),
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
     * @return OrderTransactionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderTransactionQuery(get_called_class());
    }
}
