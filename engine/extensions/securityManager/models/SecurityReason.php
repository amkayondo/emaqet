<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.3
 */

namespace app\extensions\securityManager\models;

use yii\helpers\ArrayHelper;

/**
 * Class SecurityReason
 * @package app\extensions\securityManager\models
 */
class SecurityReason extends \app\extensions\securityManager\models\auto\SecurityReason
{
    const REASON_TYPE_BAN                  = 1;
    const REASON_TYPE_INAPPROPRIATE_REPORT = 2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reason_type', 'description'], 'required'],
            [['reason_type'], 'integer'],
            [['description'], 'string', 'max' => 130],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'reason_type' => t('app', 'Reason Type'),
            'description' => t('app', 'Description'),
            'created_at'  => t('app', 'Created At'),
            'updated_at'  => t('app', 'Updated At'),
        ]);
    }

    /**
     * Get list of types
     *
     * @param null $type
     *
     * @return array|mixed
     */
    public static function getTypesList($type = null)
    {
        $reasonTypes = [
            self::REASON_TYPE_BAN                  => t('app', 'Ban Reason'),
            self::REASON_TYPE_INAPPROPRIATE_REPORT => t('app', 'Inappropriate Report Reason'),
        ];

        return $type ? $reasonTypes[$type] : $reasonTypes;
    }


    /**
     * Get list of reasons by type
     *
     * @param $type
     *
     * @return auto\SecurityReason[]|array
     */
    public static function getReasonsList($type)
    {
        return self::find()->where(['reason_type' => $type])->all();
    }
}
