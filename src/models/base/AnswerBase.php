<?php

namespace ityakutia\poll\models\base;

use ityakutia\poll\models\Option;
use ityakutia\poll\models\Question;
use ityakutia\poll\models\Vote;
use ityakutia\poll\models\VoteUser;
use yii\db\ActiveQuery;
use Yii;
use yii\db\ActiveRecord;

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
class AnswerBase extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poll_answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'vote_id', 'question_id', 'created_at', 'updated_at'], 'required'],
            [['value', 'free_form'], 'string'],
            [['type', 'vote_id', 'vote_user_id', 'question_id', 'option_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['option_id'], 'exist', 'skipOnError' => true, 'targetClass' => Option::class, 'targetAttribute' => ['option_id' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::class, 'targetAttribute' => ['question_id' => 'id']],
            [['vote_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vote::class, 'targetAttribute' => ['vote_id' => 'id']],
            [['vote_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => VoteUser::class, 'targetAttribute' => ['vote_user_id' => 'id']],
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
            'free_form' => 'Free Form',
            'type' => 'Type',
            'vote_id' => 'Vote ID',
            'vote_user_id' => 'Vote User ID',
            'question_id' => 'Question ID',
            'option_id' => 'Option ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

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
}
