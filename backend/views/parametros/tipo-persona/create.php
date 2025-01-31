<?php
$this->title = 'Agregar Tipo de Persona';
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Persona', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card border-light">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-title">
                    <h6><?= $this->title?></h6>
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