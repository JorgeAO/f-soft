<?php
use app\models\Estado;
use app\models\TipoIdentificacion;
use app\models\TipoPersona;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Socios';
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
            <?php echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-hover table-sm'],
                'columns' => [
                    'socio_codigo',
                    [
                        'label'=>'Tipo Persona',
                        'value'=>function($data) {
                            return TipoPersona::find()->where(['tipopers_codigo'=>$data->fk_estado])->all()[0]->tipopers_nombre;
                        },
                        'attribute'=>'fk_tipo_persona',
                        'filter'=>ArrayHelper::map(TipoPersona::find()->asArray()->all(), 'tipopers_codigo', 'tipopers_nombre'),
                    ],
                    [
                        'label'=>'Tipo Identificación',
                        'value'=>function($data) {
                            return TipoIdentificacion::find()->where(['tipoiden_codigo'=>$data->fk_estado])->all()[0]->tipoiden_nombre;
                        },
                        'attribute'=>'fk_tipo_identificacion',
                        'filter'=>ArrayHelper::map(TipoIdentificacion::find()->asArray()->all(), 'tipoiden_codigo', 'tipoiden_nombre'),
                    ],
                    'socio_identificacion',
                    'socio_nombre_completo',
                    'socio_correo',
                    'socio_telefono',
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
                                Html::a('<i class="fa fa-eye"></i>', ['view', 'socio_codigo' => $data->socio_codigo], ['class' => 'btn btn-sm btn-personalizado', 'title'=>'Ver Detalles']).
                                Html::a('<i class="fa fa-pencil-alt"></i>', ['update', 'socio_codigo' => $data->socio_codigo], ['class' => 'btn btn-sm btn-personalizado', 'title'=>'Editar']).
                                Html::a('<i class="fa fa-trash"></i>', ['delete', 'socio_codigo' => $data->socio_codigo], [
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