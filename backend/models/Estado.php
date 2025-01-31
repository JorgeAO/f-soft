<?php

namespace app\models;

use Yii;

class Estado extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'estado';
    }
    
    public function rules()
    {
        return [
            [['estado_nombre'], 'string', 'max' => 45],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'estado_codigo' => 'Código',
            'estado_nombre' => 'Nombre',
        ];
    }
}
