<?php
$this->title = $model->usuario_codigo.' - '.$model->usuario_nombre_completo;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card border-light mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-title">
                    <h6>Editar Usuario: <?= $this->title?></h6>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data,
    ]) ?>
</div>