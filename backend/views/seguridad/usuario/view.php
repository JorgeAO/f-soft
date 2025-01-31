<?php
use app\models\Estado;
use app\models\Perfil;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->usuario_codigo.' - '.$model->usuario_nombre_completo;
$this->params['breadcrumbs'][] = ['label' => 'Perfiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="card border-light">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-title">
                    <h6>Detalles del Perfil: <?= $this->title?></h6>
                    <p>
                        <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['index'], ['class' => 'btn btn-sm btn-personalizado']) ?>
                        <?= Html::a('<i class="fa fa-plus"></i> Agregar', ['create'], ['class' => 'btn btn-personalizado btn-sm']) ?>
                        <?= Html::a('<i class="fa fa-pencil-alt"></i> Editar', ['update', 'usuario_codigo' => $model->usuario_codigo], ['class' => 'btn btn-sm btn-personalizado']) ?>
                        <?= Html::a('<i class="fa fa-trash"></i> Eliminar', ['delete', 'usuario_codigo' => $model->usuario_codigo], [
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
                    'options' => ['class' => 'table table-striped table-hover table-sm'],
                    'attributes' => [
                        'usuario_codigo',
                        [
                            'label'=>'Perfil',
                            'value'=>function($data){
                                return Perfil::find()->where(['perfil_codigo'=>$data->fk_perfil])->all()[0]->perfil_nombre;
                            }
                        ],
                        'usuario_primer_nombre',
                        'usuario_segundo_nombre',
                        'usuario_primer_apellido',
                        'usuario_segundo_apellido',
                        'usuario_nombre_completo',
                        'usuario_telefono',
                        'usuario_correo',
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