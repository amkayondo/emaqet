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

use yii\db\Migration;

/**
 * Handles the creation of table `listing_image`.
 */
class m170317_011759_create_listing_image_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%listing_image}}', [
            'image_id'                  => $this->primaryKey(),
            'listing_id'                => $this->integer(),
            'image_path'                => $this->string(),
            'sort_order'                => $this->integer()->defaultValue(0),
            'created_at'                => $this->dateTime()->notNull(),
            'updated_at'                => $this->dateTime()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('listing_image_listing_id_fk', '{{%listing_image}}', 'listing_id', '{{%listing}}', 'listing_id', 'CASCADE', 'NO ACTION');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->getDb()->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();

        $this->dropTable('{{%listing_image}}');

        $this->getDb()->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();
    }
}
