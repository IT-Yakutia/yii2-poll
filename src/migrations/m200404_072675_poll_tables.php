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
            'name' => $this->string()->notNull()->unique(),
            'type' => $this->integer()->notNull()->defaultValue(10),
            'photo' => $this->string(),
            'sort' => $this->integer(),
            'description' => $this->text(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // $this->createTable('{{%poll_question}}', [
        //     'id' => $this->primaryKey(),
        //     'name' => $this->string()->notNull(),
        //     'type' => $this->integer()->notNull()->defaultValue(10),
        //     'photo' => $this->string(),
        //     'sort' => $this->integer(),
        //     'description' => $this->text(),

        //     'show_for_option_id' => $this->integer(),

        //     'vote_id' => $this->integer()->notNull(),
        //     'parent_id' => $this->integer(),

        //     'status' => $this->smallInteger()->notNull()->defaultValue(10),
        //     'created_at' => $this->integer()->notNull(),
        //     'updated_at' => $this->integer()->notNull(),
        // ], $tableOptions);

        // $this->addForeignKey('question-question_parent-fkey','poll_question','parent_id','poll_question','id','SET NULL','SET NULL');
        // $this->createIndex('question-question_parent-idx','poll_question','parent_id');

        // $this->addForeignKey('question-vote-fkey','poll_question','vote_id','poll_vote','id','CASCADE','CASCADE');
        // $this->createIndex('question-vote-idx','poll_question','vote_id');

        // $this->createTable('{{%poll_option}}', [
        //     'id' => $this->primaryKey(),
        //     'value' => $this->string()->notNull(),
        //     'type' => $this->integer()->notNull()->defaultValue(10),
        //     'photo' => $this->string(),
        //     'sort' => $this->integer(),

        //     'question_id' => $this->integer()->notNull(),

        //     'status' => $this->smallInteger()->notNull()->defaultValue(10),
        //     'created_at' => $this->integer()->notNull(),
        //     'updated_at' => $this->integer()->notNull(),
        // ], $tableOptions);

        // $this->addForeignKey('option-question-fkey','poll_option','question_id','poll_question','id','CASCADE','CASCADE');
        // $this->createIndex('option-question-idx','poll_option','question_id');

        // $this->createTable('{{%poll_vote_user}}', [
        //     'id' => $this->primaryKey(),
        //     'ip' => $this->string()->notNull(),
        //     'hash' => $this->string(32)->notNull(),

        //     'vote_id' => $this->integer()->notNull(),
        //     'user_id' => $this->integer(),

        //     'status' => $this->smallInteger()->notNull()->defaultValue(10),
        //     'created_at' => $this->integer()->notNull(),
        //     'updated_at' => $this->integer()->notNull(),
        // ], $tableOptions);

        // $this->addForeignKey('vote_user-vote-fkey','poll_vote_user','vote_id','poll_vote','id','CASCADE','CASCADE');
        // $this->createIndex('vote_user-vote-idx','poll_vote_user','vote_id');

        // $this->addForeignKey('vote_user-user-fkey','poll_vote_user','user_id','user','id','SET NULL','SET NULL');
        // $this->createIndex('vote_user-user-idx','poll_vote_user','user_id');

        // $this->createTable('{{%poll_answer}}', [
        //     'id' => $this->primaryKey(),
        //     'value' => $this->text()->notNull(),
        //     'free_form' => $this->text(),
        //     'type' => $this->integer()->notNull()->defaultValue(10),

        //     'vote_id' => $this->integer()->notNull(),
        //     'vote_user_id' => $this->integer(),
        //     'question_id' => $this->integer()->notNull(),
        //     'option_id' => $this->integer(),

        //     'status' => $this->smallInteger()->notNull()->defaultValue(10),
        //     'created_at' => $this->integer()->notNull(),
        //     'updated_at' => $this->integer()->notNull(),
        // ], $tableOptions);

        // $this->addForeignKey('answer-vote_user-fkey','poll_answer','vote_user_id','poll_vote_user','id','SET NULL','SET NULL');
        // $this->createIndex('answer-vote_user-idx','poll_answer','vote_user_id');

        // $this->addForeignKey('answer-vote-fkey','poll_answer','vote_id','poll_vote','id','CASCADE','CASCADE');
        // $this->createIndex('answer-vote-idx','poll_answer','vote_id');

        // $this->addForeignKey('answer-question-fkey','poll_answer','question_id','poll_question','id','CASCADE','CASCADE');
        // $this->createIndex('answer-question-idx','poll_answer','question_id');

        // $this->addForeignKey('answer-option-fkey','poll_answer','option_id','poll_option','id','SET NULL','SET NULL');
        // $this->createIndex('answer-option-idx','poll_answer','option_id');

        // $this->createTable('{{%poll_answer_option}}', [
        //     'id' => $this->primaryKey(),
        //     'option_id' => $this->integer()->notNull(),
        //     'answer_id' => $this->integer()->notNull(),
        // ], $tableOptions);

        // $this->addForeignKey('answer_option-option-fkey','poll_answer_option','option_id','poll_option','id','CASCADE','CASCADE');
        // $this->createIndex('answer_option-option-idx','poll_answer_option','option_id');

        // $this->addForeignKey('answer_option-answer-fkey','poll_answer_option','answer_id','poll_answer','id','CASCADE','CASCADE');
        // $this->createIndex('answer_option-answer-idx','poll_answer_option','answer_id');
    }

    public function down()
    {
        // $this->dropForeignKey('answer_option-answer-fkey','poll_answer_option');
        // $this->dropIndex('answer_option-answer-idx','poll_answer_option');

        // $this->dropForeignKey('answer_option-option-fkey','poll_answer_option');
        // $this->dropIndex('answer_option-option-idx','poll_answer_option');

        // $this->dropTable('{{%poll_answer_option}}');

        // $this->dropForeignKey('answer-option-fkey','poll_answer');
        // $this->dropIndex('answer-option-idx','poll_answer');

        // $this->dropForeignKey('answer-question-fkey','poll_answer');
        // $this->dropIndex('answer-question-idx','poll_answer');

        // $this->dropForeignKey('answer-vote-fkey','poll_answer');
        // $this->dropIndex('answer-vote-idx','poll_answer');

        // $this->dropForeignKey('answer-vote_user-fkey','poll_answer');
        // $this->dropIndex('answer-vote_user-idx','poll_answer');

        // $this->dropTable('{{%poll_answer}}');

        // $this->dropForeignKey('vote_user-user-fkey','poll_vote_user');
        // $this->dropIndex('vote_user-user-idx','poll_vote_user');

        // $this->dropForeignKey('vote_user-vote-fkey','poll_vote_user');
        // $this->dropIndex('vote_user-vote-idx','poll_vote_user');

        // $this->dropTable('{{%poll_vote_user}}');

        // $this->dropForeignKey('option-question-fkey','poll_option');
        // $this->dropIndex('option-question-idx','poll_option');

        // $this->dropTable('{{%poll_option}}');

        // $this->dropForeignKey('question-vote-fkey','poll_question');
        // $this->dropIndex('question-vote-idx','poll_question');

        // $this->dropForeignKey('question-question_parent-fkey','poll_question');
        // $this->dropIndex('question-question_parent-idx','poll_question');

        // $this->dropTable('{{%poll_question}}');

        $this->dropTable('{{%poll}}');
    }
}
