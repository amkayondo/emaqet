<?php

use yii\db\Migration;

/**
 * Class m180425_145256_alter_null_customer_id_in_order_table
 */
class m180425_145256_alter_null_customer_id_in_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%order}}', 'email', $this->string(150)->after('last_name'));

        $this->dropForeignKey('order_customer_id_fk','{{%order}}');

        $this->alterColumn('{{%order}}', 'customer_id', $this->integer()->defaultValue(null));
        $this->addForeignKey('order_customer_id_fk', '{{%order}}', 'customer_id', '{{%customer}}', 'customer_id', 'SET NULL', 'NO ACTION');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%order}}', 'email');

        $this->dropForeignKey('order_customer_id_fk','{{%order}}');

        $this->alterColumn('{{%order}}', 'customer_id', $this->integer()->notNull());
        $this->addForeignKey('order_customer_id_fk', '{{%order}}', 'customer_id', '{{%customer}}', 'customer_id', 'CASCADE', 'NO ACTION');
    }
}
