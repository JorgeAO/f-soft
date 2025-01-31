<?php

namespace app\models;

class Perfil extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'perfil';
    }
    
    public function rules()
    {
        return [
            [['perfil_nombre'], 'required'],
            [['fk_estado', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['perfil_nombre'], 'string', 'max' => 45],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'perfil_codigo' => 'Código',
            'perfil_nombre' => 'Nombre',
            'fk_estado' => 'Estado',
            'fc' => 'Fecha de Creación',
            'uc' => 'Usuario de Creación',
            'fm' => 'Fecha de Modificación',
            'um' => 'Usuario de Modificación',
        ];
    }
}
