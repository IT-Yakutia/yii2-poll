<?php

use yii\db\Migration;

/**
 * Class m200911_104853_add_poll_role
 */
class m200911_104853_add_poll_role extends Migration
{
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $pollRedactor = $auth->getPermission('poll');
        if($pollRedactor == null){
            $pollRedactor = $auth->createPermission('poll');
            $pollRedactor->description = 'Редактирование опросов';

            $auth->add($pollRedactor);

            $operator = $auth->getRole('operator');
            if($operator != null || $operator != false)
                $auth->addChild($operator,$pollRedactor);
        }
    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $pollRedactor = $auth->getPermission('poll');
        if($pollRedactor !== null)
            $auth->remove($pollRedactor);
        
    }
}
