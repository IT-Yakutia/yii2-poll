<?php

namespace ityakutia\poll\models;

use Yii;
use yii\db\ActiveRecord;

class PollVote extends ActiveRecord
{
    public static function tableName()
    {
        return 'poll_vote';
    }

    public function rules()
    {
        return [
            [['poll_option_id'], 'required'],
            [['poll_option_id'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'poll_option_id' => Yii::t('app', 'Голос за ответ')
        ];
    }
}