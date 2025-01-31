<?php

namespace app\models;

use Yii;

class CambioClave extends \yii\db\ActiveRecord
{
    public $usuario_codigo;
    public $usuario_nombre_completo;
    public $usuario_clave;
    public $usuario_nueva_clave;
    public $usuario_confirmar_nueva_clave;
    
    public function rules()
    {
        return [
            [['usuario_clave', 'usuario_nueva_clave', 'usuario_confirmar_nueva_clave'], 'required'],
            [['usuario_clave', 'usuario_nueva_clave', 'usuario_confirmar_nueva_clave'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'usuario_codigo' => 'Código',
            'usuario_clave' => 'Clave Actual',
            'usuario_nueva_clave' => 'Nueva Clave',
            'usuario_confirmar_nueva_clave' => 'Confirmar Nueva Clave',
        ];
    }
}

?>