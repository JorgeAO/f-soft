<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SocioSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="socio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'socio_codigo') ?>

    <?= $form->field($model, 'fk_tipo_persona') ?>

    <?= $form->field($model, 'fk_tipo_identificacion') ?>

    <?= $form->field($model, 'socio_identificacion') ?>

    <?= $form->field($model, 'socio_primer_nombre') ?>

    <?php // echo $form->field($model, 'socio_segundo_nombre') ?>

    <?php // echo $form->field($model, 'socio_primer_apellido') ?>

    <?php // echo $form->field($model, 'socio_segundo_apellido') ?>

    <?php // echo $form->field($model, 'socio_razon_social') ?>

    <?php // echo $form->field($model, 'socio_nombre_completo') ?>

    <?php // echo $form->field($model, 'socio_correo') ?>

    <?php // echo $form->field($model, 'socio_telefono') ?>

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
