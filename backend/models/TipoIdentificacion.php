<?php

namespace app\models;

class TipoIdentificacion extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tipo_identificacion';
    }

    public function rules()
    {
        return [
            [['tipoiden_nombre'], 'required'],
            [['fk_estado', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['tipoiden_nombre'], 'string', 'max' => 100],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'tipoiden_codigo' => 'Código',
            'tipoiden_nombre' => 'Nombre',
            'fk_estado' => 'Estado',
            'fc' => 'Fecha de Creación',
            'uc' => 'Usuario de Creación',
            'fm' => 'Fecha de Modificación',
            'um' => 'Usuario de Modificación',
        ];
    }
}
