<?php

namespace app\models;

class Cliente extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'cliente';
    }
    
    public function rules()
    {
        return [
            [['fk_tipo_persona', 'fk_tipo_identificacion', 'fk_estado', 'uc', 'um'], 'integer'],
            [['cliente_identificacion', 'cliente_correo', 'cliente_telefono'], 'required'],
            [['fc', 'fm'], 'safe'],
            [['cliente_identificacion'], 'string', 'max' => 20],
            [['cliente_primer_nombre', 'cliente_segundo_nombre', 'cliente_primer_apellido', 'cliente_segundo_apellido'], 'string', 'max' => 50],
            [['cliente_razon_social', 'cliente_nombre_completo'], 'string', 'max' => 200],
            [['cliente_correo'], 'string', 'max' => 100],
            [['cliente_telefono'], 'string', 'max' => 15],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'cliente_codigo' => 'Código',
            'fk_tipo_persona' => 'Tipo Persona',
            'fk_tipo_identificacion' => 'Tipo Identificación',
            'cliente_identificacion' => 'Identificación',
            'cliente_primer_nombre' => 'Primer Nombre',
            'cliente_segundo_nombre' => 'Segundo Nombre',
            'cliente_primer_apellido' => 'Primer Apellido',
            'cliente_segundo_apellido' => 'Segundo Apellido',
            'cliente_razon_social' => 'Razón Social',
            'cliente_nombre_completo' => 'Nombre Completo',
            'cliente_correo' => 'Correo Electrónico',
            'cliente_telefono' => 'Teléfono',
            'fk_estado' => 'Estado',
            'fc' => 'Fecha de Creación',
            'uc' => 'Usuario de Creación',
            'fm' => 'Fecha de Modificación',
            'um' => 'Usuario de Modificación',
        ];
    }
}
