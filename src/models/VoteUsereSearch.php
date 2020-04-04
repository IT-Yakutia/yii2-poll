<?php

namespace ityakutia\poll\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use ityakutia\poll\models\base\VoteUserBase;

/**
 * VoteUsereSearch represents the model behind the search form of `common\models\VoteUser`.
 */
class VoteUsereSearch extends VoteUserBase
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vote_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['ip', 'hash'], 'safe'],
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
        $query = VoteUser::find();

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
            'vote_id' => $this->vote_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'hash', $this->hash]);

        return $dataProvider;
    }
}
