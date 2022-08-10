<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use app\models\Paciente;
use app\models\Usuarios;
use app\models\Peso;
use app\models\Registro;
use app\models\Agua;
use app\models\Provincia;
use app\models\Ali;
use app\models\ValoresAlimentos;
use app\models\Departamentos;
use app\models\Localidades;
use app\models\PacienteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use Date;
use DateTime;
/**
 * PacienteController implements the CRUD actions for Paciente model.
 */
class PacienteController extends Controller
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
                        'actions' => ['create','llenar','llenarl',],
                         'allow' => true,
                         'roles' => ['?'],
                    ],
                    [
                        //El administrador tiene permisos sobre las siguientes acciones
                        'actions' => ['logout', 'create','llenar','llenarl','view'],
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
                        'actions' => ['logout', 'create','llenar','llenarl','view'],
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
                       'actions' => ['logout', 'user', 'peso','llenar','llenarl','agua','update', 'index','perfil', 'view','acti','delete', 'create'],
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
     * Lists all Paciente models.
     * @return mixed
     */
    public function actionIndex()
    {
        $ali = new Ali;
        $objetivo="";
        $valor= new ValoresAlimentos;
        $searchModel = new PacienteSearch();
        $registro = new Registro;
        $user=Usuarios::findOne(['dni' => Yii::$app->user->identity->id]);
        $peso=Peso::findAll(['dni' => Yii::$app->user->identity->id]);
        $agua=Agua::findAll(['idpaciente' => Yii::$app->user->identity->id]);
        $regdiario=[];
        $existe=$registro->find()->where(['dni'=>Yii::$app->user->identity->dni, 'fecha'=>date('Y-m-d')])->all();
        foreach ($existe as $key => $value) {
            $al = $ali->find()->where(['id'=>$value->idAlimento])->one();
            $val = $valor->find()->where(['codigo'=> $al->codigo])->one();
            $regdiario[$key]['calorias'] = $val->Energia;
            $regdiario[$key]['proteinas'] = $val->Proteinas;
            $regdiario[$key]['HidratosdeCarbono'] = $val->HidratosdeCarbono;
            $regdiario[$key]['grasas'] = $val->Lipidos;
            $regdiario[$key]['Alimento']= $al->alimento;
            $regdiario[$key]['Gramos']= $value->gramos;
            $regdiario[$key]['fecha']=$value->fecha;
        }
        $paciente=Paciente::findOne(['dni' => Yii::$app->user->identity->id]);
        $imc = $this->actionImc($paciente->talla, $paciente->peso);
        $clasificacion = $this->actionClasificacion ($imc);
        $pesoObjetivo = $this->actionImcObjetivo ($imc, $paciente->peso);
        $imc=number_format($imc, 2, ',', '');
        $pesoObjetivo=number_format($pesoObjetivo, 2, ',', '');

        // buscador de alimentos
        if(array_key_exists('alimento', $_POST)){
            $alimento = $_POST['alimento'];

            $search = Html::encode($alimento);
            $query = "SELECT * FROM alimentos WHERE alimento LIKE '%".$search."%'";
            $model = $ali->findBySql($query)->all();
            $total="";
            $total .= "<ul class='busqueda'>";
            foreach ($model as $key => $value) {
                $total .="<li>
                    <div class='alert alert-dismissible alert-success alimen' onclick='addalimento(\"$value->codigo\", \"$value->alimento\",\"$value->id\");'>
                        <span><strong>$value->alimento</strong></span>
                    </div>
                </li>";
            }
            $total .= "</ul>";
            if ($total == "") {

                return"<li>
                    <div class='alert alert-dismissible alert-danger alimen '>
                        <span><strong>No se encontraron resultados</strong></span>
                    </div>
                </li>";
                
            }else{
                return $total;
            }
        }
         
        $gramos = "";
        if(array_key_exists('codigo', $_POST)){
            $alimento = $_POST['al'];
            $codigo = $_POST['codigo'];
            $idal = $_POST['idal'];
             $cal = 0;
                $carbo=0;
                $proteinas=0;
                $grasas=0; 
            if(array_key_exists('gramos', $_POST)){
                $gramos = $_POST['gramos'];
               
                $alimentovalor=$valor->find()->where(['codigo' => $codigo])->one();

                $cal = floatval($alimentovalor->Energia) * floatval($gramos) / 100;
                $cal= number_format((float)$cal, 2, '.', '');
                $carbo=floatval($alimentovalor->HidratosdeCarbono) * 100 / floatval($alimentovalor->Energia);
               $carbo= number_format((float)$carbo, 2, '.', '');
               
                $proteinas=floatval($alimentovalor->Proteinas) * 100 / floatval($alimentovalor->Energia);
               $proteinas= number_format((float)$proteinas, 2, '.', '');
                $grasas=floatval($alimentovalor->Lipidos) * 100 / floatval($alimentovalor->Energia);
                $grasas= number_format((float)$grasas, 2, '.', '');
            }else{
                $cal = 0;
                $carbo=0;
                $proteinas=0;
                $grasas=0; 
            }
              $objetivo= $this->actionObjetivo($paciente->peso, $paciente->talla,$paciente->fechanac,$paciente->sexo,$imc, $paciente->actividadfisica);

              $consumoAlimento = $cal * 100 / $objetivo;
              $consumoAlimento = number_format((float) $consumoAlimento , 2, '.', '');
              $cons=$consumoAlimento;
              if(array_key_exists('coccion', $_POST)){
                $coccion = $_POST['coccion'];
                if ($coccion == 1) {
                  $correc = str_replace(',', '.', $alimentovalor->FactorCorrec);;
                  $cal = $cal * $correc;
                }
              }
              if ($consumoAlimento > 100) {
                $cons=100;
              }
              $tip1="checked";
                  $tip2="";
              if (array_key_exists('coccion',$_POST)) {
                if ($_POST['coccion'] == 1) {
                  $tip1="checked";
                  $tip2="";    
                }else{
                  $tip1="";
                  $tip2="checked";
                }
              }else{
                $tip1="checked";
                $tip2="";
              } 
            $total = "<ul class='busqueda'>";
            $total .="<li>
                    <div class='alert alert-dismissible alert-success alimen'>
                        <span><strong>$alimento</strong></span>
                    </div>
                </li>
                </ul>
                <div class='col-md-7 form-inline racion'>
             
                    <label for='racion-alimento'>Tamaño de ración</label>
                    <input type='number' id='racion-alimento' value='".$gramos."' onBlur='racion(\"$codigo\",\"$alimento\", \"$idal\");' class='form-control' placeholder='Gramos'>
                   <button type = 'button' onclick='racion(\"$codigo\",\"$alimento\", \"$idal\");' class = 'btn btn-success btn-cal3'>Calcular</button>
                    <span class='col-xs-12 alertas' id='calculo-alert'></span>

                </div>

                <div class='col-xs-12 col-md-5'>
                <h4 class='text-sm-rigth col-md-5 titulo'>Cocción</h4>
                <ul class = 'navbar-nav mr-auto col-md-7 alinear'>
                    <li class='input-group nav-item1'> 
                        <input type='radio' name='tipo' id= 'tipo1' value='1'".$tip1."> <label for='tipo1'>Cocido</label>
                    </li>
                    <li class='input-group nav-item1'>
                        <input type='radio' name='tipo' id='tipo2' value='0'".$tip2."><label for='tipo2'>Crudo</label>
                    </li>
                    
                </ul>
                <span class='col-xs-12 alertas' id='coccion-alert'></span>
            </div>
            <div class='col-xs-12'>
                <div class='col-xs-12 col-sm-3'>
                    <h3 id='caloria' class='text-center calalimentos1'>".$cal."</h3>
                    <h4 class='text-center calalimentos'>Calorías</h4>

                </div>
                <div class='col-xs-12 col-sm-3'>
                    <h4 class='text-center calalimentos1'>".$carbo."%</h4>
                    <h5 class='text-center caralimentos'>Carbohidratos</h5>
                </div>
                <div class='col-xs-12 col-sm-3'>
                    <h4 class='text-center calalimentos1'>".$grasas."</h4>
                    <h5 class='text-center grasaalimentos'>Grasas</h5>
                </div>
                <div class='col-xs-12 col-sm-3'>
                    <h4 class='text-center calalimentos1'>".$proteinas."%</h4>
                    <h5 class='text-center protalimentos'>Proteínas</h5>
                </div>
                <div class='col-xs-12'>
                  <h5>Porcentaje del objetivo</h5>
                </div>
            </div>

            <div class='progress col-xs-12 progrsalimento'>

              <div class='progress-bar bg-info' role='progressbar' style='width: ". $cons."%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'>". $consumoAlimento."%</div>
            </div>";
            $total .= "<div class='col-xs-12'><button type = 'button' onclick='guardar(\"$codigo\",\"$alimento\", \"$idal\", \"$gramos\");' class = 'btn btn-success'>Enviar</button></div> ";
            return $total;
        }
        // Fin buscador

        if (array_key_exists('idal', $_POST)) {
            $idal = $_POST['idal'];
            $coccion = $_POST['coccion'];
            $gramos = $_POST['gramos'];
            // return date('Y-m-d');
            if($this->guardarregistro($idal, $coccion, $gramos)){
                return "<ul class='busqueda'>
                <li>
                    <div class='alert alert-dismissible alert-info alimen'>
                        <span><strong>Agregar mas alimentos</strong></span>
                    </div>
                </li>
            </ul>";
           }
        }
      $objetivo= $this->actionObjetivo($paciente->peso, $paciente->talla,$paciente->fechanac,$paciente->sexo,$imc, $paciente->actividadfisica);
        return $this->render('index', ['user'=> $user, 'imc'=>$imc, 'clasificacion' => $clasificacion, 'pesoObjetivo' => $pesoObjetivo, 'paciente'=> $paciente,'peso'=>$peso, 'regdiario'=>$regdiario,'agua'=>$agua, 'objetivo' => $objetivo]);
    }
public function actionPeso()
    {   $reg=new Peso();
        $f=date("Y-m-d"); 
        $dni=Yii::$app->user->identity->dni;
        $model = Paciente::findOne(['dni'=>$dni]);
         if ($model->load(Yii::$app->request->post()))  {
      $peso = Yii::$app->request->post('Paciente');
      $es=Peso::find()->where(['dni'=>$dni,'fecha'=>$f])->one();
    
      if($es!=""){ 

       $es->peso=$peso['peso']; 
        $es->update();
      }else{
       $reg->dni=$dni; 
       $reg->peso=$peso['peso']; 
       $reg->fecha=date("Y-m-d");
       $reg->save();
       }  
           $model->update();
             yii::$app->session->setFlash('success','peso actualizado'); 
           return $this->redirect(['paciente/index']); 
         }else{ yii::$app->session->setFlash('danger','error al actulizar peso');
       return $this->redirect(['paciente/index']);}
      }
       
       
     public function actionAgua()
    {   $reg=new Agua();
         $f=date("Y-m-d"); 
         $r=0;
        $dni=Yii::$app->user->identity->dni;
         if (Yii::$app->request->post())  {
      $agua = Yii::$app->request->post('total');
       $es=Agua::find()->where(['idpaciente'=>$dni,'fecha'=>$f])->one();
       $a=$es->cantidad;
       if($es!="" ){ $r=1;}
       if($r==1){ 
       $es->cantidad+=$agua; 
       if(  $es->cantidad>7000){ $es->cantidad=7000;}
        $es->update();
       }else{
       $reg->idpaciente=$dni; 
     $reg->cantidad=$agua; 
       $reg->fecha=date("Y-m-d"); 
            $reg->save(); } 
            if( $a<7000){
             yii::$app->session->setFlash('success','Comsumo de agua registrado exitosamente');  
            
          }else{ yii::$app->session->setFlash('danger','No puede consumir mas agua por hoy'); }
            
           return $this->redirect(['paciente/index']); 
         }else{ yii::$app->session->setFlash('danger','error al actulizar agua');
       return $this->redirect(['paciente/index']);}
      
       
    }



   

       
    public function guardarregistro($idal, $coccion, $gramos){
        $registro = new Registro;
        $registro->load(Yii::$app->request->post());
        $registro->dni = intval(Yii::$app->user->identity->dni);
        $registro->idAlimento = intval($idal);
        $registro->gramos = intval($gramos);
        $registro->coccion = intval($coccion);
        $registro->fecha  = date('Y-m-d');
        $registro->tipocomida= 1;
        
        $existe=$registro->find()->where(['idAlimento'=>$registro->idAlimento, 'fecha'=>$registro->fecha])->one();
        
       
        if(!$existe){
            if ($registro->save()) {
                return true;
            }else {
                return false;
            }
        }else{
            
            $existe->gramos = $gramos + $existe->gramos ;
            if ($existe->save()) {
                return true;
            }else {
                return false;
            }
        }
        
    }

    /**
     * Displays a single Paciente model.
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
     * Creates a new Paciente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($dept=null, $loc=null)
    {
        $model = new Paciente();
        $model1 = new Usuarios();
        $model1->scenario = 'act';
        $provincia = new Provincia();
        $departamento = new Departamentos();
        $peso= new Peso();
          $nutri=Usuarios::findAll(['rol'=>'3']);
          foreach ($nutri as $n) {
           $n->nombre=$n->nombre." ".$n->apellido;
          }
           $nut= ArrayHelper::map($nutri,'dni','nombre');
        
        if ($model->load(Yii::$app->request->post())  && $model1->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return array_merge(ActiveForm::validate($model), ActiveForm::validate($model1));

        }
        
        
        $model1->rol=1;
        if ($model1->load(Yii::$app->request->post())){
        
        $model->dni=$model1->dni;
        if ($model->load(Yii::$app->request->post()))  {
             $peso->dni= $model->dni;
             $peso->peso= $model->peso;
              $peso->fecha=date("Y-m-d"); 

            // if($model->validate()) {
                  if (isset(Yii::$app->user->identity->dni)) {
                if (User::isUserNutricionista(Yii::$app->user->identity->dni)){
                $model->dninutricionista=Yii::$app->user->identity->dni;
                    }
            }

$model1->pass= Yii::$app->getSecurity()->generatePasswordHash( $model1->pass);
                if ( $model1->save(false) && $model->save() && $peso->save())  {
                  $peso->dni = $model->dni;
                  $peso->peso = $model->peso;
                  $peso->fecha = date('Y-m-d');
                  if ($peso->save()) {
                  
                if (isset(Yii::$app->user->identity->dni)) {
                     yii::$app->session->setFlash('success','paciente registrado con exito');
                    if (User::isUserNutricionista(Yii::$app->user->identity->dni)){ return $this->redirect(['nutricionista/index']);
                    }else{ 
                        return $this->redirect(['investigador/panel']);}
               
                }  else {  //yii::$app->session->setFlash('success','registro exitoso');
            return $this->redirect(['index']);}
                    } 
                    }
                // }else{
                //     $model1->pass = "";
                // }
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
            'model' => $model,'model1'=>$model1, 'prov'=>$prov, 'dept' => $dept, 'loc' => $loc,'nut'=>$nut
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

     public function actionActi(){


        $paciente=Paciente::findOne(['dni' => Yii::$app->user->identity->id]);
        
        if (isset ($_POST['act']) || $_POST['act'] == 1 || $_POST['act'] == 2 || $_POST['act'] == 3 || $_POST['act'] == 4    ) {
                
            $paciente->actividadfisica = $_POST['act'];
            
            if ($paciente->update()) {

                $datos = array(
                    'estado' => 'Actividad modificada exitosamente',
                    );
                return json_encode($datos);
            }else{

                $datos = array(
                    'estado' => 'Error',
                    );
                return json_encode($datos);
            }
        }else {
                $datos = array(
                    'estado' => 'Datos incorrectos',
                    );
                return json_encode($datos);
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
    public function actionImc($altura, $peso){
        $altura=$altura /100;
        return $peso / pow($altura, 2);
    }

    public function actionImcObjetivo ($imc, $peso){
      if ($peso != 0) {
        return (22 * $peso) / $imc;
      }else{
        return 0;
      }
    }

    public function actionClasificacion ($imc){
        if ($imc < 16.00){
            return "Infrapeso: Delgadez Severa";
        }else if($imc >= 16.00 && $imc <= 16.99){
            return "Infrapeso: Delgadez moderada";
        }else if($imc >= 17.00 && $imc <= 18.49){
            return "Infrapeso: Delgadez aceptable";
        }else if($imc >= 18.50 && $imc <= 24.99){
            return "Peso Normal";
        }else if($imc >= 25.00  && $imc <= 29.99){
            return "Sobrepeso";
        }else if($imc >= 30.00 && $imc <= 34.99){
            return "Obeso: Tipo I";
        }else if($imc >= 35.00 && $imc <= 40.00){
            return "Obeso: Tipo II";
        }else if($imc > 40.00){
            return "Obeso: Tipo III";
        }
    }
    /**
     * Updates an existing Paciente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$comp=1, $iddept=null, $idloc=null)
    {
        $model = $this->findModel($id);
        $model1 = new Usuarios();
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
        $model = Paciente::find()->joinwith('usuarios')->where(['pacientes.dni' => $dni])->one();
         $p= Provincia::find() ->where(['codpcia' => $model->provincia])->one();
     $d=Departamentos::find() ->where(['codpcia' => $model->provincia,'coddpto' => $model->ciudad])->one();
     $l=localidades::find() ->where(['codpcia' => $model->provincia,'coddpto' => $model->ciudad,'codloc' => $model->barrio])->one();
     if($model->sexo==1){ $sexo="Masculino";}else{ $sexo="Femenino";}
    
         $model->provincia=$p->provincia; 
         $model->ciudad=$d->departamenos; 
         $model->barrio=$l->localidad;
          $model->sexo=$sexo;
         
        return $this->render('view', [
            'model' => $model,
           
        ]);
    }

   
    /**
     * Deletes an existing Paciente model.
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
     * Finds the Paciente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Paciente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Paciente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
   
    public function actionUser(){
        return $this->render('/site/user');
    }
}
