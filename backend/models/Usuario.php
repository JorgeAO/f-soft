<?php

namespace app\models;

use Yii;

class Usuario extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'usuario';
    }
    
    public function rules()
    {
        return [
            [['usuario_primer_nombre', 'usuario_primer_apellido', 'usuario_correo', 'usuario_clave'], 'required'],
            [['fk_estado', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['fk_perfil', 'usuario_primer_nombre', 'usuario_segundo_nombre', 'usuario_primer_apellido', 'usuario_segundo_apellido'], 'string', 'max' => 45],
            [['usuario_nombre_completo'], 'string', 'max' => 200],
            [['usuario_telefono'], 'string', 'max' => 10],
            [['usuario_correo', 'usuario_clave'], 'string', 'max' => 100],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'usuario_codigo' => 'Código',
            'fk_perfil' => 'Perfil',
            'usuario_primer_nombre' => 'Primer Nombre',
            'usuario_segundo_nombre' => 'Segundo Nombre',
            'usuario_primer_apellido' => 'Primer Apellido',
            'usuario_segundo_apellido' => 'Segundo Apellido',
            'usuario_nombre_completo' => 'Nombre Completo',
            'usuario_telefono' => 'Teléfono',
            'usuario_correo' => 'Correo Electrónico',
            'usuario_clave' => 'Clave',
            'fk_estado' => 'Estado',
            'fc' => 'Fecha de Creación',
            'uc' => 'Usuario de Creación',
            'fm' => 'Fecha de Modificación',
            'um' => 'Usuario de Modificación',
        ];
    }
}
