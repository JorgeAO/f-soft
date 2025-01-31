<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Cambiar Mi Clave';
$this->params['breadcrumbs'][] = ['label' => 'Cambiar Mi Clave', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(); ?>
    <div class="card border-light mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-title">
                        <h6><?= $this->title?></h6>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <?= $form->field($model, 'usuario_clave')->passwordInput(['class' => 'form-control form-control-sm']) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'usuario_nueva_clave')->passwordInput(['class' => 'form-control form-control-sm']) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'usuario_confirmar_nueva_clave')->passwordInput(['class' => 'form-control form-control-sm']) ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <?= Html::submitButton('<i class="fa fa-save"></i> Guardar', ['class' => 'btn btn-sm btn-personalizado']) ?>
                            <?= Html::a('<i class="fa fa-times"></i>  Cancelar', ['index'], ['class' => 'btn btn-sm btn-secondary']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php
                if (isset($data))
                {
                    $icono = "";
                    $clase = "";

                    switch ($data["error"]) {
                        case true:
                            $icono = "times-circle";
                            $class = "danger";
                            break;
                        case false:
                            $icono = "check-circle";
                            $class = "success";
                            break;
                        default:
                            $icono = "info-circle";
                            $class = "info";
                            break;
                    }
                    ?>
                    <div class="alert alert-<?=$class?>" role="alert">
                        <i class="fa fa-<?=$icono?>"></i> <?=$data['mensaje'] ?>
                    </div>
            <?php 
                } 
            ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>