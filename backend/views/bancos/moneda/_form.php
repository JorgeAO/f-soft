<?php
use app\models\Estado;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>
    <div class="row mb-3">
        <div class="col-sm-6 mb-3">
        <?= $form->field($model, 'moneda_nombre')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-6">
        <?= $form->field($model, 'moneda_iso')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-6">
            <?php 
                if (isset($model->moneda_codigo)) {
                    echo $form->field($model, 'fk_estado')->dropDownList(
                        ArrayHelper::map(Estado::find()->asArray()->all(), 'estado_codigo', 'estado_nombre'), 
                        ['class' => 'form-select form-select-sm']
                    );
                }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= Html::submitButton('<i class="fa fa-save"></i> Guardar', ['class' => 'btn btn-sm btn-personalizado']) ?>
            <?= Html::a('<i class="fa fa-times"></i>  Cancelar', ['index'], ['class' => 'btn btn-sm btn-secondary']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>