<?php

use yii\db\Migration;

/**
 * Class m200412_194611_add_poll_votes
 */
class m200412_194611_add_poll_votes extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('poll_vote', [
            'id' => $this->primaryKey(),
            'poll_option_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('poll_vote-poll_option-fkey','poll_vote','poll_option_id','poll_option','id','CASCADE','CASCADE');
        $this->createIndex('poll_vote-poll_option-idx','poll_vote','poll_option_id');

    }

    public function safeDown()
    {
        $this->dropTable('poll_vote');
    }
}
