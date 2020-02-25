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

namespace app\fieldbuilder;

use yii\base\Widget;

class Type extends Widget
{
    /**
     * @var array
     */
    public $params = [];

    /**
     * @var
     */
    public $form;

    /**
     * @var
     */
    public $category;

    /**
     * @var
     */
    public $field;

    /**
     * @return int
     */
    final public function getIndex()
    {
        // use unique value because counter++ is causing
        // issues when importing inherit parent fields
        return uniqid();
    }
}