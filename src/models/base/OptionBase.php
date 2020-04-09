<?php

namespace ityakutia\poll\models\base;

use ityakutia\poll\models\Answer;
use ityakutia\poll\models\Question;
use Yii;
use yii\db\ActiveRecord;
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
class OptionBase extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poll_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'question_id', 'created_at', 'updated_at'], 'required'],
            [['type', 'sort', 'question_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['value', 'photo'], 'string', 'max' => 255],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::class, 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'type' => 'Type',
            'photo' => 'Photo',
            'sort' => 'Sort',
            'question_id' => 'Question ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
    public function getQuestion()
    {
        return $this->hasOne(Question::class, ['id' => 'question_id']);
    }
}
