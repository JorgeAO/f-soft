<?php
use app\models\Perfil;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Permisos';
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
            <div class="col-sm-4">
                <div class="col-sm-12 mb-3">
                    <label class="mb-2">Perfil</label>
                    <?= Html::dropDownList(
                        "fk_perfil", 
                        null, 
                        ArrayHelper::map(Perfil::find()->asArray()->all(), 'perfil_codigo', 'perfil_nombre'), 
                        [ 
                            'class'=> "form-select form-select-sm",
                            'onchange'=>'consultarPermisos()',
                            'prompt'=>''
                        ]
                    ) ?>
                </div>
                <div class="col-sm-12 mb-3">
                    <?= Html::button('<i class="fa fa-save"></i> Guardar', [ 'class'=>'btn btn-sm btn-personalizado', 'id'=>'btn_guardar' ]) ?>
                </div>
                <div class="col-sm-12" id="div_esperar"></div>
            </div>
            <div class="col-sm-8">
            <label>Permisos</label>
                <form id="frm_permisos">
                    <div id="div_permisos">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Opción</th>
                                    <th scope="col">Crear</th>
                                    <th scope="col">Consultar</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Eliminar</th>
                                    <th scope="col">Listar</th>
                                    <th scope="col">Ver</th>
                                    <th scope="col">En Menú</th>
                                </tr>
                            </thead>
                            <tbody id="tbl_permisos"></tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
    	$('#btn_guardar').prop('disabled',true);

		$('#btn_guardar').on('click', function(){
			$('#div_esperar').html('<br><div class="alert alert-primary"><i class="fa fa-spinner"></i> Espere por favor</div>')
            
            $.ajax({
                url: "index.php?r=permiso/guardar-permisos",
                method: "POST",
                dataType: "JSON",
                data: {
                    perfil:document.getElementsByName('fk_perfil')[0].value,
                    permisos: $('#frm_permisos').serializeArray()
                },
                success:function(data){
                    if (!data.error){
                        $('#div_esperar').html('<br><div class="alert alert-success"><i class="fa fa-check-circle"></i> El proceso se realizó con éxito.<br>La pantalla se acualizará automaticamente en 5 segundos.</div>')
                        setTimeout( () => { location.reload(); }, 5000 );
                    } 
                    if (data.error) $('#div_esperar').html('<br><div class="alert alert-danger"><i class="fa fa-times-circle"></i> '+data.mensaje+'</div>')
                },
            });
		});

	});

    function consultarPermisos() {
        var perfil = document.getElementsByName('fk_perfil')[0].value;

        if (perfil == ""){
            $('#tbl_permisos').html('');
            $('#btn_guardar').prop('disabled',true);
            return;
        }
        
        $('#btn_guardar').prop('disabled',false);

        $.ajax({
            url: "index.php?r=permiso/consultar-permisos",
            method: "POST",
            dataType: "JSON",
            data: { perfil : perfil },
            success:function(data){
                $('#tbl_permisos').html('');
                var permisos = '';
                data.forEach(val => {
                    permisos += '<tr>'+
                        '<td>'+val.opcion_codigo+'</td>'+
                        '<td>'+val.opcion_nombre+'</td>'+
                        '<td>'+
                        '<div class="form-check">'+
                        '<input name="'+val.opcion_codigo+'_c" class="form-check-input chk_permiso" type="checkbox" '+(val.c == 1 ? 'checked' : '')+'>'+
                        '</div>'+
                        '</td>'+
                        '<td>'+
                        '<div class="form-check">'+
                        '<input name="'+val.opcion_codigo+'_r" class="form-check-input chk_permiso" type="checkbox" '+(val.r == 1 ? 'checked' : '')+'>'+
                        '</div>'+
                        '</td>'+
                        '<td>'+
                        '<div class="form-check">'+
                        '<input name="'+val.opcion_codigo+'_u" class="form-check-input chk_permiso" type="checkbox" '+(val.u == 1 ? 'checked' : '')+'>'+
                        '</div>'+
                        '</td>'+
                        '<td>'+
                        '<div class="form-check">'+
                        '<input name="'+val.opcion_codigo+'_d" class="form-check-input chk_permiso" type="checkbox" '+(val.d == 1 ? 'checked' : '')+'>'+
                        '</div>'+
                        '</td>'+
                        '<td>'+
                        '<div class="form-check">'+
                        '<input name="'+val.opcion_codigo+'_l" class="form-check-input chk_permiso" type="checkbox" '+(val.l == 1 ? 'checked' : '')+'>'+
                        '</div>'+
                        '</td>'+
                        '<td>'+
                        '<div class="form-check">'+
                        '<input name="'+val.opcion_codigo+'_v" class="form-check-input chk_permiso" type="checkbox" '+(val.v == 1 ? 'checked' : '')+'>'+
                        '</div>'+
                        '</td>'+
                        '<td>'+
                        '<div class="form-check">'+
                        '<input name="'+val.opcion_codigo+'_m" class="form-check-input chk_permiso" type="checkbox" '+(val.m == 1 ? 'checked' : '')+'>'+
                        '</div>'+
                        '</td>'+
                        '</tr>';
                });
                $('#tbl_permisos').append(permisos);
            },
        });
    }
</script>