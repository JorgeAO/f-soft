<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Moneda;

/**
 * MonedaSearch represents the model behind the search form of `app\models\Moneda`.
 */
class MonedaSearch extends Moneda
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['moneda_codigo', 'fk_estado', 'uc', 'um'], 'integer'],
            [['moneda_nombre', 'moneda_iso', 'fc', 'fm'], 'safe'],
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
        $query = Moneda::find();

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
            'moneda_codigo' => $this->moneda_codigo,
            'fk_estado' => $this->fk_estado,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'moneda_nombre', $this->moneda_nombre])
            ->andFilterWhere(['like', 'moneda_iso', $this->moneda_iso]);

        return $dataProvider;
    }
}
