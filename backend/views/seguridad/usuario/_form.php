<?php
use app\models\Estado;
use app\models\Perfil;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>
    <div class="row mb-3">
        <div class="col-sm-4">
            <div class="card border-light">
                <div class="card-body">
                    <div class="card-title">
                        <h6>Información Básica</h6>
                    </div>
                    <div class="col-sm-12 mb-2">
                        <?= $form->field($model, 'usuario_primer_nombre')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-sm-12 mb-2">
                        <?= $form->field($model, 'usuario_segundo_nombre')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-sm-12 mb-2">
                        <?= $form->field($model, 'usuario_primer_apellido')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-sm-12 mb-2">
                        <?= $form->field($model, 'usuario_segundo_apellido')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card border-light">
                <div class="card-body">
                    <div class="card-title">
                        <h6>Información del Usuario</h6>
                    </div>
                    <div class="col-sm-12 mb-2">
                        <?php 
                            if (!isset($model->usuario_codigo)) {
                                echo $form->field($model, 'usuario_correo')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']);
                            }
                            else {
                                echo '<label for="usuario_correo">Correo Electrónico</label>';
                                echo '<p>'.$model->usuario_correo.'</p>';
                            }
                        ?>
                    </div>
                    <div class="col-sm-12 mb-2">
                        <?php 
                            if (!isset($model->usuario_codigo))
                                echo $form->field($model, 'usuario_clave')->passwordInput(['maxlength' => true, 'class' => 'form-control form-control-sm']); 
                        ?>
                    </div>
                    <div class="col-sm-12 mb-2">
                        <?= $form->field($model, 'fk_perfil')->dropDownList(ArrayHelper::map(Perfil::find()->asArray()->all(), 'perfil_codigo', 'perfil_nombre'), ['class' => 'form-select form-select-sm']) ?>
                    </div>
                    <div class="col-sm-12 mb-2">
                        <?php 
                            if (isset($model->usuario_codigo))
                                echo $form->field($model, 'fk_estado')->dropDownList(ArrayHelper::map(Estado::find()->asArray()->all(), 'estado_codigo', 'estado_nombre'), ['class' => 'form-select form-select-sm']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card border-light">
                <div class="card-body">
                    <div class="card-title">
                        <h6>Información Adicional</h6>
                    </div>
                    <div class="col-sm-12">
                        <?= $form->field($model, 'usuario_telefono')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-12">
            <div class="card border-light">
                <div class="card-body">
                    <?= Html::submitButton('<i class="fa fa-save"></i> Guardar', ['class' => 'btn btn-sm btn-personalizado']) ?>
                    <?= Html::a('<i class="fa fa-times"></i>  Cancelar', ['index'], ['class' => 'btn btn-sm btn-secondary']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php
                if (isset($data))
                {
                    if ($data['error']) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?= '<i class="fa fa-times-circle"></i> '.$data['mensaje'] ?>
                        </div>
                    <?php }
                }
            ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>