<?php

namespace ityakutia\poll\models\base;

use ityakutia\poll\models\Answer;
use ityakutia\poll\models\Vote;
use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "vote_user".
 *
 * @property int $id
 * @property string $ip
 * @property string $hash
 * @property int $vote_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Answer[] $answers
 * @property Vote $vote
 */
class VoteUserBase extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'hash', 'vote_id', 'created_at', 'updated_at'], 'required'],
            [['vote_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['ip'], 'string', 'max' => 255],
            [['hash'], 'string', 'max' => 32],
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
            'ip' => 'Ip',
            'hash' => 'Hash',
            'vote_id' => 'Vote ID',
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
        return $this->hasMany(Answer::class, ['vote_user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVote()
    {
        return $this->hasOne(Vote::class, ['id' => 'vote_id']);
    }
}
