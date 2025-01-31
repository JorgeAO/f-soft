<?php

namespace app\controllers;

use app\models\Moneda;
use app\models\MonedaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class MonedaController extends Controller
{
    private $strRuta = "/bancos/moneda/";
    private $intOpcion = 5001;

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

        $searchModel = new MonedaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($moneda_codigo)
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "v"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($moneda_codigo),
        ]);
    }
    
    public function actionCreate()
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "c"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Moneda();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->moneda_nombre = mb_strtoupper($model->moneda_nombre, 'UTF-8');
                $model->moneda_iso = mb_strtoupper($model->moneda_iso, 'UTF-8');
                $model->fc = date('Y-m-d H:i:s');
                $model->uc = $_SESSION['usuario_sesion']['usuario_codigo'];

                $model->save();
                
                return $this->redirect(['view', 'moneda_codigo' => $model->moneda_codigo]);
            }
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
        ]);
    }
    
    public function actionUpdate($moneda_codigo)
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "u"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($moneda_codigo);

        if ($this->request->isPost && $model->load($this->request->post()))  {
            $model->moneda_nombre = mb_strtoupper($model->moneda_nombre, 'UTF-8');
            $model->moneda_iso = mb_strtoupper($model->moneda_iso, 'UTF-8');
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['usuario_sesion']['usuario_codigo'];

            $model->save();
            
            return $this->redirect(['view', 'moneda_codigo' => $model->moneda_codigo]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }
    
    public function actionDelete($moneda_codigo)
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "d"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($moneda_codigo)->delete();

        return $this->redirect(['index']);
    }
    
    protected function findModel($moneda_codigo)
    {
        if (($model = Moneda::findOne(['moneda_codigo' => $moneda_codigo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
