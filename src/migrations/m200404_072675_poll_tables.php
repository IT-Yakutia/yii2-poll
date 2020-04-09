<?php

use yii\db\Migration;

/**
 * Class m200404_072675_poll_tables
 */
class m200404_072675_poll_tables extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%poll}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'photo' => $this->string(),
            'sort' => $this->integer(),
            'description' => $this->text(),
            'slug' => $this->string()->notNull(),
            'meta_description' => $this->string(),
            'meta_keywords' => $this->string(),

            'is_publish' => $this->boolean(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%poll_question}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'poll_id' => $this->integer()->notNull(),

            'sort' => $this->integer(),
            'is_publish' => $this->boolean(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('poll_question-poll-fkey', 'poll_question', 'poll_id', 'poll', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('poll_question-poll-idx', 'poll_question', 'poll_id');

        $this->createTable('{{poll_option}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),

            'poll_question_id' => $this->integer()->notNull(),

            'sort' => $this->integer(),
            'is_publish' => $this->boolean(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('poll_option-poll_question-fkey','poll_option','poll_question_id','poll_question','id','CASCADE','CASCADE');
        $this->createIndex('poll_option-poll_question-idx','poll_option','poll_question_id');

    }

    public function down()
    {
        $this->dropForeignKey('poll_option-poll_question-fkey','poll_option');
        $this->dropIndex('poll_option-poll_question-idx','poll_option');

        $this->dropTable('{{poll_option}}');

        $this->dropForeignKey('poll_question-poll-fkey','poll_question');
        $this->dropIndex('poll_question-poll-idx','poll_question');

        $this->dropTable('{{%poll_question}}');

        $this->dropTable('{{%poll}}');
    }
}
