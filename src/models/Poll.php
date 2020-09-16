<?php

namespace ityakutia\poll\models;

use uraankhayayaal\sortable\behaviors\Sortable;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "poll".
 *
 * @property int $id
 * @property string $title
 * @property string $photo
 * @property int $sort
 * @property string $description
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $slug
 * @property int $is_publish
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property PollQuestion[] $pollQuestions
 */
class Poll extends ActiveRecord
{
    public $pollAnswers = [];

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'sortable' => [
                'class' => Sortable::class,
                'query' => self::find(),
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'slugAttribute' => 'slug',
                'immutable' => true,
                'ensureUnique' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'poll';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['sort', 'is_publish', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'photo', 'slug', 'meta_description', 'meta_keywords'], 'string', 'max' => 255],
            ['slug', 'unique'],
            ['description', 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('app', 'Название'),
            'photo' => Yii::t('app', 'Фото'),
            'sort' => 'Sort',
            'description' => Yii::t('app', 'Описание'),
            'slug' => Yii::t('app', 'Ссылка опроса'),
            'meta_description' => Yii::t('app', 'SEO описание'),
            'meta_keywords' => Yii::t('app', 'SEO ключевые слова'),

            'is_publish' => Yii::t('app', 'Опубликовано'),
            'status' => 'Status',
            'type' => Yii::t('app', 'Тип Квиза'),
            'created_at' => Yii::t('app', 'Создан'),
            'updated_at' => Yii::t('app', 'Изменен'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getPollQuestions()
    {
        return $this->hasMany(PollQuestion::class, ['poll_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes) {
        // var_dump($changedAttributes); die;
        parent::afterSave($insert, $changedAttributes);
        $this->saveItems();
    }

    protected function saveItems()
    {
        
    }
}
