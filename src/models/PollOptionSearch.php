<?php

namespace ityakutia\poll\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class PollOptionSearch extends PollOption
{
    public $poll_id;

    public function rules()
    {
        return [
            [['id', 'sort', 'poll_question_id', 'is_publish', 'status', 'created_at', 'updated_at', 'poll_id'], 'integer'],
            [['title'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = PollOption::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['sort'=>SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('pollQuestion');
        // grid filtering conditions
        $query->andFilterWhere([
            'poll_option.id' => $this->id,
            'poll_option.is_publish' => $this->is_publish,
            'poll_id' => $this->poll_id,
            'poll_option.status' => $this->status,
            'poll_option.created_at' => $this->created_at,
            'poll_option.updated_at' => $this->updated_at,
            'poll_option.poll_question_id' => $this->poll_question_id,
            'poll_option.type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'poll_option.title', $this->title]);

        return $dataProvider;
    }
}