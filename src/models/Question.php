<?php

namespace ityakutia\poll\models;

use ityakutia\poll\components\ExtendedActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "question".
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property string $photo
 * @property int $sort
 * @property string $description
 * @property int $show_for_option_id
 * @property int $vote_id
 * @property int $parent_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Answer[] $answers
 * @property Option[] $options
 * @property QuestionBase $parent
 * @property QuestionBase[] $questionBases
 * @property Vote $vote
 */
class Question extends ExtendedActiveRecord
{
    const TYPE_STRING = 10;
    const TYPE_TEXT = 15;
    const TYPE_MANY_OF_MANY = 20;
    const TYPE_ONE_OF_MANY = 25;
    const TYPE_DATE = 30;
    const TYPE_TIME = 35;
    const TYPE_DATE_TIME = 40;
    const TYPE_INTEGER = 45;

    const TYPES = [
        self::TYPE_STRING => 'Строка',
        self::TYPE_TEXT => 'Текст',
        self::TYPE_MANY_OF_MANY => 'Несколько из списка',
        self::TYPE_ONE_OF_MANY => 'Один из списка',
        self::TYPE_DATE => 'Дата',
        self::TYPE_TIME => 'Время',
        self::TYPE_DATE_TIME => 'Время и дата',
        self::TYPE_INTEGER => 'Число',
    ];

    public static function tableName()
    {
        return 'poll_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'vote_id'], 'required'],
            [['type', 'sort', 'show_for_option_id', 'vote_id', 'parent_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['name', 'photo'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::class, 'targetAttribute' => ['parent_id' => 'id']],
            [['vote_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vote::class, 'targetAttribute' => ['vote_id' => 'id']],
            ['type', 'default', 'value' => $this::TYPE_STRING],
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
            'show_for_option_id' => 'Подвопрос родительского ответа',
            'vote_id' => 'Опрос',
            'parent_id' => 'Родитель',
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
        return $this->hasMany(Answer::class, ['question_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasMany(Option::class, ['question_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Question::class, ['id' => 'parent_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getQuestionBases()
    {
        return $this->hasMany(Question::class, ['parent_id' => 'id']);
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
    public function getShowforoption()
    {
        return $this->hasOne(Option::class, ['id' => 'show_for_option_id']);
    }
}
