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

namespace app\extensions\securityManager\yii\db;

use yii\db\ActiveRecord as BaseActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class ActiveRecord extends BaseActiveRecord
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // auto fill timestamp columns.
        if ($this->hasAttribute('created_at') || $this->hasAttribute('updated_at')) {
            $behavior = [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ];
            if ($this->hasAttribute('created_at')) {
                $behavior['createdAtAttribute'] = 'created_at';
            } else {
                $behavior['createdAtAttribute'] = null;
            }
            if ($this->hasAttribute('updated_at')) {
                $behavior['updatedAtAttribute'] = 'updated_at';
            } else {
                $behavior['updatedAtAttribute'] = null;
            }
            $behaviors[] = $behavior;
        }

        return $behaviors;
    }
}