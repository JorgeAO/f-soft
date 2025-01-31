<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cliente;

/**
 * ClienteSearch represents the model behind the search form of `app\models\Cliente`.
 */
class ClienteSearch extends Cliente
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cliente_codigo', 'fk_tipo_persona', 'fk_tipo_identificacion', 'fk_estado', 'uc', 'um'], 'integer'],
            [['cliente_identificacion', 'cliente_primer_nombre', 'cliente_segundo_nombre', 'cliente_primer_apellido', 'cliente_segundo_apellido', 'cliente_razon_social', 'cliente_nombre_completo', 'cliente_correo', 'cliente_telefono', 'fc', 'fm'], 'safe'],
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
        $query = Cliente::find();

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
            'cliente_codigo' => $this->cliente_codigo,
            'fk_tipo_persona' => $this->fk_tipo_persona,
            'fk_tipo_identificacion' => $this->fk_tipo_identificacion,
            'fk_estado' => $this->fk_estado,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'cliente_identificacion', $this->cliente_identificacion])
            ->andFilterWhere(['like', 'cliente_primer_nombre', $this->cliente_primer_nombre])
            ->andFilterWhere(['like', 'cliente_segundo_nombre', $this->cliente_segundo_nombre])
            ->andFilterWhere(['like', 'cliente_primer_apellido', $this->cliente_primer_apellido])
            ->andFilterWhere(['like', 'cliente_segundo_apellido', $this->cliente_segundo_apellido])
            ->andFilterWhere(['like', 'cliente_razon_social', $this->cliente_razon_social])
            ->andFilterWhere(['like', 'cliente_nombre_completo', $this->cliente_nombre_completo])
            ->andFilterWhere(['like', 'cliente_correo', $this->cliente_correo])
            ->andFilterWhere(['like', 'cliente_telefono', $this->cliente_telefono]);

        return $dataProvider;
    }
}
