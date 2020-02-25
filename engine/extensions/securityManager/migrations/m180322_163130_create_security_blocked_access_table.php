<?php

use yii\db\Migration;

/**
 * Handles the creation of table `security_blocked_access`.
 */
class m180322_163130_create_security_blocked_access_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%security_blocked_access}}', [
            'blocked_access_id' => $this->primaryKey(),
            'ip_address'        => $this->string(45)->notNull(),
            'expire'            => $this->dateTime()->notNull(),
            'is_active'         => $this->boolean()->unsigned()->notNull()->defaultValue(1),
            'created_at'        => $this->dateTime()->notNull(),
        ], $tableOptions);

        $this->createIndex('ip_address_is_active_unique_idx', '{{%security_blocked_access}}', ['ip_address', 'is_active'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%security_blocked_access}}');
    }
}
