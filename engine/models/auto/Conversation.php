<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%conversation}}".
 *
 * @property int $conversation_id
 * @property string $conversation_uid
 * @property int $seller_id
 * @property int $buyer_id
 * @property int $listing_id
 * @property int $is_buyer_blocked
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Customer $buyer
 * @property Listing $listing
 * @property Customer $seller
 * @property ConversationMessage[] $conversationMessages
 */
class Conversation extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%conversation}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['seller_id', 'buyer_id', 'listing_id', 'created_at', 'updated_at'], 'required'],
            [['seller_id', 'buyer_id', 'listing_id', 'is_buyer_blocked'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['conversation_uid'], 'string', 'max' => 13],
            [['status'], 'string', 'max' => 15],
            [['buyer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['buyer_id' => 'customer_id']],
            [['listing_id'], 'exist', 'skipOnError' => true, 'targetClass' => Listing::className(), 'targetAttribute' => ['listing_id' => 'listing_id']],
            [['seller_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['seller_id' => 'customer_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'conversation_id' => Yii::t('app', 'Conversation ID'),
            'conversation_uid' => Yii::t('app', 'Conversation Uid'),
            'seller_id' => Yii::t('app', 'Seller ID'),
            'buyer_id' => Yii::t('app', 'Buyer ID'),
            'listing_id' => Yii::t('app', 'Listing ID'),
            'is_buyer_blocked' => Yii::t('app', 'Is Buyer Blocked'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyer()
    {
        return $this->hasOne(Customer::className(), ['customer_id' => 'buyer_id']);
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
    public function getSeller()
    {
        return $this->hasOne(Customer::className(), ['customer_id' => 'seller_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversationMessages()
    {
        return $this->hasMany(ConversationMessage::className(), ['conversation_id' => 'conversation_id']);
    }

    /**
     * {@inheritdoc}
     * @return ConversationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ConversationQuery(get_called_class());
    }
}
