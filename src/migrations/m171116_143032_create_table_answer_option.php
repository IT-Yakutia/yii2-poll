<?php

use yii\db\Migration;

/**
 * Class m171116_143032_create_table_answer_option
 */
class m171116_143032_create_table_answer_option extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%answer_option}}', [
            'id' => $this->primaryKey(),
            'option_id' => $this->integer()->notNull(),
            'answer_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('answer_option-option-fkey','answer_option','option_id','option','id','CASCADE','CASCADE');
        $this->createIndex('answer_option-option-idx','answer_option','option_id');

        $this->addForeignKey('answer_option-answer-fkey','answer_option','answer_id','answer','id','CASCADE','CASCADE');
        $this->createIndex('answer_option-answer-idx','answer_option','answer_id');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('answer_option-answer-fkey','answer_option');
        $this->dropIndex('answer_option-answer-idx','answer_option');

        $this->dropForeignKey('answer_option-option-fkey','answer_option');
        $this->dropIndex('answer_option-option-idx','answer_option');

        $this->dropTable('{{%answer_option}}');
    }
}
