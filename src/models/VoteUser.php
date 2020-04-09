<?php

namespace ityakutia\poll\models;

use ityakutia\poll\components\ExtendedActiveRecord;
use Yii;
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
class VoteUser extends ExtendedActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_HIDDEN = 10;
    const STATUS_ACTIVE = 15;

    public static function tableName()
    {
        return 'poll_vote_user';
    }

    public function rules()
    {
        return [
            [['ip', 'hash', 'vote_id'], 'required'],
            [['vote_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['ip'], 'string', 'max' => 255],
            [['hash'], 'string', 'max' => 32],
            [['vote_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vote::class, 'targetAttribute' => ['vote_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'hash' => 'Hash',
            'vote_id' => 'Опрос',
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
        return $this->hasMany(Answer::class, ['vote_user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVote()
    {
        return $this->hasOne(Vote::class, ['id' => 'vote_id']);
    }

    public function generateUniqueRandomString()
    {
        $randomString = Yii::$app->getSecurity()->generateRandomString(32);
        if (!$this->findOne(['hash' => $randomString]))
            return $randomString;
        else
            return $this->generateUniqueRandomString();
    }
}
