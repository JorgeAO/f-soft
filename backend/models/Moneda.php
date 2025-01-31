<?php

namespace app\models;

class Moneda extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'moneda';
    }
    
    public function rules()
    {
        return [
            [['moneda_nombre', 'moneda_iso'], 'required'],
            [['fk_estado', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['moneda_nombre'], 'string', 'max' => 100],
            [['moneda_iso'], 'string', 'max' => 5],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'moneda_codigo' => 'Código',
            'moneda_nombre' => 'Nombre',
            'moneda_iso' => 'Código ISO',
            'fk_estado' => 'Estado',
            'fc' => 'Fecha de Creación',
            'uc' => 'Usuario de Creación',
            'fm' => 'Fecha de Modificación',
            'um' => 'Usuario de Modificación',
        ];
    }
}
