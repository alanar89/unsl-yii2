<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use app\models\Investigador;
use app\models\Usuarios;
use app\models\Filtro;
use app\models\Provincia;
use app\models\Paciente;
use app\models\Departamentos;
use app\models\Localidades;
use yii\data\ArrayDataProvider;
use app\models\Ali;
use app\models\Registro;
use app\models\ValoresAlimentos;
use app\models\InvestigadorSearch;
use app\models\UsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\IdentityInterface;
use app\models\LoginForm;
use app\models\User;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use DateTime;
/**
 * InvestigadorController implements the CRUD actions for Investigador model.
 */
class InvestigadorController extends Controller
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
                        'actions' => ['logout', 'create', 'panel', 'index', 'view','exportar', 'registro','llenar','llenarl','perfil','update','pass'],
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
                        'actions' => ['logout','panel','llenar','llenarl','exportar'],
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
     * Lists all Investigador models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvestigadorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Investigador model.
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
     * Creates a new Investigador model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
          $model = new Investigador();
        $model1 = new Usuarios();
        $model1->rol=2;
        if ($model1->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){  
       
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model1);
        }
        
        
        if ($model1->load(Yii::$app->request->post())  &&$model->load(Yii::$app->request->post()) )  {
         $model->dni = $model1->dni;
         $model1->pass= Yii::$app->getSecurity()->generatePasswordHash($model1->pass);
            if ($model1->save() && $model->save())  {
                 yii::$app->session->setFlash('success','investigador registrado con exito');
                
                    return $this->redirect(['investigador/panel']);}
          
        }else{
            $model1->pass="";
        }

        return $this->render('create', [
            'model' => $model,'model1'=>$model1,
        ]);
    }

    /**
     * Updates an existing Investigador model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
   public function actionUpdate($id)
    {
         $model = new Investigador();
        $model = $this->findModel($id);
         $user = new Usuarios();
        $user= $user->find()->where(['dni'=>$model->dni])->one();
       
        if ( $user->load(Yii::$app->request->post()) &&  $user->save() ) {
           
          if($model->load(Yii::$app->request->post()) && $model->save()) {
        
           yii::$app->session->setFlash('success','datos personales actualizados exitosamente');
        return $this->redirect(['investigador/perfil']);}  
        }
        return $this->render('update', [
            'model' => $model,'model1'=> $user, 
        ]);
    }

    /**
     * Deletes an existing Investigador model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        Usuarios::findOne(Yii::$app->user->identity->dni)->delete();
        //$this->findModel($id)->delete();
         yii::$app->session->setFlash('success','cuenta eliminada exitosamente');
        return $this->redirect(['site/index']);
    }

    /**
     * Finds the Investigador model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Investigador the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Investigador::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSesborrar(){
        $session = Yii::$app->session;
        unset($session['ciudad']);
        unset($session['sexo']);
        unset($session['edaddesde']);
        unset($session['edadhasta']);
        unset($session['imchasta']);
        unset($session['imcdesde']);
        unset($session['provincia']);
        unset($session['barrio']);
        unset($session['actividadfisica']);
       
    }

    public function BorrarFiltroTiempo(){
        $session = Yii::$app->session;
        unset($session['fecha']);
        unset($session['fechaper']);
    }

    public function actionPanel($dept=null, $loc=null){

        $model = new Filtro();
        $provincia = new Provincia();
        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['rol'=> '1']);
        $prov = ArrayHelper::map($provincia->find()->all(), 'codpcia','provincia');
        $model1 = new Paciente();
        $model->load(Yii::$app->request->post());
         $session = Yii::$app->session;
        if(array_key_exists('_csrf', $_POST)){
            if($model->fecha == "" && $model->fechadesde == ""){
                $this->actionSesborrar();
            }

        }
       if($model->fecha == "" && $model->fechadesde == ""&&$model->ciudad == ""&&$model->sexo == ""&&$model->edaddesde == ""&&$model->edadhasta == ""&&$model->imcdesde == ""&&$model->imchasta == ""&&$model->actividadfisica == ""&&$model->provincia == ""){
        $this->BorrarFiltroTiempo();
       }
        if ($model->load(Yii::$app->request->post())){
           if ($model->fecha != "") {
                    $session['fecha'] = $model->fecha;
                }else{
                    if ($model->fechadesde != "") {
                        $this->BorrarFiltroTiempo();    
                    }
                    
                }
            if ($model->fechadesde != "" && $model->fechahasta != "") {
                $fechaInicio=strtotime($model->fechadesde);
                $fechaFin=strtotime($model->fechahasta);
                if($fechaInicio < $fechaFin){
                $session['fechaper'] =[];
                $arr=[];
                    for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
                       array_push($arr, date("Y-m-d", $i));
                    }
                    $session['fechaper']=$arr;
                }else{
                    $session['fechaerror']=1;
                }
            }
            if($model->ciudad != ""){
                $dep=Departamentos::find()->where(['coddpto' => $model->ciudad])->one();
                $session['ciudad']=$dep;
            }
            if($model->sexo != ""){
                $session['sexo']=$model->sexo;
            }
            if($model->edaddesde != ""){
                $session['edaddesde']=$model->edaddesde;
            }
            if($model->edadhasta != ""){
                $session['edadhasta']=$model->edadhasta;
            }
            if($model->imcdesde != ""){
                $session['imcdesde']=$model->imcdesde;
            }
            if($model->imchasta != ""){
                $session['imchasta']=$model->imchasta;
            }
            if($model->actividadfisica != ""){
                
                $session['actividadfisica']=$model->actividadfisica;
            }
            if($model->provincia != ""){
                $provi=Provincia::find()->where(['codpcia' => $model->provincia])->one();
                $session['provincia']=$provi;

            }
            if($model->barrio != ""){
                $loc=Localidades::find()->where(['codloc' => $model->barrio])->one();
                $session['barrio']=$loc;
            }
        }
            
        if($dept == null){
            $dept = [];
        }
        if($loc == null){
            $loc=[];
        }
        
        $data = $this->actionRegistro();
        $dataprovider = new ArrayDataProvider([
        'key' => 'nro',
        'allModels' => $data,
        ]);
         return $this->render('view',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'prov' => $prov,
            'dept' => $dept,
            'loc' => $loc,
            'model'=> $model,
            'data'=> $dataprovider,
            'model1'=>$model1,
        ]);
    }

    public function actionLlenar(){
        $provincia = new Provincia();
        $departamento = new Departamentos();
        $prov = ArrayHelper::map($provincia->find()->all(), 'codpcia','provincia');
        if (array_key_exists('prov', $_POST)) {
        $dept=  ArrayHelper::map($departamento->find()->where(['codpcia'=> $_POST['prov']])->all(), 'coddpto','departamenos');
        }else{
            $dept=[];
        }
         $this->actionPanel($dept);
        
    }
    public function actionLlenarl(){
        $provincia = new Provincia();
        $departamento = new Departamentos();
        $localidades = new Localidades();
        $prov = ArrayHelper::map($provincia->find()->all(), 'codpcia','provincia');
        $dept=[];

        if (array_key_exists('dept', $_POST)) {
        echo $_POST['prov'];
         $dept=  ArrayHelper::map($departamento->find()->where(['codpcia'=> $_POST['prov']])->all(), 'coddpto','departamenos');
          $loc=  ArrayHelper::map($localidades->find()->where(['coddpto'=> $_POST['dept']])->andWhere(['codpcia'=> $_POST['prov']])->all(), 'codloc','localidad');
        }else {
            $loc=[];
            $dept=[];
        }
      $this->actionPanel($dept, $loc);
    }
    public function actionRegistro (){
        $paciente = new Paciente();
        $session = Yii::$app->session;
        $filtro=[];
        
        if($session['ciudad'] != ""){
            $filtro += [ "ciudad" => $session['ciudad']->coddpto ];
        }
        if($session['sexo'] != ""){
            $filtro += [ "sexo" => $session['sexo'] ];
        }
       
        if($session['actividadfisica'] != ""){
            $filtro += [ "actividadfisica" => $session['actividadfisica'] ];
        }
        if($session['provincia'] != ""){
            $filtro += [ "provincia" => $session['provincia']->codpcia];
        }
        if($session['barrio'] != ""){
           $filtro += [ "barrio" => $session['barrio']->codloc];
        }
        $nut="";
      if (isset(Yii::$app->user->identity->dni)) {
        if (User::isUserNutricionista(Yii::$app->user->identity->dni)){
            $filtro += [ "dninutricionista" => Yii::$app->user->identity->dni];
        }
    }
            $paciente1 = Paciente::find()->andWhere($filtro)->all();
        // print_r($paciente1);
        $dnifiltro=[];
        foreach ($paciente1 as $key => $value) {
            $guradar=true;
            if($session['imcdesde'] != ""){
                $vimc = $paciente->actionImc($value->talla, $value->peso);
               if ($vimc >= $session['imcdesde'] && $vimc <= $session['imchasta']) {
                    $guradar = true;     
                } else{
                    $guardar = false;
                }

            }else{
                $guardar=true;
            }
            if ($guardar) {
                if($session['edaddesde'] != ""){
                    $vedad = $paciente->actionEdad($value->fechanac);
                    if ($vedad >= $session['edaddesde'] && $vedad <= $session['edadhasta']){ 
                        array_push($dnifiltro, $value->dni);
                    }   
                }else {
                    array_push($dnifiltro, $value->dni);
                }   
            }
        }
        // filtro por fechas
        $filtrofecha=[];
        if ($session['fecha'] != "") {
            $filtrofecha += [ "fecha" => $session['fecha']];
        }else{
            if ($session['fechaper'] != "") {
              $filtrofecha += [ "fecha" => $session['fechaper']];  
            }
        }

        $registro = Registro::find()->where(['dni'=> $dnifiltro])->andWhere($filtrofecha)->orderBy([
                            'dni' => SORT_ASC,
                            'fecha' => SORT_ASC,])->all();
        $data = [];
        
        $paciente1 = Paciente::find()->where(['dni'=> $dnifiltro])->all();
        $registro=array_values($registro);
        $num=1;
        foreach ($registro as $k => $value) {
            
            $ali = Ali::find()->where(['id'=> $value->idAlimento])->one();            
            $valoresAli = ValoresAlimentos::find()->where(['codigo'=> $ali->codigo])->one();


            // reemplaza , por . para que sea float            
            $Agua = str_replace(',', '.', $valoresAli->Agua);
            $Energia = str_replace(',', '.', $valoresAli->Energia);
            $Proteinas = str_replace(',', '.', $valoresAli->Proteinas);
            $Lipidos = str_replace(',', '.', $valoresAli->Lipidos);
            $AcidosGrasosSaturados = str_replace(',', '.', $valoresAli->AcidosGrasosSaturados);
            $AcidosGrasosMonoinsaturados = str_replace(',', '.', $valoresAli->AcidosGrasosMonoinsaturados);
            $AcidosGrasosPoliinsaturados = str_replace(',', '.', $valoresAli->AcidosGrasosPoliinsaturados);
            $Colesterol = str_replace(',', '.', $valoresAli->Colesterol);
            $HidratosdeCarbono = str_replace(',', '.', $valoresAli->HidratosdeCarbono);
            $Fibra = str_replace(',', '.', $valoresAli->Fibra);
            $Cenizas = str_replace(',', '.', $valoresAli->Cenizas);
            $Sodio = str_replace(',', '.', $valoresAli->Sodio);
            $Potasio = str_replace(',', '.', $valoresAli->Potasio);
            $Calcio = str_replace(',', '.', $valoresAli->Calcio);
            $Fosforo = str_replace(',', '.', $valoresAli->Fosforo);
            $Hierro = str_replace(',', '.', $valoresAli->Hierro);
            $Zinc = str_replace(',', '.', $valoresAli->Zinc);
            $Niacina= str_replace(',', '.', $valoresAli->Niacina);
            $Folatos = str_replace(',', '.', $valoresAli->Folatos);
            $VitaminaA = str_replace(',', '.', $valoresAli->VitaminaA);
            $TiaminaB1 = str_replace(',', '.', $valoresAli->TiaminaB1);
            $RiboflavinaB2 = str_replace(',', '.', $valoresAli->RiboflavinaB2);
            $VitaminaB12 = str_replace(',', '.', $valoresAli->VitaminaB12);
            $VitaminaC = str_replace(',', '.', $valoresAli->VitaminaC);
            $VitaminaD = str_replace(',', '.', $valoresAli->VitaminaD);
            $sex="";
           
            $dato = array(
                'dni' => $value->dni,
                'fecha' => $value->fecha,
                'nro'=>$num,
                'sexo'=>'',
                'dias'=>'',
                'Agua' => $value->gramos * $Agua / 100,
                'Energia' => $value->gramos * $Energia / 100,
                'Proteinas' => $value->gramos * $Proteinas / 100,
                'Lipidos' => $value->gramos * $Lipidos / 100,
                'AcidosGrasosSaturados' => $value->gramos * $AcidosGrasosSaturados / 100,
                'AcidosGrasosMonoinsaturados' => $value->gramos * $AcidosGrasosMonoinsaturados / 100,
                'AcidosGrasosPoliinsaturados' => $value->gramos * $AcidosGrasosPoliinsaturados / 100,
                'Colesterol' => $value->gramos * $Colesterol / 100,
                'HidratosdeCarbono' => $value->gramos * $HidratosdeCarbono / 100,
                'Fibra' => $value->gramos * $Fibra / 100,
                'Cenizas' => $value->gramos * $Cenizas / 100,
                'Sodio' => $value->gramos * $Sodio / 100,
                'Potasio' => $value->gramos * $Potasio / 100,
                'Calcio' => $value->gramos * $Calcio / 100,
                'Fosforo' => $value->gramos * $Fosforo / 100,
                'Hierro' => $value->gramos * $Hierro / 100,
                'Zinc' => $value->gramos * $Zinc / 100,
                'Niacina' => $value->gramos * $Niacina / 100,
                'Folatos' => $value->gramos * $Folatos / 100,
                'VitaminaA' => $value->gramos * $VitaminaA / 100,
                'TiaminaB1' => $value->gramos * $TiaminaB1 / 100,
                'RiboflavinaB2' => $value->gramos * $RiboflavinaB2 / 100,
                'VitaminaB12' => $value->gramos * $VitaminaB12 / 100, 
                'VitaminaC' => $value->gramos * $VitaminaC / 100,
                'VitaminaD' => $value->gramos * $VitaminaD / 100);

            
            if ($k==0){
                $key=0;
                $dias=1;
                
                    
                $dato['nro']=$num;
                $dato['sexo']=$paciente1['0']->sexo;
                $dato['peso']=$paciente1['0']->peso;
                $dato['talla']=$paciente1['0']->talla;
                $imc = $this->actionImc($paciente1['0']->talla, $paciente1['0']->peso);
                $dato['imc']=$imc;
                $pesoideal=$this->actionImcObjetivo ($imc, $paciente1['0']->peso);
                $dato['pesoideal']=$pesoideal;
                $act = $this->actionActividadFisica($paciente1['0']->actividadfisica);
                $dato['actividadfisica']=$act;
                
                $consumo = $this->actionObjetivo ($paciente1['0']->peso,$paciente1['0']->talla,$paciente1['0']->fechanac,$paciente1['0']->sexo,$imc,$paciente1['0']->actividadfisica);
                $dato['consumo']=$consumo;
                $GastoCalorico = $this->actionGastoCalorico ($paciente1['0']->peso,$paciente1['0']->talla,$paciente1['0']->fechanac,$paciente1['0']->sexo,$imc,$paciente1['0']->actividadfisica);
                $dato['GastoCalorico']=$GastoCalorico;
                $dato['dias']=$dias;
                array_push($data,$dato);
                


            }else{
            if ($data[$key]['fecha'] != $value->fecha) {
                if ($data[$key]['dni']== $value->dni) {
                    $dias++;
                }
                 
            }
            if($data[$key]['dni']!= $value->dni){

            }
             if($data[$key]['dni']== $value->dni) {
                    $sex="";
                    
                    foreach ($paciente1 as  $valor) {
                        if($data[$key]['dni'] == $valor->dni){
                           $sex=$valor->sexo;
                            $peso=$valor->peso;
                            $talla=$valor->talla;
                            $imc = $this->actionImc($valor->talla, $valor->peso);
                            $pesoideal=$this->actionImcObjetivo ($imc, $valor->peso);
                            $act = $this->actionActividadFisica($valor->actividadfisica);
                            $consumo = $this->actionObjetivo ($valor->peso,$valor->talla,$valor->fechanac,$valor->sexo,$imc,$valor->actividadfisica);
                            $GastoCalorico =$this->actionGastoCalorico ($valor->peso,$valor->talla,$valor->fechanac,$valor->sexo,$imc,$valor->actividadfisica);
                        }
                    }

                $dato['nro']=$num;
                $dato['sexo']=$sex;
                $dato['dias']=$dias;
                
                $data1= array(
                'nro'=>$num,
                'sexo'=>$sex,
                'dias'=>$dias,
                'peso'=>$peso,
                'talla'=>$talla,
                'imc'=>$imc,
                'pesoideal'=>$pesoideal,
                'actividadfisica'=>$act,
                'consumo'=>$consumo,
                'GastoCalorico'=>$GastoCalorico,
                'dni' => $value->dni,
                'fecha' => $value->fecha,
                'Agua' => $data[$key]['Agua'] + $dato['Agua'],
                'Energia' =>$data[$key]["Energia"] + $dato["Energia"],
                'Proteinas' =>$data[$key]["Proteinas"] + $dato["Proteinas"],
                'Lipidos' =>$data[$key]["Lipidos"] + $dato["Lipidos"],
                'AcidosGrasosSaturados' =>$data[$key]["AcidosGrasosSaturados"] + $dato["AcidosGrasosSaturados"],
                'AcidosGrasosMonoinsaturados' =>$data[$key]["AcidosGrasosMonoinsaturados"] + $dato["AcidosGrasosMonoinsaturados"],
                'AcidosGrasosPoliinsaturados' =>$data[$key]["AcidosGrasosPoliinsaturados"] + $dato["AcidosGrasosPoliinsaturados"],
                'Colesterol' =>$data[$key]["Colesterol"] + $dato["Colesterol"],
                'HidratosdeCarbono' =>$data[$key]["HidratosdeCarbono"] + $dato["HidratosdeCarbono"],
                'Fibra' =>$data[$key]["Fibra"] + $dato["Fibra"],
                'Cenizas' =>$data[$key]["Cenizas"] + $dato["Cenizas"],
                'Sodio' =>$data[$key]["Sodio"] + $dato["Sodio"],
                'Potasio' =>$data[$key]["Potasio"] + $dato["Potasio"],
                'Calcio' =>$data[$key]["Calcio"] + $dato["Calcio"],
                'Fosforo' =>$data[$key]["Fosforo"] + $dato["Fosforo"],
                'Hierro' =>$data[$key]["Hierro"] + $dato["Hierro"],
                'Zinc' =>$data[$key]["Zinc"] + $dato["Zinc"],
                'Niacina' =>$data[$key]["Niacina"] + $dato["Niacina"],
                'Folatos' =>$data[$key]["Folatos"] + $dato["Folatos"],
                'VitaminaA' =>$data[$key]["VitaminaA"] + $dato["VitaminaA"],
                'TiaminaB1' =>$data[$key]["TiaminaB1"] + $dato["TiaminaB1"],
                'RiboflavinaB2' =>floatval($data[$key]["RiboflavinaB2"]) + floatval($dato["RiboflavinaB2"]),
                'VitaminaB12' =>$data[$key]["VitaminaB12"] + $dato["VitaminaB12"],
                'VitaminaC' =>$data[$key]["VitaminaC"] + $dato["VitaminaC"],
                'VitaminaD' =>$data[$key]["VitaminaD"] + $dato["VitaminaD"],);

                $data[$key]=$data1;
                // Arrays con promedios y datos a mostrar
                // ==================================================

                if ($value === end($registro)) {

                    $num++;
                   
                    $data[$key]['Agua']=$data[$key]['Agua']/$dias;
                    $data[$key]['Energia']=$data[$key]['Energia']/$dias;
                    $data[$key]['Proteinas']=$data[$key]['Proteinas']/$dias;
                    $data[$key]['Lipidos']=$data[$key]['Lipidos']/$dias;
                    $data[$key]['AcidosGrasosSaturados']=$data[$key]['AcidosGrasosSaturados']/$dias;
                    $data[$key]['AcidosGrasosMonoinsaturados']=$data[$key]['AcidosGrasosMonoinsaturados']/$dias;
                    $data[$key]['AcidosGrasosPoliinsaturados']=$data[$key]['AcidosGrasosPoliinsaturados']/$dias;
                    $data[$key]['Colesterol']=$data[$key]['Colesterol']/$dias;
                    $data[$key]['HidratosdeCarbono']=$data[$key]['HidratosdeCarbono']/$dias;
                    $data[$key]['Fibra']=$data[$key]['Fibra']/$dias;
                    $data[$key]['Cenizas']=$data[$key]['Cenizas']/$dias;
                    $data[$key]['Sodio']=$data[$key]['Sodio']/$dias;
                    $data[$key]['Potasio']=$data[$key]['Potasio']/$dias;
                    $data[$key]['Calcio']=$data[$key]['Calcio']/$dias;
                    $data[$key]['Fosforo']=$data[$key]['Fosforo']/$dias;
                    $data[$key]['Hierro']=$data[$key]['Hierro']/$dias;
                    $data[$key]['Zinc']=$data[$key]['Zinc']/$dias;
                    $data[$key]['Niacina']=$data[$key]['Niacina']/$dias;
                    $data[$key]['Folatos']=$data[$key]['Folatos']/$dias;
                    $data[$key]['VitaminaA']=$data[$key]['VitaminaA']/$dias;
                    $data[$key]['TiaminaB1']=$data[$key]['TiaminaB1']/$dias;
                    $data[$key]['RiboflavinaB2']=$data[$key]['RiboflavinaB2']/$dias;
                    $data[$key]['VitaminaB12']=$data[$key]['VitaminaB12']/$dias;
                    $data[$key]['VitaminaC']=$data[$key]['VitaminaC']/$dias;
                    $data[$key]['VitaminaD']=$data[$key]['VitaminaD']/$dias;


                }
                }else {
                   
                    $num++;
                    
                    $data[$key]['Agua']=$data[$key]['Agua']/$dias;
                    $data[$key]['Energia']=$data[$key]['Energia']/$dias;
                    $data[$key]['Proteinas']=$data[$key]['Proteinas']/$dias;
                    $data[$key]['Lipidos']=$data[$key]['Lipidos']/$dias;
                    $data[$key]['AcidosGrasosSaturados']=$data[$key]['AcidosGrasosSaturados']/$dias;
                    $data[$key]['AcidosGrasosMonoinsaturados']=$data[$key]['AcidosGrasosMonoinsaturados']/$dias;
                    $data[$key]['AcidosGrasosPoliinsaturados']=$data[$key]['AcidosGrasosPoliinsaturados']/$dias;
                    $data[$key]['Colesterol']=$data[$key]['Colesterol']/$dias;
                    $data[$key]['HidratosdeCarbono']=$data[$key]['HidratosdeCarbono']/$dias;
                    $data[$key]['Fibra']=$data[$key]['Fibra']/$dias;
                    $data[$key]['Cenizas']=$data[$key]['Cenizas']/$dias;
                    $data[$key]['Sodio']=$data[$key]['Sodio']/$dias;
                    $data[$key]['Potasio']=$data[$key]['Potasio']/$dias;
                    $data[$key]['Calcio']=$data[$key]['Calcio']/$dias;
                    $data[$key]['Fosforo']=$data[$key]['Fosforo']/$dias;
                    $data[$key]['Hierro']=$data[$key]['Hierro']/$dias;
                    $data[$key]['Zinc']=$data[$key]['Zinc']/$dias;
                    $data[$key]['Niacina']=$data[$key]['Niacina']/$dias;
                    $data[$key]['Folatos']=$data[$key]['Folatos']/$dias;
                    $data[$key]['VitaminaA']=$data[$key]['VitaminaA']/$dias;
                    $data[$key]['TiaminaB1']=$data[$key]['TiaminaB1']/$dias;
                    $data[$key]['RiboflavinaB2']=$data[$key]['RiboflavinaB2']/$dias;
                    $data[$key]['VitaminaB12']=$data[$key]['VitaminaB12']/$dias;
                    $data[$key]['VitaminaC']=$data[$key]['VitaminaC']/$dias;
                    $data[$key]['VitaminaD']=$data[$key]['VitaminaD']/$dias;
                // Fin Arrays con promedios y datos a mostrar
                // ==================================================               
                $dias=1;
               
                $sex="";
                    
                    foreach ($paciente1 as  $valor) {
                        if($data[$key]['dni'] == $valor->dni){
                            $sex=$valor->sexo;
                           $peso=$valor->peso;
                            $talla=$valor->talla;
                            $imc = $this->actionImc($valor->talla, $valor->peso);
                            $pesoideal=$this->actionImcObjetivo ($imc, $valor->peso);
                            $act = $this->actionActividadFisica($valor->actividadfisica);
                            $consumo = $this->actionObjetivo ($valor->peso,$valor->talla,$valor->fechanac,$valor->sexo,$imc,$valor->actividadfisica);
                            $GastoCalorico =$this->actionGastoCalorico ($valor->peso,$valor->talla,$valor->fechanac,$valor->sexo,$imc,$valor->actividadfisica);
                        }
                    }
                $dato['nro']=$num;
                $dato['sexo']=$sex;
                $dato['dias']=$dias;
                $dato['peso']=$peso;
                $dato['talla']=$talla;
                $dato['imc']=$imc;
                $dato['pesoideal']=$pesoideal;
                $dato['actividadfisica']=$act;
                $dato['consumo']=$consumo;
                $dato['GastoCalorico']=$GastoCalorico;
                $key++; 
                array_push($data,$dato);
                     
            }        
        }

        }
        
        foreach ($data as $key => $value) {
            unset($data[$key]['dni']);
            unset($data[$key]['fecha']);
        }
        $data=array_values($data);
        return $data;
        //print_r($data);
    }

  
    public function actionExportar (){
    
       $data = $this->actionRegistro(); 
     $file = \Yii::createObject([
    'class' => 'codemix\excelexport\ExcelFile',

   //'writerClass' => '\PHPExcel_Writer_Excel5', // Override default of `\PHPExcel_Writer_Excel2007`
    'sheets' => [
    'Result per Country' => [   // Name of the excel sheet
                'data' => $data,

            // Set to `false` to suppress the title row
            'titles' => [
                'nro',
                'sexo',
                'días',
                'peso',
                'talla',
                'imc',
                'pesoideal',
                'actividadfisica',
                'consumo',
                'GastoCalorico',
                'Agua',
                'Energia',
                'Proteinas',
                'Lipidos',
                'AcidosGrasosSaturados',
                'AcidosGrasosMonoinsaturados',
                'AcidosGrasosPoliinsaturados',
                'Colesterol',
                'HidratosdeCarbono',
                'Fibra',
                'Cenizas',
                'Sodio',
                'Potasio',
                'Calcio',
                'Fosforo',
                'Hierro',
                'Zinc',
                'Niacina',
                'Folatos',
                'VitaminaA',
                'TiaminaB1',
                'RiboflavinaB2',
                'VitaminaB12',
                'VitaminaC',
                'VitaminaD',
            ],
        ],
    ],
]);
$file->send('reg.xlsx');
}

public function actionPerfil()
    {
        $dni=Yii::$app->user->identity->dni;
        $model = Investigador::find()->joinwith('usuarios')->where(['investigador.dni' => $dni])->one();
         // $model1 = Usuarios::find($dni)->one();
         // $model1->pass="";
        return $this->render('perfil', [
            'model' => $model,
           
        ]);
       
    }
    public function actionPass()
    {   
        $dni=Yii::$app->user->identity->dni;
        $user=new Usuarios;
        $model= $user->find()->where(['dni'=> $dni])->one();
        $p= Yii::$app->request->post('pas');
        $p1= Yii::$app->request->post('pas1');
        if(isset($p)){
            $model->pass= Yii::$app->getSecurity()->generatePasswordHash($p);  
            $model->save();
            yii::$app->session->setFlash('success','contraseña actulizada'); 
            return $this->redirect(['investigador/perfil']);
        }
      
       
    }

    public function actionImc($altura, $peso){
        $altura=$altura /100;
        return $peso / pow($altura, 2);
    }

    public function actionImcObjetivo ($imc, $peso){
        if ($imc != 0) {
        return (22 * $peso) / $imc;
    } else {
        return 0;
    }
    }
    public function actionActividadFisica($act){
         if ($act == 1){
            return 1.2;
        }else if ($act == 2){
            return 1.375;
        }else if ($act == 3){
            return 1.55;
        }else if ($act == 4){
            return 1.725;
        }else if ($act == 5){
            return 1.9;
        }
    }
    public function actionObjetivo ($peso,$talla,$fechanac,$sexo,$imc,$act){
        $edad=$this->edad($fechanac);
        if ($sexo) {
            $tmb=(10*$peso)+(6.25 * $talla)-(5*$edad)+5;
        }else{
            $tmb=(10*$peso)+(6.25 * $talla)-(5*$edad)-161;
        }
        if ($act == 0) {
           $objetivo = 0;
        }else if ($act == 1) {
           $objetivo = $tmb * 1.2;
        }else if ($act == 2) {
            $objetivo = $tmb * 1.375;
        }else if ($act == 3) {
            $objetivo = $tmb * 1.55;
        }else if ($act == 4) {
            $objetivo = $tmb * 1.725;
        }else if ($act == 5) {
            $objetivo = $tmb * 1.9;
        }
        
        if ($imc < 18.5) {
            if ($objetivo) {
                $objetivo = $objetivo +144;
            }
        }else if ($imc > 24.99) {
            if ($objetivo) {
                $objetivo = $objetivo -144;
            }
        }
        return $objetivo;
    }
 public function edad($fechanac){
       $cumpleanos = new DateTime($fechanac);
        $hoy = new DateTime();
        $annos = $hoy->diff($cumpleanos);
        return $annos->y;
    }
    public function actionGastoCalorico ($peso,$talla,$fechanac,$sexo,$imc,$act){
        $edad=$this->edad($fechanac);
        if ($sexo) {
            $tmb=(10*$peso)+(6.25 * $talla)-(5*$edad)+5;
        }else{
            $tmb=(10*$peso)+(6.25 * $talla)-(5*$edad)-161;
        }
        if ($act == 0) {
           $objetivo = 0;
        }else if ($act == 1) {
           $objetivo = $tmb * 1.2;
        }else if ($act == 2) {
            $objetivo = $tmb * 1.375;
        }else if ($act == 3) {
            $objetivo = $tmb * 1.55;
        }else if ($act == 4) {
            $objetivo = $tmb * 1.725;
        }else if ($act == 5) {
            $objetivo = $tmb * 1.9;
        }
        return $objetivo;
    }
}