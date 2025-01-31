<?php

namespace app\models;

class Socio extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'socio';
    }
    
    public function rules()
    {
        return [
            [['socio_identificacion', 'socio_correo', 'socio_telefono'], 'required'],
            [['fk_tipo_persona', 'fk_tipo_identificacion', 'fk_estado', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['socio_identificacion'], 'string', 'max' => 20],
            [['socio_primer_nombre', 'socio_segundo_nombre', 'socio_primer_apellido', 'socio_segundo_apellido'], 'string', 'max' => 50],
            [['socio_razon_social', 'socio_nombre_completo'], 'string', 'max' => 200],
            [['socio_correo'], 'string', 'max' => 100],
            [['socio_telefono'], 'string', 'max' => 15],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'socio_codigo' => 'Código',
            'fk_tipo_persona' => 'Tipo Persona',
            'fk_tipo_identificacion' => 'Tipo Identificación',
            'socio_identificacion' => 'Identificación',
            'socio_primer_nombre' => 'Primer Nombre',
            'socio_segundo_nombre' => 'Segundo Nombre',
            'socio_primer_apellido' => 'Primer Apellido',
            'socio_segundo_apellido' => 'Segundo Apellido',
            'socio_razon_social' => 'Razón Social',
            'socio_nombre_completo' => 'Nombre Completo',
            'socio_correo' => 'Correo Electrónico',
            'socio_telefono' => 'Teléfono',
            'fk_estado' => 'Estado',
            'fc' => 'Fecha de Creación',
            'uc' => 'Usuario de Creación',
            'fm' => 'Fecha de Modificación',
            'um' => 'Usuario de Modificación',
        ];
    }
}
