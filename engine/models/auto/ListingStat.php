<?php

namespace app\models\auto;

use Yii;

/**
 * This is the model class for table "{{%listing_stat}}".
 *
 * @property int $listing_id
 * @property int $total_views
 * @property int $facebook_shares
 * @property int $twitter_shares
 * @property int $mail_shares
 * @property int $favorite
 * @property int $show_phone
 * @property int $show_mail
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Listing $listing
 */
class ListingStat extends \app\yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%listing_stat}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total_views', 'facebook_shares', 'twitter_shares', 'mail_shares', 'favorite', 'show_phone', 'show_mail'], 'integer'],
            [['created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['listing_id'], 'exist', 'skipOnError' => true, 'targetClass' => Listing::className(), 'targetAttribute' => ['listing_id' => 'listing_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'listing_id' => Yii::t('app', 'Listing ID'),
            'total_views' => Yii::t('app', 'Total Views'),
            'facebook_shares' => Yii::t('app', 'Facebook Shares'),
            'twitter_shares' => Yii::t('app', 'Twitter Shares'),
            'mail_shares' => Yii::t('app', 'Mail Shares'),
            'favorite' => Yii::t('app', 'Favorite'),
            'show_phone' => Yii::t('app', 'Show Phone'),
            'show_mail' => Yii::t('app', 'Show Mail'),
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
     * @return ListingStatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ListingStatQuery(get_called_class());
    }
}
