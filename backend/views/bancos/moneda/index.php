<?php
use app\models\Estado;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Monedas';
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
                    'moneda_codigo',
                    'moneda_nombre',
                    'moneda_iso',
                    [
                        'label'=>'Estado',
                        'value'=>function($data) {
                            return Estado::find()->where(['estado_codigo'=>$data->fk_estado])->all()[0]->estado_nombre;
                        },
                        'attribute'=>'fk_estado',
                    ],
                    [
                        'label'=>'Opciones',
                        'format'=>'raw',
                        'value'=> function($data) {
                            $strOpciones = '';
                            $strOpciones = 
                                '<div class="btn-group" role="group" aria-label="Basic example">'.
                                Html::a('<i class="fa fa-eye"></i>', ['view', 'moneda_codigo' => $data->moneda_codigo], ['class' => 'btn btn-sm btn-personalizado', 'title'=>'Ver Detalles']).
                                Html::a('<i class="fa fa-pencil-alt"></i>', ['update', 'moneda_codigo' => $data->moneda_codigo], ['class' => 'btn btn-sm btn-personalizado', 'title'=>'Editar']).
                                Html::a('<i class="fa fa-trash"></i>', ['delete', 'moneda_codigo' => $data->moneda_codigo], [
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