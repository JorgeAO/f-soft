<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuario;

/**
 * UsuarioSearch represents the model behind the search form of `app\models\Usuario`.
 */
class UsuarioSearch extends Usuario
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_codigo', 'fk_estado', 'uc', 'um'], 'integer'],
            [['fk_perfil', 'usuario_primer_nombre', 'usuario_segundo_nombre', 'usuario_primer_apellido', 'usuario_segundo_apellido', 'usuario_nombre_completo', 'usuario_telefono', 'usuario_correo', 'usuario_clave', 'fc', 'fm'], 'safe'],
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
        $query = Usuario::find();

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
            'usuario_codigo' => $this->usuario_codigo,
            'fk_estado' => $this->fk_estado,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'fk_perfil', $this->fk_perfil])
            ->andFilterWhere(['like', 'usuario_primer_nombre', $this->usuario_primer_nombre])
            ->andFilterWhere(['like', 'usuario_segundo_nombre', $this->usuario_segundo_nombre])
            ->andFilterWhere(['like', 'usuario_primer_apellido', $this->usuario_primer_apellido])
            ->andFilterWhere(['like', 'usuario_segundo_apellido', $this->usuario_segundo_apellido])
            ->andFilterWhere(['like', 'usuario_nombre_completo', $this->usuario_nombre_completo])
            ->andFilterWhere(['like', 'usuario_telefono', $this->usuario_telefono])
            ->andFilterWhere(['like', 'usuario_correo', $this->usuario_correo])
            ->andFilterWhere(['like', 'usuario_clave', $this->usuario_clave]);

        return $dataProvider;
    }
}
