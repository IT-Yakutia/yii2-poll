<?php


namespace ityakutia\poll\models;


use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;
use uraankhayayaal\sortable\behaviors\Sortable;

/**
 * This is the model class for table "poll_question".
 *
 * @property int $id
 * @property string $title
 * @property int $type
 * @property int $sort
 * @property int $poll_id
 * @property int $is_publish
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property PollOption[] $pollOptions
 * @property Poll $poll
 */
class PollQuestion extends ActiveRecord
{
    public $options = [];

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
        return 'poll_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'poll_id'], 'required'],
            [['sort', 'poll_id', 'is_publish', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['poll_id'], 'exist', 'skipOnError' => true, 'targetClass' => Poll::class, 'targetAttribute' => ['poll_id' => 'id']],
            [['options'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('app','Вопрос'),
            'description' => Yii::t('app','описание'),
            'sort' => 'Sort',
            'poll_id' => Yii::t('app','Опрос'),
            'is_publish' => Yii::t('app','Опубликовать'),
            'status' => 'Status',
            'created_at' => Yii::t('app','Создан'),
            'updated_at' => Yii::t('app','Изменен'),
        ];
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        $this->saveItems();
    }

    protected function saveItems(){
        $hasErrors = false;
        foreach ($this->options as $key => $item) {
            if( $item['title'] == null ){
                if(isset($item['id']))
                    PollOption::findOne($item['id'])->delete();
                continue;
            };
            $model = new PollOption();
            // Check is model a new record
            if(isset($item['id'])){
                $query = PollOption::find()->where(['id' => $item['id'], 'poll_question_id' => $this->id]);
                if($query->exists()){
                    $model = $query->one();
                }
            }
            $model->title = $item['title'];
            $model->sort = isset($item['sort']) ? $item['sort'] : null;
            $model->poll_question_id = $this->id;
            if($model->validate()){
                $model->save();
            }else{
                $hasErrors = true;
            }
        }
        return !$hasErrors;
    }

    /**
     * @return ActiveQuery
     */
    public function getPollOptions()
    {
        return $this->hasMany(PollOption::class, ['poll_question_id' => 'id']);
    }

    public function getPollOptionsCount()
    {
        return $this->hasMany(PollOption::class, ['poll_question_id' => 'id'])->count();
    }

    /**
     * @return ActiveQuery
     */
    public function getPoll()
    {
        return $this->hasOne(Poll::class, ['id' => 'poll_id']);
    }
}
