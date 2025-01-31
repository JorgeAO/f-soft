<?php
use app\models\Estado;
use app\models\Perfil;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card border-light">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <div class="card-title">
                    <h6><?= $this->title?></h6>
                </div>
            </div>
            <div class="col-sm-4 d-flex justify-content-end">
                <?= Html::a('<i class="fa fa-plus"></i> Agregar', ['create'], ['class' => 'btn btn-sm btn-personalizado']) ?>
            </div>
        </div>
        <div class="row">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-hover table-sm'],
                'columns' => [
                    'usuario_codigo',
                    [
                        'label'=>'Perfil',
                        'value'=>function($data) {
                            return Perfil::find()->where(['perfil_codigo'=>$data->fk_perfil])->all()[0]->perfil_nombre;
                        },
                        'attribute'=>'fk_perfil',
                        'filter'=>ArrayHelper::map(Perfil::find()->asArray()->all(), 'perfil_codigo', 'perfil_nombre'),
                    ],
                    'usuario_nombre_completo',
                    'usuario_telefono',
                    'usuario_correo',
                    [
                        'label'=>'Estado',
                        'value'=>function($data) {
                            return Estado::find()->where(['estado_codigo'=>$data->fk_estado])->all()[0]->estado_nombre;
                        },
                        'attribute'=>'fk_estado',
                        'filter'=>ArrayHelper::map(Estado::find()->asArray()->all(), 'estado_codigo', 'estado_nombre'),
                    ],
                    [
                        'label'=>'Opciones',
                        'format'=>'raw',
                        'value'=> function($data) {
                            $strOpciones = '';
                            $strOpciones = 
                                '<div class="btn-group" role="group" aria-label="Basic example">'.
                                Html::a('<i class="fa fa-eye"></i>', ['view', 'usuario_codigo' => $data->usuario_codigo], ['class' => 'btn btn-sm btn-personalizado', 'title'=>'Ver Detalles']).
                                Html::a('<i class="fa fa-key"></i>', ['cambiar-clave-usuario', 'usuario_codigo' => $data->usuario_codigo], ['class' => 'btn btn-sm btn-personalizado', 'title'=>'Cambiar Clave']).
                                Html::a('<i class="fa fa-pencil-alt"></i>', ['update', 'usuario_codigo' => $data->usuario_codigo], ['class' => 'btn btn-sm btn-personalizado', 'title'=>'Editar']).
                                Html::a('<i class="fa fa-trash"></i>', ['delete', 'usuario_codigo' => $data->usuario_codigo], [
                                    'class' => 'btn btn-sm btn-secondary',
                                    'title'=>'Eliminar',
                                    'data' => [
                                        'confirm' => '¿Está seguro que desea eliminar el registro?',
                                        'method' => 'post',
                                    ],
                                ]).
                                '</div>'
                                ;
        
                            return $strOpciones;
                        }
                    ]
                ],
            ]); ?>
        </div>
    </div>
</div>