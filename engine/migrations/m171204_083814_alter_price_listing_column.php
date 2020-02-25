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

use yii\db\Migration;

/**
 * Class m171204_083814_alter_price_listing_column
 */
class m171204_083814_alter_price_listing_column extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->alterColumn('{{%listing}}', 'price', $this->double()->notNull());
    }
    /**
     * @inheritdoc
     */
    public function down()
    {

        $this->getDb()->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();

        $this->alterColumn('{{%listing}}',  'price' , $this->integer()->notNull());

        $this->getDb()->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();
    }

}
