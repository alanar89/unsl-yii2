<?php

namespace app\controllers;

use Yii;
use app\models\Nutricionista;
use app\models\NutricionistaSearch;
use app\models\UsuariosSearch;
use app\models\Provincia;
use app\models\Departamentos;
use app\models\Localidades;
use app\models\Filtro;
use app\models\Registro;
use app\models\Ali;
use app\models\ValoresAlimentos;
use yii\data\ArrayDataProvider;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use app\models\Usuarios;
use app\models\Paciente;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
use app\models\PacienteSearch;
use yii\helpers\ArrayHelper; 

/**
 * NutricionistaController implements the CRUD actions for Nutricionista model.
 */
class NutricionistaController extends Controller
{
    /**
     * {@inheritdoc}
     */
        public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        //El administrador tiene permisos sobre las siguientes acciones
                        'actions' => ['logout', 'create', 'panel','llenar','llenarl'],
                        //Esta propiedad establece que tiene permisos
                        'allow' => true,
                        //Usuarios autenticados, el signo ? es para invitados
                        'roles' => ['@'],
                        //Este método nos permite crear un filtro sobre la identidad del usuario
                        //y así establecer si tiene permisos o no
                        'matchCallback' => function ($rule, $action) {
                            //Llamada al método que comprueba si es un administrador
                            return User::isUserInvestigador(Yii::$app->user->identity->dni);
                        },
                    ],
                     [
                        //El administrador tiene permisos sobre las siguientes acciones
                        'actions' => ['logout','index','asignar','update','perfil','delete', 'llenar', 'llenarl', 'panel','deleteCuenta'],
                        //Esta propiedad establece que tiene permisos
                        'allow' => true,
                        //Usuarios autenticados, el signo ? es para invitados
                        'roles' => ['@'],
                        //Este método nos permite crear un filtro sobre la identidad del usuario
                        //y así establecer si tiene permisos o no
                        'matchCallback' => function ($rule, $action) {
                            //Llamada al método que comprueba si es un administrador
                            return User::isUserNutricionista(Yii::$app->user->identity->dni);
                        },
                    ],
                    [
                       //Los usuarios simples tienen permisos sobre las siguientes acciones
                       'actions' => ['logout'],
                       //Esta propiedad establece que tiene permisos
                       'allow' => true,
                       //Usuarios autenticados, el signo ? es para invitados
                       'roles' => ['@'],
                       //Este método nos permite crear un filtro sobre la identidad del usuario
                       //y así establecer si tiene permisos o no
                       'matchCallback' => function ($rule, $action) {
                          //Llamada al método que comprueba si es un usuario simple
                          return User::isUserSimple(Yii::$app->user->identity->id);
                      },
                   ],
                ],
            ],
     //Controla el modo en que se accede a las acciones, en este ejemplo a la acción logout
     //sólo se puede acceder a través del método post
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Nutricionista models.
     * @return mixed
     */
    public function actionIndex()
    {
       $searchModel = new PacienteSearch();
        $dataProvider = $searchModel->searchnutricionista(Yii::$app->request->queryParams);
        $libre = $searchModel->searchLibre(Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
             'libre' => $libre,
        ]);
    }

    /**
     * Displays a single Nutricionista model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Nutricionista model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   public function actionCreate($dept=null, $loc=null) {
        $model = new Nutricionista();
        $model1 = new Usuarios();
        $model1->rol=3;
        $provincia = new Provincia();
        $departamento = new Departamentos();
          if ($model->load(Yii::$app->request->post())  && $model1->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return array_merge(ActiveForm::validate($model), ActiveForm::validate($model1));

        }
    if ($model1->load(Yii::$app->request->post())){
         $model1->pass= Yii::$app->getSecurity()->generatePasswordHash( $model1->pass);

        if ( $model->load(Yii::$app->request->post()) && $model1->save() )  {
           
           $model->dni=$model1->dni;
           }
            if( $model->save() )  {
                yii::$app->session->setFlash('success','nutricionista registrado con exito');
               return $this->redirect(['investigador/panel']);
            }   
        
        }
         $prov = ArrayHelper::map($provincia->find()->all(), 'codpcia','provincia');
        if($dept==null){
            $dept= [];
        }
        if($loc==null){
            $loc=[];
        }
        return $this->render('create', [
            'model' => $model,'model1'=>$model1, 'prov'=>$prov, 'dept' => $dept, 'loc' => $loc
        ]);
    

}
    public function actionLlenar($up=0){
        if (!$_POST==[]) {
            $provincia = new Provincia();
            $departamento = new Departamentos();
            $prov = ArrayHelper::map($provincia->find()->all(), 'codpcia','provincia');
            if (array_key_exists('prov', $_POST)) {
            $dept=  ArrayHelper::map($departamento->find()->where(['codpcia'=> $_POST['prov']])->all(), 'coddpto','departamenos');
            }else{
                $dept=[];
                if ($up) {
                    $this->redirect($this->actionUpdate($up,0));
                }else{
                    $this->redirect($this->actionCreate());
                }
            }
            if ($up) {
             $this->actionUpdate($up,0,$dept);
            }else{
             $this->actionCreate($dept);
            }
        }
    }
    public function actionLlenarl($up=0){
        if (!$_POST==[]) {

            $provincia = new Provincia();
            $departamento = new Departamentos();
            $localidades = new Localidades();

           
            $prov = ArrayHelper::map($provincia->find()->all(), 'codpcia','provincia');
            $dept=[];

            if (array_key_exists('dept', $_POST)) {
            
            $dept=  ArrayHelper::map($departamento->find()->where(['codpcia'=> $_POST['prov']])->all(), 'coddpto','departamenos');
            $loc=  ArrayHelper::map($localidades->find()->where(['coddpto'=> $_POST['dept']])->andWhere(['codpcia'=> $_POST['prov']])->all(), 'codloc','localidad');
            }else {
                $loc=[];
                $dept=[];
                if ($up) {
                   $this->redirect($this->actionUpdate($up, 0));
                }else{
                    $this->redirect(['paciente/create']);
                }
                
            }
            if ($up) {
                $this->actionUpdate($up,0,$dept, $loc);
            }else{
                $this->actionCreate($dept, $loc);
            }
        }
    }
    /**
     * Updates an existing Nutricionista model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$comp=1, $iddept=null, $idloc=null)
    {
       $model = $this->findModel($id);
        $model1 = new Usuarios();
        $model1->scenario = 'act';
        $model1=$model1->find()->where(['dni'=>$model->dni])->one();
        $provincia = new Provincia();
        $departamento = new Departamentos();
        $localidades = new Localidades();
        $prov = ArrayHelper::map($provincia->find()->all(), 'codpcia','provincia');

       
        if ($comp) {  

                $dept=  ArrayHelper::map($departamento->find()->where(['codpcia'=> $model->provincia])->all(), 'coddpto','departamenos');
                $loc=  ArrayHelper::map($localidades->find()->where(['coddpto'=> $model->ciudad])->andWhere(['codpcia'=> $model->provincia])->all(), 'codloc','localidad');
          
        }else{
            $dept=$iddept;
            $loc=$idloc;
            if($iddept==null){
            $dept= [];
            }
            if($idloc==null){
                $loc=[];
            }

        }

         if ($model->load(Yii::$app->request->post())  && $model1->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return array_merge(ActiveForm::validate($model), ActiveForm::validate($model1));

        }
        if ($model->load(Yii::$app->request->post()) && $model1->load(Yii::$app->request->post()) && $model->save() && $model1->save()) {
             if (Yii::$app->user->identity->dni!= $model1->dni) {
            yii::$app->session->setFlash('success','DNI modificado inicie sesion');
          }else{
           yii::$app->session->setFlash('success','datos personales actualizados exitosamente');
       }
            return $this->redirect(['perfil', 'id' => $model->id]);
        }else{
            
        }
        $model->load(Yii::$app->request->post());
        
        return $this->render('update', [
            'model' => $model,'model1'=>$model1, 'prov'=>$prov, 'dept' => $dept, 'loc' => $loc, 'id'=>$id
        ]);
    }

     public function actionPerfil()
    {
            $dni=Yii::$app->user->identity->dni;
        $model = Nutricionista::find()->joinwith('usuarios')->where(['nutricionista.dni' => $dni])->one();
        $p= Provincia::find() ->where(['codpcia' => $model->provincia])->one();
     $d=Departamentos::find() ->where(['codpcia' => $model->provincia,'coddpto' => $model->ciudad])->one();
     $l=localidades::find() ->where(['codpcia' => $model->provincia,'coddpto' => $model->ciudad,'codloc' => $model->barrio])->one();
         $model->provincia=$p->provincia; 
         $model->ciudad=$d->departamenos; 
         $model->barrio=$l->localidad;
        return $this->render('view', [
            'model' => $model,
           
        ]);
       
       
    }

      /*  $libre = new ActiveDataProvider([
            'query' => $query,
          'sort' => [
        'attributes' => ['dni','usuarios.nombre','usuarios.apellido','usuarios.email','usuarios.telefono',
        'fechanac','talla','peso'],
    ],
    'pagination' => [
        'pageSize' => 10,
    ],
        ]);*/
       



    /**
     * Deletes an existing Nutricionista model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $p= Paciente::find() ->where(['id' => $id])->one();
        $p->dninutricionista=null;
        if ($p->update()){
            return $this->redirect(['index']);
    }else{return"error";}
}
  public function actionDeleteCuenta($id)
    {
        $p= Paciente::find()->where(['dninutricionista' => Yii::$app->user->identity->dni])->all();
        foreach ($p as $v) {
       
        $v->dninutricionista=null;
        $v->update();}
         
     Usuarios::findOne(Yii::$app->user->identity->dni)->delete();
        //$this->findModel($id)->delete();
       Yii::$app->session->setFlash('success','cuenta eliminada exitosamente');
        return $this->redirect(['site/index']);
}
  public function actionAsignar($id)
    {
        $d=Yii::$app->user->identity->dni;
        $p= Paciente::find() ->where(['id' => $id])->one();
        $p->dninutricionista=$d;
        if ($p->update()){
            return $this->redirect(['index']);
         }else{return"error";}
            
      
        
    }


    /**
     * Finds the Nutricionista model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Nutricionista the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Nutricionista::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    
}
