<?php

namespace ityakutia\poll\models;

use ityakutia\poll\components\ExtendedActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "option".
 *
 * @property int $id
 * @property string $value
 * @property int $type
 * @property string $photo
 * @property int $sort
 * @property int $question_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Answer[] $answers
 * @property Question $question
 */
class Option extends ExtendedActiveRecord
{
    const TYPE_TEXT = 10;
    const TYPE_NUMBER = 15;
    const TYPE_IMAGE = 20;

    const TYPES = [
        self::TYPE_TEXT => 'Текст',
        self::TYPE_NUMBER => 'Число',
        self::TYPE_IMAGE => 'Изображение',
    ];
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'question_id'], 'required'],
            [['type', 'sort', 'question_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['value', 'photo'], 'string', 'max' => 255],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::class, 'targetAttribute' => ['question_id' => 'id']],
            ['type', 'default', 'value' => $this::TYPE_TEXT],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Значение',
            'type' => 'Тип',
            'photo' => 'Фото',
            'sort' => 'Sort',
            'question_id' => 'Вопрос',
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
        return $this->hasMany(Answer::class, ['option_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getAnswerOptions()
    {
        return $this->hasMany(AnswerOption::class, ['option_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::class, ['id' => 'question_id']);
    }
}
