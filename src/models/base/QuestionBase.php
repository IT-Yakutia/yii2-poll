<?php

namespace ityakutia\poll\models\base;

use ityakutia\poll\models\Answer;
use ityakutia\poll\models\Option;
use ityakutia\poll\models\Vote;
use Yii;
use yii\db\ActiveRecord;
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
class QuestionBase extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'vote_id', 'created_at', 'updated_at'], 'required'],
            [['type', 'sort', 'show_for_option_id', 'vote_id', 'parent_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['name', 'photo'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionBase::class, 'targetAttribute' => ['parent_id' => 'id']],
            [['vote_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vote::class, 'targetAttribute' => ['vote_id' => 'id']],
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
            'show_for_option_id' => 'Show For Option ID',
            'vote_id' => 'Vote ID',
            'parent_id' => 'Parent ID',
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
        return $this->hasOne(QuestionBase::class, ['id' => 'parent_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getQuestionBases()
    {
        return $this->hasMany(QuestionBase::class, ['parent_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVote()
    {
        return $this->hasOne(Vote::class, ['id' => 'vote_id']);
    }
}
