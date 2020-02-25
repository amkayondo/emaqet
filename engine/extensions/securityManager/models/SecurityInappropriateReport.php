<?php

namespace app\extensions\securityManager\models;

use app\models\Listing;
use app\models\User;
use yii\helpers\ArrayHelper;

/**
 * Class SecurityInappropriateReport
 * @package app\extensions\securityManager\models
 */
class SecurityInappropriateReport extends \app\extensions\securityManager\models\auto\SecurityInappropriateReport
{
    /**
     * @var string
     */
    public $reCaptcha = '';

    // statuses
    const STATUS_PENDING     = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_RESOLVED    = 3;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['listing_id', 'status', 'report_reason'], 'required'],
            [['listing_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['report_reason'], 'string', 'max' => 130],
            [['report_notes'], 'string', 'max' => 500],
            [['updated_by'], 'string', 'max' => 255],
        ];

        if ($captchaSecretKey = options()->get('app.settings.common.captchaSecretKey', '')) {
            $rules[] = [
                ['reCaptcha'],
                \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),
                'secret' => $captchaSecretKey
            ];
        }

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'listing_id'    => t('app', 'Listing Name'),
            'status'        => t('app', 'Status'),
            'report_reason' => t('app', 'Report Reason'),
            'report_notes'  => t('app', 'Report Notes'),
            'updated_by'    => t('app', 'Updated By'),
            'created_at'    => t('app', 'Created At'),
            'updated_at'    => t('app', 'Updated At'),
        ]);
    }

    /**
     * Get list of statuses or particular status if particular is passed
     *
     * @param null $status
     *
     * @return array|mixed
     */
    public static function getStatusesList($status = null)
    {
        $statuses = [
            self::STATUS_PENDING     => t('app', 'Pending'),
            self::STATUS_IN_PROGRESS => t('app', 'In Progress'),
            self::STATUS_RESOLVED    => t('app', 'Resolved'),
        ];

        return $status ? $statuses[$status] : $statuses;
    }

    /**
     * Get class of color by status
     * Color palette provided by AdminLTE
     *
     * @param $status
     *
     * @return mixed|string
     */
    public static function getStatusToColorClassAccordance($status)
    {
        $bgColorClasses = [
            self::STATUS_PENDING     => 'bg-red',
            self::STATUS_IN_PROGRESS => 'bg-yellow',
            self::STATUS_RESOLVED    => 'bg-green',
        ];

        return !empty($bgColorClasses[$status]) ? $bgColorClasses[$status] : '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAd()
    {
        return $this->hasOne(Listing::className(), ['listing_id' => 'listing_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'updated_by']);
    }
}
