<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Iniciar Sesión';
?>

<div class="row">
    <div class="col-sm-4 offset-4">
        <div class="text-center">
            <h4><?= Yii::$app->name ?></h4>
        </div>
        <div class="card border-light mb-3">
            <div class="card-body">
                <div class="card-title">
                    <h6><?= $this->title?></h6>
                </div>
                <div class="col-sm-12">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                    <?= $form->field($usuario, 'usuario_correo')->textInput(['autofocus' => true, 'class' => 'form-control form-control-sm']) ?>
                    <?= $form->field($usuario, 'usuario_clave')->passwordInput(['class'=>'form-control form-control-sm']) ?>
                    <div class="form-group">
                        <?= Html::submitButton('<i class="fa fa-sign-in-alt></i> Entrar', ['class' => 'btn btn-primary btn-sm', 'name' => 'login-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <?php
                if (isset($data))
                {
                    if ($data['error']) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?= '<i class="times-circle></i> '.$data['mensaje'] ?>
                        </div>
                    <?php }
                }
            ?>
        </div>
    </div>
</div>