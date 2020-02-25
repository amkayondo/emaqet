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
 * Class m181208_073726_alter_columns_order_table
 */
class m181208_073726_alter_columns_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->alterColumn('{{%order}}', 'discount', $this->float()->notNull()->defaultValue(0));
        $this->alterColumn('{{%order}}', 'subtotal', $this->float()->notNull()->defaultValue(0));
        $this->alterColumn('{{%order}}', 'total', $this->float()->notNull()->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->alterColumn('{{%order}}', 'discount', $this->integer()->notNull()->defaultValue(0));
        $this->alterColumn('{{%order}}', 'subtotal', $this->integer()->notNull()->defaultValue(0));
        $this->alterColumn('{{%order}}', 'total', $this->integer()->notNull()->defaultValue(0));
    }
}
