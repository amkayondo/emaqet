<?php

use yii\db\Migration;

/**
 * Class m180628_072906_alter_description_security_reason_column
 */
class m180628_072906_alter_description_security_reason_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->alterColumn('{{%security_reason}}', 'description', $this->string(130)->notNull()->append('COLLATE utf8_unicode_ci'));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->alterColumn('{{%security_reason}}', 'description', $this->string(130)->notNull()->append('COLLATE latin1_swedish_ci'));
    }

}
