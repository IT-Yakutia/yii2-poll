<?php

namespace ityakutia\poll\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ityakutia\poll\models\base\AnswerBase as BaseAnswerBase;

/**
 * AnswerSearch represents the model behind the search form of `common\models\Answer`.
 */
class AnswerSearch extends BaseAnswerBase
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'vote_id', 'vote_user_id', 'question_id', 'option_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['value', 'free_form'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Answer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'vote_id' => $this->vote_id,
            'vote_user_id' => $this->vote_user_id,
            'question_id' => $this->question_id,
            'option_id' => $this->option_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'free_form', $this->free_form]);

        return $dataProvider;
    }

    // указываются свойства, которые нужно выводить в файлы
    public function exportFields()
    {
        return [
            'id' => function ($model) {
                return $model->id;
            },
            'vote_id' => function ($model) {
                if (isset($model->vote->name)) {
                    return $model->vote->name;
                }
                return false;
            },
            'question_id' => function ($model) {
                if (isset($model->question->name)) {
                    return $model->question->name;
                }
                return false;
            },
            'value' => function ($model) {
                return $model->value;
            },
            'free_form' => function ($model) {
                return $model->free_form;
            },
            'option_id' => function ($model) {
                if (isset($model->option->value)) {
                    return $model->option->value;
                }
                return false;
            },
            'vote_user_id' => function ($model) {
                return $model->vote_user_id;
            },
            'created_at' => function ($model) {
                if (isset($model->created_at)) {
                    return Yii::$app->formatter->asDateTime($model->created_at);
                }
                return false;
            },
        ];
    }
}
