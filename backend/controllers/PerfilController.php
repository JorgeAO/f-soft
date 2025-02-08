<?php

namespace app\controllers;

use app\controllers\PermisoController;
use app\models\Perfil;
use app\models\PerfilSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PerfilController extends Controller
{
    private $strRuta = "/seguridad/perfil/";
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

        $searchModel = new PerfilSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($perfil_codigo)
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "v"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($perfil_codigo),
        ]);
    }
    
    public function actionCreate()
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "c"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Perfil();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->perfil_nombre = mb_strtoupper($model->perfil_nombre, 'UTF-8');
                $model->fc = date('Y-m-d H:i:s');
                $model->uc = $_SESSION['usuario_sesion']['usuario_codigo'];

                $model->save();
                
                return $this->redirect(['view', 'perfil_codigo' => $model->perfil_codigo]);
            }
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
        ]);
    }
    
    public function actionUpdate($perfil_codigo)
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "u"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($perfil_codigo);

        if ($this->request->isPost && $model->load($this->request->post()))  {
            $model->perfil_nombre = mb_strtoupper($model->perfil_nombre, 'UTF-8');
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['usuario_sesion']['usuario_codigo'];

            $model->save();
            
            return $this->redirect(['view', 'perfil_codigo' => $model->perfil_codigo]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }
    
    public function actionDelete($perfil_codigo)
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "d"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($perfil_codigo)->delete();

        return $this->redirect(['index']);
    }
    
    protected function findModel($perfil_codigo)
    {
        if (($model = Perfil::findOne(['perfil_codigo' => $perfil_codigo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('No se encuentra el registro.');
    }
    
    public function actionConsultar()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $query = new \yii\db\Query();

        $request = \Yii::$app->request;
        $params = $request->get();

        $perfiles = $query->select(['perfil.*', 'e.estado_nombre'])
            ->from('perfil')
            ->join('JOIN', 'estado e', 'e.estado_codigo = perfil.fk_estado')
            ->where($params)
            ->all();

        return [
            'error' => false,
            'mensaje' => '',
            'datos' => $perfiles
        ];
    }
}
