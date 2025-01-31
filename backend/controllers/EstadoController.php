<?php

namespace app\controllers;

use app\models\Estado;
use app\models\EstadoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class EstadoController extends Controller
{
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
        $searchModel = new EstadoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($estado_codigo)
    {
        return $this->render('view', [
            'model' => $this->findModel($estado_codigo),
        ]);
    }
    
    public function actionCreate()
    {
        $model = new Estado();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'estado_codigo' => $model->estado_codigo]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    public function actionUpdate($estado_codigo)
    {
        $model = $this->findModel($estado_codigo);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'estado_codigo' => $model->estado_codigo]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    public function actionDelete($estado_codigo)
    {
        $this->findModel($estado_codigo)->delete();

        return $this->redirect(['index']);
    }
    
    protected function findModel($estado_codigo)
    {
        if (($model = Estado::findOne(['estado_codigo' => $estado_codigo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
