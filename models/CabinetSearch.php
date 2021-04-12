<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cabinet;

/**
 * CabinetSearch represents the model behind the search form of `app\models\Cabinet`.
 */
class CabinetSearch extends Cabinet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['api_key', 'date_end', 'name', 'short_name', 'counterparty', 'contact_person', 'recipient_counterparty', 'town', 'dispatch_dep'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Cabinet::find();

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
            'date_end' => $this->date_end,
        ]);

        $query->andFilterWhere(['like', 'api_key', $this->api_key])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'short_name', $this->short_name])
            ->andFilterWhere(['like', 'counterparty', $this->counterparty])
            ->andFilterWhere(['like', 'contact_person', $this->contact_person])
            ->andFilterWhere(['like', 'recipient_counterparty', $this->recipient_counterparty])
            ->andFilterWhere(['like', 'town', $this->town])
            ->andFilterWhere(['like', 'dispatch_dep', $this->dispatch_dep]);

        return $dataProvider;
    }
}
