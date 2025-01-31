<?php
use app\models\Estado;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->moneda_codigo.' - '.$model->moneda_nombre;
$this->params['breadcrumbs'][] = ['label' => 'Monedas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="card border-light">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-title">
                    <h6>Detalles de la Moneda: <?= $this->title?></h6>
                    <p>
                        <?= Html::a('<i class="fa fa-arrow-left"></i> Volver', ['index'], ['class' => 'btn btn-sm btn-personalizado']) ?>
                        <?= Html::a('<i class="fa fa-plus"></i> Agregar', ['create'], ['class' => 'btn btn-personalizado btn-sm']) ?>
                        <?= Html::a('<i class="fa fa-pencil-alt"></i> Editar', ['update', 'moneda_codigo' => $model->moneda_codigo], ['class' => 'btn btn-sm btn-personalizado']) ?>
                        <?= Html::a('<i class="fa fa-trash"></i> Eliminar', ['delete', 'moneda_codigo' => $model->moneda_codigo], [
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
                        'moneda_codigo',
                        'moneda_nombre',
                        'moneda_iso',
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