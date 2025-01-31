<?php

namespace app\controllers;

use app\controllers\PermisoController;
use app\models\CambioClave;
use app\models\Usuario;
use app\models\UsuarioSearch;
use stdClass;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UsuarioController extends Controller
{
    private $strRuta = "/seguridad/usuario/";
    private $intOpcion = 1002;

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

        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($usuario_codigo)
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "v"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($usuario_codigo),
        ]);
    }
    
    public function actionCreate()
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "c"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Usuario();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Validar si ya existe un usuario con ese correo electrónico
                $usuario = Usuario::find()->where(['usuario_correo' => $model->usuario_correo])->all();

                if (count($usuario) > 0) {
                    unset($model->usuario_clave);

                    return $this->render($this->strRuta.'create', [
                        'model' => $model,
                        'data' => [
                            'error' => true,
                            'mensaje' => 'Ya existe un usuario con este correo electrónico.'
                        ]
                    ]);
                }

                $model->usuario_primer_nombre = mb_strtoupper($model->usuario_primer_nombre, 'UTF-8');
                $model->usuario_segundo_nombre = mb_strtoupper($model->usuario_segundo_nombre, 'UTF-8');
                $model->usuario_primer_apellido = mb_strtoupper($model->usuario_primer_apellido, 'UTF-8');
                $model->usuario_segundo_apellido = mb_strtoupper($model->usuario_segundo_apellido, 'UTF-8');
                $model->usuario_nombre_completo = str_replace("  ", " ", $model->usuario_primer_nombre." ".$model->usuario_segundo_nombre." ".$model->usuario_primer_apellido." ".$model->usuario_segundo_apellido);
                $model->usuario_clave = md5($model->usuario_clave);
                $model->fc = date('Y-m-d H:i:s');
                $model->uc = $_SESSION['usuario_sesion']['usuario_codigo'];
                
                $model->save();
                return $this->redirect(['view', 'usuario_codigo' => $model->usuario_codigo]);
            }
        } else {
            $model->loadDefaultValues();
        }


        return $this->render($this->strRuta.'create', [
            'model' => $model,
            'data' => [
                'error' => false,
                'mensaje' => ''
            ],
        ]);
    }
    
    public function actionUpdate($usuario_codigo)
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "u"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($usuario_codigo);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->usuario_primer_nombre = mb_strtoupper($model->usuario_primer_nombre, 'UTF-8');
            $model->usuario_segundo_nombre = mb_strtoupper($model->usuario_segundo_nombre, 'UTF-8');
            $model->usuario_primer_apellido = mb_strtoupper($model->usuario_primer_apellido, 'UTF-8');
            $model->usuario_segundo_apellido = mb_strtoupper($model->usuario_segundo_apellido, 'UTF-8');
            $model->usuario_nombre_completo = str_replace("  ", " ", $model->usuario_primer_nombre." ".$model->usuario_segundo_nombre." ".$model->usuario_primer_apellido." ".$model->usuario_segundo_apellido);
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['usuario_sesion']['usuario_codigo'];
            
            $model->save();
            return $this->redirect(['view', 'usuario_codigo' => $model->usuario_codigo]);
        }

        unset($model->usuario_clave);
        return $this->render($this->strRuta.'update', [
            'model' => $model,
            'data' => [
                'error' => false,
                'mensaje' => ''
            ],
        ]);
    }
    
    public function actionDelete($usuario_codigo)
    {
        $model = $this->findModel($usuario_codigo);
        $model->fk_estado = 2;
        
        $model->save();

        return $this->redirect(['index']);
    }
    
    protected function findModel($usuario_codigo)
    {
        if (($model = Usuario::findOne(['usuario_codigo' => $usuario_codigo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCerrarSesion() {
        unset($_SESSION["usuario_sesion"]);
        
        $usuario = new Usuario();

        return $this->render('/site/login', [
            'usuario' => $usuario,
        ]);
    }
    
    public function actionCambiarClave()
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => 1004, 
            "accion" => "u"
        ]);

        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new CambioClave();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Buscar el usuario que está en sesión
                $usuario = Usuario::findOne(['usuario_codigo' => $_SESSION["usuario_sesion"]["usuario_codigo"]]);

                // Validar que la clave actual si sea la ingresada por el usuario
                if ($usuario->usuario_clave != md5($model->usuario_clave)){
                    return $this->render($this->strRuta.'cambiar-clave', [
                        'model' => $model,
                        'data' => [
                            'error' => true,
                            'mensaje' => 'La clave actual no es correcta.'
                        ]
                    ]);
                }

                if ($model->usuario_nueva_clave != $model->usuario_confirmar_nueva_clave) {
                    return $this->render($this->strRuta.'cambiar-clave', [
                        'model' => $model,
                        'data' => [
                            'error' => true,
                            'mensaje' => 'Las claves no coinciden.'
                        ]
                    ]);
                }

                $usuario->usuario_clave = md5($model->usuario_nueva_clave);
                $usuario->fm = date('Y-m-d H:i:s');
                $usuario->um = $_SESSION['usuario_sesion']['usuario_codigo'];
                
                $usuario->save();

                return $this->render($this->strRuta.'cambiar-clave', [
                    'model' => new CambioClave(),
                    'data' => [
                        'error' => false,
                        'mensaje' => 'El proceso se realizó con éxito'
                    ],
                ]);
            }
        }

        return $this->render($this->strRuta.'cambiar-clave', [
            'model' => $model,
        ]);
    }
    
    public function actionCambiarClaveUsuario($usuario_codigo) {
        $rta = PermisoController::validarPermiso([
            "opcion" => 1005, 
            "accion" => "u"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $usuario = $this->findModel($usuario_codigo);

        $model = new CambioClave();
        $model->usuario_codigo = $usuario->usuario_codigo;
        $model->usuario_nombre_completo = $usuario->usuario_nombre_completo;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->usuario_nueva_clave != $model->usuario_confirmar_nueva_clave) {
                    return $this->render($this->strRuta.'cambiar-clave-usuario', [
                        'model' => $model,
                        'data' => [
                            'error' => true,
                            'mensaje' => 'Las claves no coinciden.'
                        ]
                    ]);
                }

                $usuario->usuario_clave = md5($model->usuario_nueva_clave);
                $usuario->fm = date('Y-m-d H:i:s');
                $usuario->um = $_SESSION['usuario_sesion']['usuario_codigo'];
                
                $usuario->save();

                return $this->render($this->strRuta.'cambiar-clave-usuario', [
                    'model' => new CambioClave(),
                    'data' => [
                        'error' => false,
                        'mensaje' => 'El proceso se realizó con éxito'
                    ],
                ]);
            }
        }
        
        return $this->render($this->strRuta.'cambiar-clave-usuario', [
            'model' => $model,
        ]);
    }
}
