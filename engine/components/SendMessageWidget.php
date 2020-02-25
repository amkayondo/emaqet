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

namespace app\components;

use app\models\SendMessageForm;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\db\Expression;

class SendMessageWidget extends Widget
{
    /**
     * @var string slug of listing
     */
    public $listingSlug;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->listingSlug)) {
            throw new InvalidConfigException('Slug of listing is required option.');
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $sendMessageForm = new SendMessageForm();

        return $this->render('send-message/send-message', [
            'sendMessageForm' => $sendMessageForm,
            'slug'            => $this->listingSlug,
        ]);
    }
}
