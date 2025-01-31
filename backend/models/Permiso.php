<?php

namespace app\models;

use Yii;

class Permiso extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'permiso';
    }
    
    public function rules()
    {
        return [
            [['fk_perfil', 'fk_opcion'], 'required'],
            [['fk_perfil', 'fk_opcion', 'c', 'r', 'u', 'd', 'v', 'l', 'm'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'permiso_codigo' => 'Código',
            'fk_perfil' => 'Perfil',
            'fk_opcion' => 'Opción',
            'c' => 'Crear',
            'r' => 'Consultar',
            'u' => 'Editar',
            'd' => 'Eliminar',
            'v' => 'Ver',
            'l' => 'Listar',
        ];
    }
}
