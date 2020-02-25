<?php

use yii\db\Migration;

/**
 * Class m181207_144006_add_nickname_customer_table
 */
class m181207_144006_add_nickname_customer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%customer}}', 'nickname', $this->string(100)->after('group_id'));
        $this->addColumn('{{%customer}}', 'display_option', $this->char(15)->notNull()->defaultValue('name')->after('source'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%customer}}', 'nickname');
        $this->dropColumn('{{%customer}}', 'display_option');
    }
}
