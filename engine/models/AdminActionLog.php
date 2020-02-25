<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.0
 */

namespace app\models;

/**
 * Class AdminActionLog
 * @package app\models
 */
class AdminActionLog extends \app\models\auto\AdminActionLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['controller_name', 'action_name', 'changed_model', 'changed_data', 'element'], 'required'],
            [['changed_data'], 'string'],
            [['changed_by'], 'integer'],
            [['controller_name', 'action_name', 'changed_model', 'element'], 'string', 'max' => 255],
            [['changed_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['changed_by' => 'user_id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'controller_name'   => t('app', 'Section'),
            'action_name'       => t('app', 'Action'),
            'element'           => t('app', 'Element'),
            'changed_data'      => t('app', 'Changed Data'),
            'changed_model'     => t('app', 'Changed Model'),
            'changed_by'        => t('app', 'Staff'),
            'created_at'        => t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChangedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'changed_by']);
    }

    /**
     * Get list of actions that could be logged
     *
     * @return array
     */
    public static function getListOfLoggedActions()
    {
        return [
            'create' => 'create',
            'update' => 'update',
            'delete' => 'delete',
        ];
    }
}
