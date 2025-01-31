<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TipoPersonaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tipo-persona-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tipopers_codigo') ?>

    <?= $form->field($model, 'tipopers_nombre') ?>

    <?= $form->field($model, 'fk_estado') ?>

    <?= $form->field($model, 'fc') ?>

    <?= $form->field($model, 'uc') ?>

    <?php // echo $form->field($model, 'fm') ?>

    <?php // echo $form->field($model, 'um') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
