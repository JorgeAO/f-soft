<?php

namespace app\models;

class Categoria extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'categoria';
    }
    
    public function rules()
    {
        return [
            [['categoria_nombre'], 'required'],
            [['fk_estado', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['categoria_nombre'], 'string', 'max' => 100],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'categoria_codigo' => 'Código',
            'categoria_nombre' => 'Nombre',
            'fk_estado' => 'Estado',
            'fc' => 'Fecha de Creación',
            'uc' => 'Usuario de Creación',
            'fm' => 'Fecha de Modificación',
            'um' => 'Usuario de Modificación',
        ];
    }
}
