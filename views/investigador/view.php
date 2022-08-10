<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\Investigador */

if (isset(Yii::$app->user->identity->dni)) {
 if (User::isUserNutricionista(Yii::$app->user->identity->dni)){

   $this->title = 'Datos de los pacientes';  
    $this->params['breadcrumbs'][] = ['label' => 'Nutricionista', 'url' => ['nutricionista/index']];
    $this->params['breadcrumbs'][] = $this->title;  
 }else{
    
    $this->title = 'Investigador';
    $this->params['breadcrumbs'][] = $this->title;?>

 <p> <a href="<?php echo Url::base(); ?>/index.php?r=paciente/create"  class="btn btn-primary mb-5">Alta Paciente</a>
    <a href="<?php echo Url::base(); ?>/index.php?r=nutricionista/create" class="btn btn-primary mb-5">Alta Nutricionista</a>
    <a href="<?php echo Url::base(); ?>/index.php?r=investigador/create" class="btn btn-primary mb-5">Alta Investigador</a></p>
<?php 
}
}
?>

  
<?= $this->render('_filtro', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'prov' => $prov,
        'dept' => $dept,
        'loc' => $loc,
    ]) ?>
<?= $this->render('_filtro_tiempo', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'prov' => $prov,
        'dept' => $dept,
        'loc' => $loc,
    ]) ?>

<div class="investigador-view">
  

<?php 
    if (isset(Yii::$app->user->identity->dni)) {
 if (User::isUserInvestigador(Yii::$app->user->identity->dni)){  ?>

    <?php $this->beginBlock('block1'); ?>
    <h1 class="title-inv"><?= Html::encode($this->title) ?></h1>
   
    <?php $this->endBlock(); ?>
   
    <?php }else{?>
        <?php $this->beginBlock('block1'); ?>
            <h1 class="title-inv"><?= Html::encode($this->title) ?></h1>
        <?php $this->endBlock(); ?>
   <?php }
} ?>
    <div class = "row jumbotronrec">
          <h4 class = "display-3 col-xs-2"> <font style = "vertical-align: inherit;"> <font style = "vertical-align: inherit;"> Filtrado por: </font> </font> </h4>         
            <div class="col-xs-10">
                <?php $session = Yii::$app->session; 

                if($session->has('sexo')){ ?>
                <div class="badge badge-success row spd">
                  <!-- <button type="button" class="close col-xs-4" data-dismiss="alert">&times;</button> -->
                  <span class="sp col-xs-8">Sexo: <?php echo ($session['sexo'])?"Hombre":"Mujer"; ?></span>
                </div>
                <?php }  ?>

                <?php if($session->has('edaddesde')){ ?>
                <div class="badge badge-success row spd">
                  <!-- <button type="button" class="close col-xs-4" data-dismiss="alert">&times;</button> -->
                  <span class="sp col-xs-8">Edad Desde: <?php echo $session['edaddesde']; ?> Hasta: <?php echo $session['edadhasta']; ?></span>
                </div>
                <?php }  ?>

                <?php if($session->has('imcdesde')){ ?>
                <div class="badge badge-success row spd">
                  <!-- <button type="button" class="close col-xs-4" data-dismiss="alert">&times;</button> -->
                  <span class="sp col-xs-8">IMC Desde: <?php echo $session['imcdesde']; ?> Hasta: <?php echo $session['imchasta']; ?></span>
                </div>
                <?php }  ?>

                <?php if($session->has('actividadfisica')){ ?>
                <div class="badge badge-success row spd">
                  <!-- <button type="button" class="close col-xs-4" data-dismiss="alert">&times;</button> -->
                  <span class="sp col-xs-8">Actividad fisica: <?php echo $session['actividadfisica']; ?></span>
                </div>
                <?php }  ?>

                <?php if($session->has('provincia')){ ?>
                <div class="badge badge-success row spd">
                  <!-- <button type="button" class="close col-xs-4" data-dismiss="alert">&times;</button> -->
                  <span class="sp col-xs-8">Provincia: <?php echo $session['provincia']->provincia; ?></span>
                </div>
                <?php }  ?>

                <?php if($session->has('ciudad')){ ?>
                <div class="badge badge-success row spd">
                  <!-- <button type="button" class="close col-xs-4" data-dismiss="alert">&times;</button> -->
                  <span class="sp col-xs-8">Departamento: <?php echo $session['ciudad']->departamenos; ?></span>
                </div>
                <?php }  ?>

                <?php if($session->has('barrio')){ ?>
                <div class="badge badge-success row spd">
                  <!-- <button type="button" class="close col-xs-4" data-dismiss="alert">&times;</button> -->
                  <span class="sp col-xs-8">Localidad: <?php echo $session['barrio']->localidad; ?></span>
                </div>
                <?php }  ?>                
                 <!--  <button type="button" class="col-xs-4" data-dismiss="alert">Borrar filtro</button> -->
                  
             
            </div>
             
    </div>
</div>

<div class="filtrodiv">
 <?= GridView::widget([
        'dataProvider' => $data,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nro',
            'sexo',
            'dias',
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
    ]); ?>
       
    </div>
    <div class="col-xs-12">
        <a href="<?php echo Url::base(); ?>/index.php?r=investigador/exportar"  class="btn btn-success export">Exportar Excel</a>
    </div>