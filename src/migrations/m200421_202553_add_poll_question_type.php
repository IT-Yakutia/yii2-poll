<?php

use yii\db\Migration;

/**
 * Class m200421_202553_add_poll_question_type
 */
class m200421_202553_add_poll_question_type extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%poll_question}}', 'is_multi_select', $this->boolean());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%poll_question}}', 'is_multi_select');
    }
}
