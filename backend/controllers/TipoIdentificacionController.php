<?php

namespace app\controllers;

use app\models\TipoIdentificacion;
use app\models\TipoIdentificacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class TipoIdentificacionController extends Controller
{
    private $strRuta = "/parametros/tipo-identificacion/";
    private $intOpcion = 1001;

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

        $searchModel = new TipoIdentificacionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($tipoiden_codigo)
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "v"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($tipoiden_codigo),
        ]);
    }
    
    public function actionCreate()
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "c"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new TipoIdentificacion();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->tipoiden_nombre = mb_strtoupper($model->tipoiden_nombre, 'UTF-8');
                $model->fc = date('Y-m-d H:i:s');
                $model->uc = $_SESSION['usuario_sesion']['usuario_codigo'];

                $model->save();
                
                return $this->redirect(['view', 'tipoiden_codigo' => $model->tipoiden_codigo]);
            }
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
        ]);
    }
    
    public function actionUpdate($tipoiden_codigo)
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "u"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($tipoiden_codigo);

        if ($this->request->isPost && $model->load($this->request->post()))  {
            $model->tipoiden_nombre = mb_strtoupper($model->tipoiden_nombre, 'UTF-8');
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['usuario_sesion']['usuario_codigo'];

            $model->save();
            
            return $this->redirect(['view', 'tipoiden_codigo' => $model->tipoiden_codigo]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($tipoiden_codigo)
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "d"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($tipoiden_codigo)->delete();

        return $this->redirect(['index']);
    }
    
    protected function findModel($tipoiden_codigo)
    {
        if (($model = TipoIdentificacion::findOne(['tipoiden_codigo' => $tipoiden_codigo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
