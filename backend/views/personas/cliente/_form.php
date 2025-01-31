<?php
use app\models\Estado;
use app\models\TipoIdentificacion;
use app\models\TipoPersona;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>
    <div class="row mb-3">
        <div class="col-sm-4 mb-2">
            <?=
                $form->field($model, 'fk_tipo_persona')->dropDownList(
                    ArrayHelper::map(TipoPersona::find()->asArray()->all(), 'tipopers_codigo', 'tipopers_nombre'), 
                    [
                        'id' => 'fk_tipo_persona',
                        'onchange'=>'chgTipoPersona()',
                        'class' => 'form-select form-select-sm'
                    ]
                );
            ?>
        </div>
        <div class="col-sm-4 mb-2">
            <?=
                $form->field($model, 'fk_tipo_identificacion')->dropDownList(
                    ArrayHelper::map(TipoIdentificacion::find()->asArray()->all(), 'tipoiden_codigo', 'tipoiden_nombre'), 
                    ['class' => 'form-select form-select-sm']
                );
            ?>
        </div>
        <div class="col-sm-4 mb-2">
            <?= $form->field($model, 'cliente_identificacion')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-6 mb-2 natural">
            <?= $form->field($model, 'cliente_primer_nombre')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-6 mb-2 natural">
            <?= $form->field($model, 'cliente_segundo_nombre')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-6 mb-2 natural">
            <?= $form->field($model, 'cliente_primer_apellido')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-6 mb-2 natural">
            <?= $form->field($model, 'cliente_segundo_apellido')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-12 mb-2 juridica">
            <?= $form->field($model, 'cliente_razon_social')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-6 mb-2">
            <?= $form->field($model, 'cliente_correo')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-6 mb-2">
            <?= $form->field($model, 'cliente_telefono')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-6 mb-2">
            <?php 
                if (isset($model->cliente_codigo)) {
                    echo $form->field($model, 'fk_estado')->dropDownList(
                        ArrayHelper::map(Estado::find()->asArray()->all(), 'estado_codigo', 'estado_nombre'), 
                        ['class' => 'form-select form-select-sm']
                    );
                }
            ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-12">
            <?= Html::submitButton('<i class="fa fa-save"></i> Guardar', ['class' => 'btn btn-sm btn-personalizado']) ?>
            <?= Html::a('<i class="fa fa-times"></i>  Cancelar', ['index'], ['class' => 'btn btn-sm btn-secondary']) ?>
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

<script>
$(document).ready(function(){
    chgTipoPersona();
});

function chgTipoPersona() {
    var tipoPersona = $('#fk_tipo_persona')[0].value;

    // 1 - Persona natural
    if (tipoPersona == 1){
        $('.natural').prop('hidden',false);
        $('.juridica').prop('hidden',true);
    }
    else{
        $('.natural').prop('hidden',true);
        $('.juridica').prop('hidden',false);
    }
}
</script>