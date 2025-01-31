<?php

namespace app\models;

class TipoPersona extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tipo_persona';
    }
    
    public function rules()
    {
        return [
            [['tipopers_nombre'], 'required'],
            [['fk_estado', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['tipopers_nombre'], 'string', 'max' => 100],
        ];
    }
    public function attributeLabels()
    {
        return [
            'tipopers_codigo' => 'Código',
            'tipopers_nombre' => 'Nombre',
            'fk_estado' => 'Estado',
            'fc' => 'Fecha de Creación',
            'uc' => 'Usuario de Creación',
            'fm' => 'Fecha de Modificación',
            'um' => 'Usuario de Modificación',
        ];
    }
}
