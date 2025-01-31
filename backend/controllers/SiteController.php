<?php

namespace app\controllers;

use app\models\Usuario;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionLogin()
    {
        $usuario = new Usuario();

        if ($usuario->load(Yii::$app->request->post()))
        {
            $post = Yii::$app->request->post()["Usuario"];

            $arrUsuario = Usuario::find()
                ->where(["usuario_correo" => $post["usuario_correo"]])
                ->all();

            if (count($arrUsuario) != 1)
            {
                $usuario->usuario_clave = "";
                return $this->render('login', [
                    'usuario' => $usuario,
                    'data' => [
                        "error" => true,
                        "mensaje" => "No se pudo recuperar el usuario",
                    ]
                ]);
            }

            if ($arrUsuario[0]["fk_estado"] != 1)
            {
                $usuario->usuario_clave = "";
                return $this->render('login', [
                    'usuario' => $usuario,
                    'data' => [
                        "error" => true,
                        "mensaje" => "El usuario no se encuentra activo, por favor comuníquese con un administrador del sistema",
                    ]
                ]);
            }

            if ($arrUsuario[0]["usuario_clave"] != md5($usuario->usuario_clave))
            {
                $usuario->usuario_clave = "";
                return $this->render('login', [
                    'usuario' => $usuario,
                    'data' => [
                        "error" => true,
                        "mensaje" => "La contraseña no es correcta",
                    ]
                ]);
            }

            unset($arrUsuario[0]["usuario_clave"]);

            Yii::$app->session->set('usuario_sesion', $arrUsuario[0]);
                
            return $this->render('/layouts/blank');
        }

        unset($_SESSION["usuario_sesion"]);
        
        return $this->render('login', [
            'usuario' => $usuario,
        ]);
    }
    
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
