<?php

namespace ityakutia\poll\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;
use uraankhayayaal\sortable\behaviors\Sortable;

/**
 * This is the model class for table "poll_option".
 *
 * @property int $id
 * @property string $title
 * @property int $sort
 * @property int $poll_question_id
 * @property int $is_publish
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property PollQuestion $pollQuestion
 */
class PollOption extends ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'sortable' => [
                'class' => Sortable::class,
                'query' => self::find(),
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'poll_option';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'poll_question_id'], 'required'],
            [['sort', 'poll_question_id', 'is_publish', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['poll_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => PollQuestion::class, 'targetAttribute' => ['poll_question_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('app','Варинт ответа'),
            
            'poll_question_id' => Yii::t('app','Вопрос'),

            'sort' => 'Sort',
            'is_publish' => Yii::t('app','Опубликовать'),
            'status' => 'Status',
            'created_at' => Yii::t('app','Создан'),
            'updated_at' => Yii::t('app','Изменен'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getPollQuestion()
    {
        return $this->hasOne(PollQuestion::class, ['id' => 'poll_question_id']);
    }

    public function getPollVotes()
    {
        return $this->hasMany(PollVote::class, ['poll_option_id' => 'id']);
    }

    public function getPollVotesCount()
    {
        return $this->hasMany(PollVote::class, ['poll_option_id' => 'id'])->count();
    }

    public function getProgressPercent()
    {
        $allQuestionVotes = PollVote::find()->joinWith(['pollOption'])->where(['poll_option.poll_question_id' => $this->poll_question_id])->count();
        return $this->pollVotesCount / $allQuestionVotes * 100;
    }

}
