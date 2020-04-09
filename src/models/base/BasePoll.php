<?php

namespace ityakutia\poll\models\base;

use ityakutia\poll\models\Answer;
use ityakutia\poll\models\Question;
use ityakutia\poll\models\VoteUser;
use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "vote".
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
 * @property VoteUser[] $voteUsers
 */
class BasePoll extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poll';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_at', 'updated_at'], 'required'],
            [['type', 'sort', 'status', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['name', 'photo'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'photo' => 'Photo',
            'sort' => 'Sort',
            'description' => 'Description',
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
        return $this->hasMany(Answer::class, ['vote_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::class, ['vote_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVoteUsers()
    {
        return $this->hasMany(VoteUser::class, ['vote_id' => 'id']);
    }
}
