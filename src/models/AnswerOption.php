<?php

namespace ityakutia\poll\models;

use ityakutia\poll\models\base\AnswerOptionBase;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "answer_option".
 *
 * @property int $id
 * @property int $option_id
 * @property int $answer_id
 *
 * @property Answer $answer
 * @property Option $option
 */
class AnswerOption extends AnswerOptionBase
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['option_id', 'answer_id'], 'required'],
            [['option_id', 'answer_id'], 'integer'],
            [['answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Answer::class, 'targetAttribute' => ['answer_id' => 'id']],
            [['option_id'], 'exist', 'skipOnError' => true, 'targetClass' => Option::class, 'targetAttribute' => ['option_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'option_id' => 'Option ID',
            'answer_id' => 'Answer ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(Answer::class, ['id' => 'answer_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getOption()
    {
        return $this->hasOne(Option::class, ['id' => 'option_id']);
    }
}
