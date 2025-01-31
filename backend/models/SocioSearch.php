<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Socio;

/**
 * SocioSearch represents the model behind the search form of `app\models\Socio`.
 */
class SocioSearch extends Socio
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['socio_codigo', 'fk_tipo_persona', 'fk_tipo_identificacion', 'fk_estado', 'uc', 'um'], 'integer'],
            [['socio_identificacion', 'socio_primer_nombre', 'socio_segundo_nombre', 'socio_primer_apellido', 'socio_segundo_apellido', 'socio_razon_social', 'socio_nombre_completo', 'socio_correo', 'socio_telefono', 'fc', 'fm'], 'safe'],
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
        $query = Socio::find();

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
            'socio_codigo' => $this->socio_codigo,
            'fk_tipo_persona' => $this->fk_tipo_persona,
            'fk_tipo_identificacion' => $this->fk_tipo_identificacion,
            'fk_estado' => $this->fk_estado,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'socio_identificacion', $this->socio_identificacion])
            ->andFilterWhere(['like', 'socio_primer_nombre', $this->socio_primer_nombre])
            ->andFilterWhere(['like', 'socio_segundo_nombre', $this->socio_segundo_nombre])
            ->andFilterWhere(['like', 'socio_primer_apellido', $this->socio_primer_apellido])
            ->andFilterWhere(['like', 'socio_segundo_apellido', $this->socio_segundo_apellido])
            ->andFilterWhere(['like', 'socio_razon_social', $this->socio_razon_social])
            ->andFilterWhere(['like', 'socio_nombre_completo', $this->socio_nombre_completo])
            ->andFilterWhere(['like', 'socio_correo', $this->socio_correo])
            ->andFilterWhere(['like', 'socio_telefono', $this->socio_telefono]);

        return $dataProvider;
    }
}
