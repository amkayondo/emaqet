<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.6
 */

use yii\db\Migration;

/**
 * Class m181105_152025_alter_columns_listing_package_table
 */
class m181105_152025_alter_columns_listing_package_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('{{%listing_package}}', 'promo_show_featured_area');
        $this->dropColumn('{{%listing_package}}', 'promo_show_at_top');
        $this->addColumn('{{%listing_package}}', 'promo_label_text', $this->string(25)->notNull()->defaultValue('Promoted')->after('promo_days'));
        $this->addColumn('{{%listing_package}}', 'promo_label_text_color', $this->string(25)->notNull()->defaultValue('rgba(255,255,255,1)')->after('promo_days'));
        $this->addColumn('{{%listing_package}}', 'promo_label_background_color', $this->string(25)->notNull()->defaultValue('rgba(26,188,156,.95)')->after('promo_days'));

        $this->alterColumn('{{%listing_package}}', 'price', $this->integer()->notNull()->defaultValue(0));
        $this->alterColumn('{{%listing_package}}', 'listing_days', $this->integer()->notNull()->defaultValue(30));
        $this->alterColumn('{{%listing_package}}', 'promo_days', $this->integer()->notNull()->defaultValue(0));
        $this->alterColumn('{{%listing_package}}', 'auto_renewal', $this->integer()->notNull()->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('{{%listing_package}}', 'promo_show_featured_area', $this->char(3)->notNull()->defaultValue('no')->after('promo_days'));
        $this->addColumn('{{%listing_package}}', 'promo_show_at_top', $this->char(3)->notNull()->defaultValue('no')->after('promo_days'));
        $this->dropColumn('{{%listing_package}}', 'promo_label_text');
        $this->dropColumn('{{%listing_package}}', 'promo_label_text_color');
        $this->dropColumn('{{%listing_package}}', 'promo_label_background_color');

        $this->alterColumn('{{%listing_package}}', 'price', $this->integer()->defaultValue(null));
        $this->alterColumn('{{%listing_package}}', 'listing_days', $this->integer()->defaultValue(null));
        $this->alterColumn('{{%listing_package}}', 'promo_days', $this->integer()->defaultValue(null));
        $this->alterColumn('{{%listing_package}}', 'auto_renewal', $this->integer()->defaultValue(null));
    }
}
