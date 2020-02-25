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

use app\models\ContactForm;
use app\models\Page;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

class PageSectionWidget extends Widget
{
    /**
     * @var int number of items to retrieve
     */
    public $quantity = 10;

    /**
     * @var int one of constants. Look to the Page model to check available sections.
     */
    public $sectionType;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!in_array($this->sectionType, [Page::SECTION_ONE, Page::SECTION_TWO])) {
            throw new InvalidConfigException('"' . $this->sectionType . '" list type is not allowed.');
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $pages = Page::find()
            ->where(['section' => $this->sectionType])
            ->andWhere(['status' => Page::STATUS_ACTIVE])
            ->orderBy(['sort_order' => SORT_ASC])
            ->limit($this->quantity)
            ->all();

        $pages = ArrayHelper::toArray($pages);
        $contactPage = ContactForm::contactPageAttribute();

        if ($this->sectionType == $contactPage['section']) {
            $pages = ArrayHelper::merge($pages, array($contactPage));

            usort($pages, function ($a, $b) {
                return $a['sort_order'] - $b['sort_order'];
            });
        }

        return $this->render('page/page-list', [
            'pages' => $pages,
            'title' => Page::getSectionsList($this->sectionType),
        ]);
    }
}