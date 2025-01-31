<?php
$this->title = $model->perfil_codigo.' - '.$model->perfil_nombre;
$this->params['breadcrumbs'][] = ['label' => 'Perfiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card border-light">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-title">
                    <h6>Editar Perfil: <?= $this->title?></h6>
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