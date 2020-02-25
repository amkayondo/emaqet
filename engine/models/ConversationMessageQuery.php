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
 * This is the ActiveQuery class for [[ConversationMessage]].
 *
 * @see ConversationMessage
 */
class ConversationMessageQuery extends \app\models\auto\ConversationMessageQuery
{
    /**
     * Filter messages that's read
     *
     * @inheritdoc
     * @return ConversationMessage[]|array
     */
    public function read()
    {
        return $this->andWhere(['is_read' => ConversationMessage::YES]);
    }

    /**
     * Filter messages that isn't read
     *
     * @inheritdoc
     * @return ConversationMessage[]|array
     */
    public function notRead()
    {
        return $this->andWhere(['is_read' => ConversationMessage::NO]);
    }
}
