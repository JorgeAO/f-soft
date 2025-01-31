<?php

namespace app\controllers;

use app\models\Cliente;
use app\models\ClienteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ClienteController extends Controller
{
    private $strRuta = "/personas/cliente/";
    private $intOpcion = 3002;

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }
    
    public function actionIndex()
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "r"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $searchModel = new ClienteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($cliente_codigo)
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "v"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($cliente_codigo),
        ]);
    }
    
    public function actionCreate()
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "c"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Cliente();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Validar que sea consecuente el tipo de persona y el tipo de identificación
                if ($model->fk_tipo_persona == 1 && $model->fk_tipo_identificacion == 2){
                    return $this->render($this->strRuta.'create', [
                        'model' => $model,
                        'data' => [
                            'error' => true,
                            'mensaje' => 'Una persona natural no debe tener NIT.'
                        ]
                    ]);
                }

                if ($model->fk_tipo_persona == 2 && $model->fk_tipo_identificacion == 1){
                    return $this->render($this->strRuta.'create', [
                        'model' => $model,
                        'data' => [
                            'error' => true,
                            'mensaje' => 'Una persona jurídica no debe tener cédula.'
                        ]
                    ]);
                }

                // Validar que la persona natural tenga, por lo menos, primer nombre y primer apellido
                if ($model->fk_tipo_persona == 1) {
                    if ($model->cliente_primer_nombre == "" || $model->cliente_primer_apellido == ""){
                        return $this->render($this->strRuta.'create', [
                            'model' => $model,
                            'data' => [
                                'error' => true,
                                'mensaje' => 'Por favor ingrese, por lo menos, el primer nombre y el primer apellido.'
                            ]
                        ]);
                    }
                }

                // Validar que la persona jurídica tenga razón social
                if ($model->fk_tipo_persona == 2) {
                    if ($model->cliente_razon_social == ""){
                        return $this->render($this->strRuta.'create', [
                            'model' => $model,
                            'data' => [
                                'error' => true,
                                'mensaje' => 'Por favor ingrese la razón social.'
                            ]
                        ]);
                    }
                }

                // Preparar datos
                if ($model->fk_tipo_persona == 1) {
                    unset($model->cliente_razon_social);
                    $model->cliente_primer_nombre = strtoupper($model->cliente_primer_nombre);
                    $model->cliente_segundo_nombre = strtoupper($model->cliente_segundo_nombre);
                    $model->cliente_primer_apellido = strtoupper($model->cliente_primer_apellido);
                    $model->cliente_segundo_apellido = strtoupper($model->cliente_segundo_apellido);
                    $model->cliente_nombre_completo = str_replace("  ", " ", $model->cliente_primer_nombre." ".$model->cliente_segundo_nombre." ".$model->cliente_primer_apellido." ".$model->cliente_segundo_apellido);
                }

                if ($model->fk_tipo_persona == 2) {
                    unset($model->cliente_primer_nombre, $model->cliente_segundo_nombre, $model->cliente_primer_apellido, $model->cliente_segundo_apellido);
                    $model->cliente_razon_social = strtoupper($model->cliente_razon_social);
                    $model->cliente_nombre_completo = $model->cliente_razon_social;
                }

                $model->fk_estado = 1;
                $model->fc = date('Y-m-d H:i:s');
                $model->uc = $_SESSION['usuario_sesion']['usuario_codigo'];

                $model->save();
                
                return $this->redirect(['view', 'cliente_codigo' => $model->cliente_codigo]);
            }
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
            'data' => [
                'error' => false,
                'mensaje' => ''
            ],
        ]);
    }
    
    public function actionUpdate($cliente_codigo)
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "u"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($cliente_codigo);

        if ($this->request->isPost && $model->load($this->request->post()))  {
            // Validar que sea consecuente el tipo de persona y el tipo de identificación
            if ($model->fk_tipo_persona == 1 && $model->fk_tipo_identificacion == 2){
                return $this->render($this->strRuta.'create', [
                    'model' => $model,
                    'data' => [
                        'error' => true,
                        'mensaje' => 'Una persona natural no debe tener NIT.'
                    ]
                ]);
            }

            if ($model->fk_tipo_persona == 2 && $model->fk_tipo_identificacion == 1){
                return $this->render($this->strRuta.'create', [
                    'model' => $model,
                    'data' => [
                        'error' => true,
                        'mensaje' => 'Una persona jurídica no debe tener cédula.'
                    ]
                ]);
            }

            // Validar que la persona natural tenga, por lo menos, primer nombre y primer apellido
            if ($model->fk_tipo_persona == 1) {
                if ($model->cliente_primer_nombre == "" || $model->cliente_primer_apellido == ""){
                    return $this->render($this->strRuta.'create', [
                        'model' => $model,
                        'data' => [
                            'error' => true,
                            'mensaje' => 'Por favor ingrese, por lo menos, el primer nombre y el primer apellido.'
                        ]
                    ]);
                }
            }

            // Validar que la persona jurídica tenga razón social
            if ($model->fk_tipo_persona == 2) {
                if ($model->cliente_razon_social == ""){
                    return $this->render($this->strRuta.'create', [
                        'model' => $model,
                        'data' => [
                            'error' => true,
                            'mensaje' => 'Por favor ingrese la razón social.'
                        ]
                    ]);
                }
            }

            // Preparar datos
            if ($model->fk_tipo_persona == 1) {
                unset($model->cliente_razon_social);
                $model->cliente_primer_nombre = strtoupper($model->cliente_primer_nombre);
                $model->cliente_segundo_nombre = strtoupper($model->cliente_segundo_nombre);
                $model->cliente_primer_apellido = strtoupper($model->cliente_primer_apellido);
                $model->cliente_segundo_apellido = strtoupper($model->cliente_segundo_apellido);
                $model->cliente_nombre_completo = str_replace("  ", " ", $model->cliente_primer_nombre." ".$model->cliente_segundo_nombre." ".$model->cliente_primer_apellido." ".$model->cliente_segundo_apellido);
            }

            if ($model->fk_tipo_persona == 2) {
                unset($model->cliente_primer_nombre, $model->cliente_segundo_nombre, $model->cliente_primer_apellido, $model->cliente_segundo_apellido);
                $model->cliente_razon_social = strtoupper($model->cliente_razon_social);
                $model->cliente_nombre_completo = $model->cliente_razon_social;
            }

            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['usuario_sesion']['usuario_codigo'];

            $model->save();
            
            return $this->redirect(['view', 'cliente_codigo' => $model->cliente_codigo]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
            'data' => [
                'error' => false,
                'mensaje' => ''
            ],
        ]);
    }
    
    public function actionDelete($cliente_codigo)
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "d"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($cliente_codigo)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($cliente_codigo)
    {
        if (($model = Cliente::findOne(['cliente_codigo' => $cliente_codigo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
