<?php

namespace app\controllers;

use app\models\Permiso;
use app\models\PermisoSearch;
use stdClass;
use Yii;
use yii\db\ActiveQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class PermisoController extends Controller
{
    private $strRuta = "/seguridad/permiso/";
    private $intOpcion = 1003;

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

        $searchModel = new PermisoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public static function validarPermiso($parametros)
    {
        if (!isset($_SESSION['usuario_sesion']))
        {
            return [
                'error' => true,
                'mensaje' => 'La sesión ha caducado',
            ];
        }

        $query = new \yii\db\Query();
        $permisos = $query->select($parametros["accion"])
            ->from('permiso')
            ->Where('fk_perfil = :perfil')
            ->andwhere('fk_opcion = :opcion')
            ->addParams([
                ":perfil" => $_SESSION['usuario_sesion']['fk_perfil'],
                ":opcion" => $parametros["opcion"],
            ])
            ->all();
        
        if (count($permisos) != 1 || $permisos[0][$parametros["accion"]] == 0)
            return [
                'error' => true,
                'mensaje' => 'Usted no posee permisos para ejecutar esta acción',
            ];

        return [
            'error' => false,
            'mensaje' => ''
        ];
    }

    public static function construirMenu()
    {
        $arrMenu = [];

        // Si no se encuentra un usuario en sesión se devuelve un menú que sólo contine la opción de loguearse
        if (!isset($_SESSION['usuario_sesion']))
        {
            array_push($arrMenu, ['label' => 'Login', 'url' => ['/site/login']]);
            return $arrMenu;
        }

        // Se consultan todos lo permisos de consulta del perfil del usuario que está en sesión
        // Se usa la acción de consulta ya que es con la que inicia cada pantalla de la aplicación
        $query = new \yii\db\Query();
        $registros = $query->select(
                ["op.*", "mo.modulo_nombre", "mo.modulo_icono"]
            )
            ->from("opcion op")
            ->join("join", "modulo mo", "op.fk_modulo = mo.modulo_codigo")
            ->leftJoin("permiso pe", "pe.fk_opcion = op.opcion_codigo")
            ->where([
                "mo.fk_estado" => 1,
                "op.fk_estado" => 1,
                "pe.m" => 1,
            ])
            ->andWhere("pe.fk_perfil = :perfil")
            ->andWhere("op.opcion_enlace != ''")
            ->addParams([
                ":perfil" => $_SESSION['usuario_sesion']['fk_perfil']
            ])
            ->orderBy([
                "op.fk_modulo" => SORT_ASC,
                "op.opcion_nombre" => SORT_ASC
            ])
            ->all();

        // Banderas para la creación del menú
        $intModulo = 0;
        $strModulo = '';
        $arrSubMenu = [];
        
        // Recorrer todos los permisos que se encontraron del perfil
        foreach ($registros as $key => $value) 
        {   
            // Validar si el módulo que está en el paso del ciclo es diferente al que paso anterior
            if ($intModulo != $value['fk_modulo'])
            {
                // Se agrega el submenú al menú 
                array_push(
                    $arrMenu, 
                    [ 'label'=>$strModulo, 'items'=>$arrSubMenu, ]
                );
                
                // Se cambiá la bandera del menú actual
                $intModulo = $value['fk_modulo'];
            
                // Se cambia el nombre del menú
                $strModulo = '<i class="fas fa-'.$value['modulo_icono'].'"></i> '.$value['modulo_nombre'];

                // Se crea un nuevo submenu
                $arrSubMenu = [];
            }
            
            // Se agrega la opción al submenú
            array_push(
                $arrSubMenu, 
                [
                    'label'=>$value['opcion_nombre'], 
                    'options' => [
                        'class' => 'text-white',
                        'style'=>'font-size:12px'
                    ],
                    'url'=>[
                        $value['opcion_enlace'], 
                    ]
                ]
            );
        }
        
        // Se agrega el último submenú al menú
        array_push($arrMenu, ['label'=>$strModulo, 'items'=>$arrSubMenu]);
        
        // Se agrega la opción de cerrar sesión
        array_push(
            $arrMenu, 
            [
                'label' => '<i class="fas fa-user"></i> '.$_SESSION['usuario_sesion']['usuario_nombre_completo'], 
                'items'=>[
                    [
                        'label'=>'Salir', 
                        'url'=>[ '/usuario/cerrar-sesion' ], 
                    ]
                ]
            ]
        );

        // Se devuelve el menú de acuerdo a los permisos del perfil
        return $arrMenu;
    }
    
    public function actionConsultarPermisos()
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "r"
        ]);
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $intPerfil = Yii::$app->request->post()['perfil'];

        $sqlSentencia = "select
                op.opcion_codigo, op.fk_modulo, op.opcion_nombre,
                mo.modulo_nombre,
                coalesce(pe.c, 0) as c, coalesce(pe.r, 0) as r, coalesce(pe.u, 0) as u, coalesce(pe.d, 0) as d, coalesce(pe.l, 0) as l, coalesce(pe.v, 0) as v, coalesce(pe.m, 0) as m
            from opcion op
            join modulo mo on (op.fk_modulo = mo.modulo_codigo) 
            left join permiso pe on (pe.fk_opcion = op.opcion_codigo and pe.fk_perfil = ".$intPerfil.")
            where mo.fk_estado = 1
            and op.fk_estado = 1
            order by op.opcion_codigo asc";
        
        $cnxConexion = Yii::$app->db;

        $stmtSentencia = $cnxConexion->createCommand($sqlSentencia);

        $permisos = $stmtSentencia->queryAll();

        echo json_encode($permisos);
    }

    public function actionGuardarPermisos()
    {
        $rta = PermisoController::validarPermiso([
            "opcion" => $this->intOpcion, 
            "accion" => "u"
        ]);
        if ($rta['error']){
            $jsonRta = new stdClass;
            $jsonRta->error = true;
            $jsonRta->mensaje = $rta['mensaje'];

            echo json_encode($jsonRta);
            exit();
        }

        // Se obtienen los datos ue vienen en el post
        $post = Yii::$app->request->post();

        // Se eliminan todos los permisos del perfil antes de insertar los nuevos
        Permiso::deleteAll(['fk_perfil' => $post['perfil']]);

        // Se recorren los permisos que vienen del formulario
        foreach ($post['permisos'] as $key => $value) 
        {
            // Se identifican la opción y la acción
            // Las opciones se encuentran en la tabla opcion
            // Las acciones son (C)reate, (R)ead, (U)pdate, (D)elete, (L)ist y (V)iew
            $arrOpcion = explode('_', $value['name']);
            $intOpcion = $arrOpcion[0];
            $chrAccion = $arrOpcion[1];

            // Se consulta si para el perfil y la opción ya hay acciones permitidas en la base de datos
            $query = new \yii\db\Query();
            $rslConsulta = $query
                ->select('*')
                ->from('permiso')
                ->Where('fk_perfil = '.$post['perfil'])
                ->andwhere('fk_opcion = '.$intOpcion)
                ->all();
            
            // Si el permiso no existe, se crea un nuevo registro
            if (count($rslConsulta) == 0)
            {
                $objPermiso = new Permiso();
                $objPermiso->fk_perfil = $post['perfil'];
                $objPermiso->fk_opcion = $intOpcion;
            }
            else // Pero si el permiso existe, se carga el objeto existente
                $objPermiso = Permiso::findOne($rslConsulta[0]['permiso_codigo']);
            
            // Se marca la acción como permitida y se guardan los cambios
            $objPermiso->$chrAccion = 1;
            $objPermiso->save();
        }

        $jsonRta = new stdClass;
        $jsonRta->error = false;
        $jsonRta->mensaje = 'El proceso se realizó con éxito';

        echo json_encode($jsonRta);
    }
}
