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
 * Class CategoryFieldValue
 * @package app\models
 */
class CategoryFieldValue extends \app\models\auto\CategoryFieldValue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field_id', 'listing_id', 'value'], 'required'],
            [['value'], 'string', 'max' => 255],
            [['field_id', 'listing_id'], 'integer'],
        ];
    }
}