<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UsuarioSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="usuario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'usuario_codigo') ?>

    <?= $form->field($model, 'fk_perfil') ?>

    <?= $form->field($model, 'usuario_primer_nombre') ?>

    <?= $form->field($model, 'usuario_segundo_nombre') ?>

    <?= $form->field($model, 'usuario_primer_apellido') ?>

    <?php // echo $form->field($model, 'usuario_segundo_apellido') ?>

    <?php // echo $form->field($model, 'usuario_nombre_completo') ?>

    <?php // echo $form->field($model, 'usuario_telefono') ?>

    <?php // echo $form->field($model, 'usuario_correo') ?>

    <?php // echo $form->field($model, 'usuario_clave') ?>

    <?php // echo $form->field($model, 'fk_estado') ?>

    <?php // echo $form->field($model, 'fc') ?>

    <?php // echo $form->field($model, 'uc') ?>

    <?php // echo $form->field($model, 'fm') ?>

    <?php // echo $form->field($model, 'um') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
