<?php

use yii\db\Migration;

/**
 * Handles the creation of table `security_reason`.
 */
class m180330_125910_create_security_reason_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%security_reason}}', [
            'reason_id'   => $this->primaryKey(),
            'reason_type' => $this->smallInteger(5)->unsigned()->notNull(),
            'description' => $this->string(130)->notNull(),
            'created_at'  => $this->dateTime()->notNull(),
            'updated_at'  => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%security_reason}}');
    }
}
