<?php

namespace ityakutia\poll\models;

use ityakutia\poll\components\ExtendedActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "poll".
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property string $photo
 * @property int $sort
 * @property string $description
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Answer[] $answers
 * @property Question[] $questions
 * //@property PollUser[] $voteUsers
 */
class Poll extends ExtendedActiveRecord
{
    const TYPE_DEFAULT = 10;

    const TYPES = [
        self::TYPE_DEFAULT => 'Обычный',
    ];

    public static function tableName()
    {
        return 'poll';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['type', 'sort', 'status', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['name', 'photo'], 'string', 'max' => 255],
            [['name'], 'unique'],
            ['type', 'default', 'value' => $this::TYPE_DEFAULT],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Заголовок',
            'type' => 'Тип',
            'photo' => 'Фото',
            'sort' => 'Sort',
            'description' => 'Описание',
            'status' => 'Статус',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::class, ['poll_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::class, ['poll_id' => 'id']);
    }

    public function getQuestionsCount()
    {
        return $this->hasMany(Question::class, ['poll_id' => 'id'])->count();
    }

    public function getActualQuestions($poll_user_id)
    {
        $questions = Question::find()
            ->joinWith('answers')
            ->where(['question.poll_id' => $this->id, 'answer.poll_user_id' => $poll_user_id])
            ->select(['question.id'])
            ->asArray()
            ->all();

        return $this->hasMany(Question::class, ['poll_id' => 'id'])->andWhere(['not in', 'id', $questions])->orderBy(['sort' => SORT_ASC])->all();
    }

    // /**
    //  * @return ActiveQuery
    //  */
    // public function getPollUsers()
    // {
    //     return $this->hasMany(PollUser::class, ['poll_id' => 'id']);
    // }
}
