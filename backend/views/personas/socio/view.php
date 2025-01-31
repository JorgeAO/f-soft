<?php
use app\models\Estado;
use app\models\TipoIdentificacion;
use app\models\TipoPersona;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->socio_codigo.' - '.$model->socio_nombre_completo;
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="card border-light">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-title">
                    <h6>Detalles del Socio: <?= $this->title?></h6>
                    <p>
                        <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['index'], ['class' => 'btn btn-sm btn-personalizado']) ?>
                        <?= Html::a('<i class="fa fa-plus"></i> Agregar', ['create'], ['class' => 'btn btn-personalizado btn-sm']) ?>
                        <?= Html::a('<i class="fa fa-pencil-alt"></i> Editar', ['update', 'socio_codigo' => $model->socio_codigo], ['class' => 'btn btn-sm btn-personalizado']) ?>
                        <?= Html::a('<i class="fa fa-trash"></i> Eliminar', ['delete', 'socio_codigo' => $model->socio_codigo], [
                            'class' => 'btn btn-sm btn-secondary',
                            'data' => [
                                'confirm' => '¿Está seguro que desea eliminar el registro?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                </div>
            </div>
            <div class="col-sm-6">
                <?= DetailView::widget([
                    'model' => $model,
                    'options' => ['class' => 'table table-hover table-sm'],
                    'attributes' => [
                        'socio_codigo',
                        [
                            'label'=>'Tipo Persona',
                            'value'=>function($data){
                                return TipoPersona::find()->where(['tipopers_codigo'=>$data->fk_tipo_persona])->all()[0]->tipopers_nombre;
                            }
                        ],
                        [
                            'label'=>'Tipo Identificación',
                            'value'=>function($data){
                                return TipoIdentificacion::find()->where(['tipoiden_codigo'=>$data->fk_tipo_identificacion])->all()[0]->tipoiden_nombre;
                            }
                        ],
                        'socio_identificacion',
                        'socio_nombre_completo',
                        'socio_correo',
                        'socio_telefono',
                        [
                            'label'=>'Estado',
                            'value'=>function($data){
                                return Estado::find()->where(['estado_codigo'=>$data->fk_estado])->all()[0]->estado_nombre;
                            }
                        ],
                        'fc',
                        'uc',
                        'fm',
                        'um',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>