<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Permiso;

/**
 * PermisoSearch represents the model behind the search form of `app\models\Permiso`.
 */
class PermisoSearch extends Permiso
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['permiso_codigo', 'fk_perfil', 'fk_opcion', 'c', 'r', 'u', 'd', 'v', 'l', 'm'], 'integer'],
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
        $query = Permiso::find();

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
            'permiso_codigo' => $this->permiso_codigo,
            'fk_perfil' => $this->fk_perfil,
            'fk_opcion' => $this->fk_opcion,
            'c' => $this->c,
            'r' => $this->r,
            'u' => $this->u,
            'd' => $this->d,
            'v' => $this->v,
            'l' => $this->l,
            'm' => $this->m,
        ]);

        return $dataProvider;
    }
}
