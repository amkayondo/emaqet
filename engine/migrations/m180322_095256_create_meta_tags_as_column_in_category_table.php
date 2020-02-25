<?php

use yii\db\Migration;

/**
 * Class m180322_095256_create_meta_tag_as_column_in_category_table
 */
class m180322_095256_create_meta_tags_as_column_in_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%category}}', 'meta_keywords', $this->string(160)->after('sort_order'));
        $this->addColumn('{{%category}}', 'meta_description', $this->string(255)->after('meta_keywords'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%category}}', 'meta_keywords');
        $this->dropColumn('{{%category}}', 'meta_description');
    }
}
