<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TipoIdentificacion;

/**
 * TipoIdentificacionSearch represents the model behind the search form of `app\models\TipoIdentificacion`.
 */
class TipoIdentificacionSearch extends TipoIdentificacion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipoiden_codigo', 'fk_estado', 'uc', 'um'], 'integer'],
            [['tipoiden_nombre', 'fc', 'fm'], 'safe'],
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
        $query = TipoIdentificacion::find();

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
            'tipoiden_codigo' => $this->tipoiden_codigo,
            'fk_estado' => $this->fk_estado,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'tipoiden_nombre', $this->tipoiden_nombre]);

        return $dataProvider;
    }
}
