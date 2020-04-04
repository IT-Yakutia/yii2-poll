<?php

use yii\db\Migration;

/**
 * Class m171027_012040_vote_tables
 */
class m171027_012040_vote_tables extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%vote}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'type' => $this->integer()->notNull()->defaultValue(10),
            'photo' => $this->string(),
            'sort' => $this->integer(),
            'description' => $this->text(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%question}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'type' => $this->integer()->notNull()->defaultValue(10),
            'photo' => $this->string(),
            'sort' => $this->integer(),
            'description' => $this->text(),

            'show_for_option_id' => $this->integer(),

            'vote_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('question-question_parent-fkey','question','parent_id','question','id','SET NULL','SET NULL');
        $this->createIndex('question-question_parent-idx','question','parent_id');

        $this->addForeignKey('question-vote-fkey','question','vote_id','vote','id','CASCADE','CASCADE');
        $this->createIndex('question-vote-idx','question','vote_id');

        $this->createTable('{{%option}}', [
            'id' => $this->primaryKey(),
            'value' => $this->string()->notNull(),
            'type' => $this->integer()->notNull()->defaultValue(10),
            'photo' => $this->string(),
            'sort' => $this->integer(),

            'question_id' => $this->integer()->notNull(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('option-question-fkey','option','question_id','question','id','CASCADE','CASCADE');
        $this->createIndex('option-question-idx','option','question_id');

        $this->createTable('{{%vote_user}}', [
            'id' => $this->primaryKey(),
            'ip' => $this->string()->notNull(),
            'hash' => $this->string(32)->notNull(),

            'vote_id' => $this->integer()->notNull(),
            'user_id' => $this->integer(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('vote_user-vote-fkey','vote_user','vote_id','vote','id','CASCADE','CASCADE');
        $this->createIndex('vote_user-vote-idx','vote_user','vote_id');

        $this->addForeignKey('vote_user-user-fkey','vote_user','user_id','user','id','SET NULL','SET NULL');
        $this->createIndex('vote_user-user-idx','vote_user','user_id');

        $this->createTable('{{%answer}}', [
            'id' => $this->primaryKey(),
            'value' => $this->text()->notNull(),
            'free_form' => $this->text(),
            'type' => $this->integer()->notNull()->defaultValue(10),

            'vote_id' => $this->integer()->notNull(),
            'vote_user_id' => $this->integer(),
            'question_id' => $this->integer()->notNull(),
            'option_id' => $this->integer(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('answer-vote_user-fkey','answer','vote_user_id','vote_user','id','SET NULL','SET NULL');
        $this->createIndex('answer-vote_user-idx','answer','vote_user_id');

        $this->addForeignKey('answer-vote-fkey','answer','vote_id','vote','id','CASCADE','CASCADE');
        $this->createIndex('answer-vote-idx','answer','vote_id');

        $this->addForeignKey('answer-question-fkey','answer','question_id','question','id','CASCADE','CASCADE');
        $this->createIndex('answer-question-idx','answer','question_id');

        $this->addForeignKey('answer-option-fkey','answer','option_id','option','id','SET NULL','SET NULL');
        $this->createIndex('answer-option-idx','answer','option_id');
    }

    public function down()
    {
        $this->dropForeignKey('answer-option-fkey','answer');
        $this->dropIndex('answer-option-idx','answer');

        $this->dropForeignKey('answer-question-fkey','answer');
        $this->dropIndex('answer-question-idx','answer');

        $this->dropForeignKey('answer-vote-fkey','answer');
        $this->dropIndex('answer-vote-idx','answer');

        $this->dropForeignKey('answer-vote_user-fkey','answer');
        $this->dropIndex('answer-vote_user-idx','answer');

        $this->dropTable('{{%answer}}');

        $this->dropForeignKey('vote_user-user-fkey','vote_user');
        $this->dropIndex('vote_user-user-idx','vote_user');

        $this->dropForeignKey('vote_user-vote-fkey','vote_user');
        $this->dropIndex('vote_user-vote-idx','vote_user');

        $this->dropTable('{{%vote_user}}');

        $this->dropForeignKey('option-question-fkey','option');
        $this->dropIndex('option-question-idx','option');

        $this->dropTable('{{%option}}');

        $this->dropForeignKey('question-vote-fkey','question');
        $this->dropIndex('question-vote-idx','question');

        $this->dropForeignKey('question-question_parent-fkey','question');
        $this->dropIndex('question-question_parent-idx','question');

        $this->dropTable('{{%question}}');

        $this->dropTable('{{%vote}}');
    }
}
