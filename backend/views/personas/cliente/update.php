<?php
$this->title = $model->cliente_codigo.' - '.$model->cliente_nombre_completo;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card border-light">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-title">
                    <h6>Editar Cliente: <?= $this->title?></h6>
                </div>
            </div>
        </div>
        <div class="row">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>