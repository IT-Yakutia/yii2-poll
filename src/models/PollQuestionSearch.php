<?php

namespace ityakutia\poll\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PollQuestionSearch extends PollQuestion
{
    public function rules()
    {
        return [
            [['id', 'sort', 'is_publish', 'is_multi_select', 'status', 'created_at', 'updated_at', 'poll_id'], 'integer'],
            [['title', 'description'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = PollQuestion::find()->where(['poll_id' => $params['id']]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['sort' => SORT_ASC]],
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
            'is_publish' => $this->is_publish,
            'is_multi_select' => $this->is_multi_select,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
