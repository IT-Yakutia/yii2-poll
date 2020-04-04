<?php

namespace ityakutia\poll\models;

use ityakutia\poll\components\ExtendedActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "answer".
 *
 * @property int $id
 * @property string $value
 * @property string $free_form
 * @property int $type
 * @property int $vote_id
 * @property int $vote_user_id
 * @property int $question_id
 * @property int $option_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Option $option
 * @property Question $question
 * @property Vote $vote
 * @property VoteUser $voteUser
 */
class Answer extends ExtendedActiveRecord
{
    public $answerOptions;
    const SCENARIO_MANY_OF_MANY = 'list';
    const SCENARIO_INTEGER = 'intger';
    const SCENARIO_STRING = 'string';
    const SCENARIO_TEXT = 'text';
    const SCENARIO_DATE = 'date';
    const SCENARIO_TIME = 'time';
    const SCENARIO_DATE_TIME = 'date_time';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_MANY_OF_MANY] = $scenarios['default'];
        $scenarios[self::SCENARIO_INTEGER] = $scenarios['default'];
        $scenarios[self::SCENARIO_STRING] = $scenarios['default'];
        $scenarios[self::SCENARIO_TEXT] = $scenarios['default'];
        $scenarios[self::SCENARIO_DATE] = $scenarios['default'];
        $scenarios[self::SCENARIO_TIME] = $scenarios['default'];
        $scenarios[self::SCENARIO_DATE_TIME] = $scenarios['default'];
        //'default' => ['value'],
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['value', 'vote_id', 'question_id'], 'required'],
            ['value', 'string', 'on' => 'default'],
            ['value', 'each', 'rule' => ['integer'], 'on' => self::SCENARIO_MANY_OF_MANY],
            ['value', 'integer', 'on' => self::SCENARIO_INTEGER],
            ['value', 'string', 'max' => 255, 'on' => self::SCENARIO_STRING],
            ['value', 'string', 'on' => self::SCENARIO_TEXT],
            ['value', 'string', 'on' => self::SCENARIO_DATE],
            ['value', 'string', 'on' => self::SCENARIO_TIME],
            ['value', 'string', 'on' => self::SCENARIO_DATE_TIME],
            [['free_form'], 'string'],
            [['type', 'vote_id', 'vote_user_id', 'question_id', 'option_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['option_id'], 'exist', 'skipOnError' => true, 'targetClass' => Option::class, 'targetAttribute' => ['option_id' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::class, 'targetAttribute' => ['question_id' => 'id']],
            [['vote_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vote::class, 'targetAttribute' => ['vote_id' => 'id']],
            [['vote_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => VoteUser::class, 'targetAttribute' => ['vote_user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Значение',
            'free_form' => 'Другой ответ',
            'type' => 'Тип',
            'vote_id' => 'Опрос',
            'vote_user_id' => 'Респондент',
            'question_id' => 'Вопрос',
            'option_id' => 'Вариант',
            'status' => 'Статус',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->scenario == self::SCENARIO_MANY_OF_MANY) {
            $this->value = implode(",", $this->value);
        }

        switch ($this->question->type) {
            case $this->question::TYPE_STRING:
                //$this->value;
                break;
            case $this->question::TYPE_TEXT:
                //$this->value;
                break;
            case $this->question::TYPE_MANY_OF_MANY:
                $this->answerOptions = $this->value;
                $anser_value = '';
                $numItems = count(explode(",", $this->value));
                $i = 0;
                foreach (explode(",", $this->value) as $key => $value) {
                    $anser_value .= Option::findOne($value)->value . ((++$i !== $numItems) ? ', ' : '');
                }
                $this->value = $anser_value;
                // if(in_array($this->value,\yii\helpers\ArrayHelper::getColumn($this->question->options, 'id'))){
                //     $this->option_id = $this->value;
                //     $this->value = $this->option->value;
                // }
                break;
            case $this->question::TYPE_ONE_OF_MANY:
                // if(in_array($this->value,\yii\helpers\ArrayHelper::getColumn($this->question->options, 'id'))){
                //     $this->option_id = $this->value;
                //     $this->value = $this->option->value;
                // }
                break;
            case $this->question::TYPE_DATE:
                //$this->value;
                break;
            case $this->question::TYPE_TIME:
                //$this->value;
                break;
            case $this->question::TYPE_DATE_TIME:
                //$this->value;
                break;
            case $this->question::TYPE_INTEGER:
                //$this->value;
                break;

            default:
                $this->option_id = $this->value;
                break;
        }
        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        switch ($this->question->type) {
            case $this->question::TYPE_MANY_OF_MANY:
                foreach (explode(",", $this->answerOptions) as $value) {
                    $answerOption = new AnswerOption();
                    $answerOption->option_id = $value;
                    $answerOption->answer_id = $this->id;
                    $answerOption->save();
                }
                break;
        }
    }

    // public function saveCheckBlockList($attribute_name, $params){var_dump($this->value);die;
    //     $this->value = implode(",", $this->value);
    //     return true;
    // }

    /**
     * @return ActiveQuery
     */
    public function getOption()
    {
        return $this->hasOne(Option::class, ['id' => 'option_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::class, ['id' => 'question_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVote()
    {
        return $this->hasOne(Vote::class, ['id' => 'vote_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVoteUser()
    {
        return $this->hasOne(VoteUser::class, ['id' => 'vote_user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getAnswerOptions()
    {
        return $this->hasMany(AnswerOption::class, ['answer_id' => 'id']);
    }
}
