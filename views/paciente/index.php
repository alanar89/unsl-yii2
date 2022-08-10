<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use dosamigos\chartjs\ChartJs;
use app\widgets\Alert;
use yii\data\ArrayDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PacienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Panel';

$this->params['breadcrumbs'][] = $this->title;

?>

<?php if ($paciente->actividadfisica) {
	
?>
				
<div class="paciente-index">

    <?php $this->beginBlock('block1'); ?>
    	<div class="row">
		    <h1 class="title-inv col-xs-8 col-md-10"> <?= Html::encode($user->nombre) ?></h1>
		    
        </div>
    <?php $this->endBlock(); ?>
    <div class="row">
     <?= Alert::widget() ?>
	    <div class="cont col-xs-1">
			<div class="wrapper">
			  <input id="customBox" class="customBox" type="checkbox" />
			  <label for="customBox"></label>
			  <span class="anadir">Añadir alimentos</span>
			  <div data-toggle="modal" data-target="#modal1" class="two  fas fa-utensils fa-lg"></div>



<?php
		Modal::begin([
		'header'=>'<h4 align="center">Actualizar peso<h4>',
		'id'=>'modal3',
		'size'=>'modal-sm',
        ]);?>
		<div class="row">
		<?php $form = ActiveForm::begin([
			"method" =>"post",
        "id" => "formulario",
        "enableAjaxValidation" => true,
			'action' => 'index.php?r=paciente/peso']); ?>
		<div class="row col-lg-12">
        	<div class="form-group col-lg-12 col-md-6">
            <?= $form->field($paciente, 'peso')->hint('Ej: 90.5 Kg')  ?>
           </div>
           </div>
        <div class="row col-lg-12 col-xs-12">
        <div class="form-group col-lg-12  col-md-6">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>
		</div>
    <?php ActiveForm::end();?>
  
	</div>
    <?php Modal::end();?>

		 <?php Modal::begin([
		'header'=>'<h4 align="center">Comidas<h4>',
		'id'=>'modal1',
		'size'=>'modal-lg',
        ]);?>
	
	     <?= $this->render('_form_search'); ?>
<?php 

	if (isset ($libre)) {print_r($libre);	
		GridView::widget([
         'dataProvider' => $libre,
       
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'Alimento',
            ['class' => 'yii\grid\ActionColumn',
           'template'=>'{asignar}',],
          
           ],
       	 
    ]); 
	}
	?>
     <?php   Modal::end();?>
			<div data-toggle="modal" data-target="#modal2" class="three fas fa-tint fa-lg"></div>
			</div>
			<?php
			  Modal::begin([
            'header'=>'<h4 class="col-lg-9 text-center"> Agua<h4>',
              'id'=>'modal2',
              'size'=>'modal-sm',
           
        ]);?>
        		
    		<?php $form = ActiveForm::begin(['action' => 'index.php?r=paciente/agua']); ?>
    		
			  	<div class=' col-md-9 col-sm-8 col-xs-8'>
					<?=Html::input('number','total','0', ['class'=>'form-control ','id' => 'total','min' => '0','max' => '10000'])?>
				</div>
				<div class=' col-md-3 col-sm-4 col-xs-4'>
	    		 	<?= Html::submitButton('', ['class' => 'btn btn-success  btn-sm glyphicon glyphicon-ok col-md-12  col-sm-12 col-xs-12']) ?>
	    	  		</div>
	    	  	
		  
		  <?php ActiveForm::end();?>
	<div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 10px;">	  
    <button  class=' btn btn-primary  col-xs-12 col-sm-12 col-md-12' value='250' id='250'  onclick='calcularAgua(this)'>+250 ml </button><button class=' btn btn-primary col-xs-12 col-sm-12 col-md-12' style="margin-bottom: 5px;margin-top: 5px;" value='500' id='500'  onclick='calcularAgua(this)'>+500 ml </button><button class=' btn btn-primary col-xs-12 col-sm-12 col-md-12' value='1000' id='1000' onclick='calcularAgua(this)'>+1000 ml</button>
<div class="alert alert-danger col-xs-12 col-sm-12 col-md-12" id="max" style="display: none;">Consumo diario recomendado: 2000 ml</div>
    </div>
     <?php Modal::end();?>
		</div>
	    <div class="row banner-content col-md-6 justify-content-center alert alert-dismissible alert-info">
			<h4 class="col-xs-12 pb-4 details text-left">Consumo diario:</h4>
			<div class=" col-xs-3 text-center">
				<h4><?php echo $objetivo; ?></h4>
				<p>Objetivo</p>
			</div>
			<span class="col-xs-1">-</span>
			<div class=" col-xs-3 text-center">
				<h4><?php
				$calorias=0;
				$carbohidratos =0;
				$grasas = 0;
				$proteinas = 0;
				foreach ($regdiario as $key => $value) {
				 $val = str_replace(',', '.', $value['calorias']);
				 $valh = str_replace(',', '.', $value['HidratosdeCarbono']);
				 $valg = str_replace(',', '.', $value['grasas']);
				 $valp = str_replace(',', '.', $value['proteinas']);
				  $gramos = str_replace(',', '.', $value['Gramos']);
				  	$cal= $val * $gramos / 100;
				 	$calorias = $calorias + $cal;
				 	$car= $valh * $gramos / 100;
				 	$carbohidratos = $carbohidratos + $car;
				 	$gras= $valg * $gramos / 100;
				 	$grasas  = $grasas  + $gras;
				 	$pro= $valp * $gramos / 100;
				 	$proteinas = $proteinas + $pro;
				 } 
				 echo $calorias;
				 ?></h4>
				<p>Calorías</p>
			</div>
			<span class="col-xs-1">=</span>
			<div class=" col-xs-3 text-center">
				<h4 class=" <?php echo ($objetivo - $calorias > 0)?'text-success':'text-success red'; ?>">
				<?php echo $objetivo - $calorias; ?>
				</h4>
				<p>Restante</p>
			</div>
		</div>
		<div class="col-md-2 float-right" >
			<button type="button col-xs-4 col-md-2 float-right" class="badge badge-success " data-toggle="modal" data-target="#modal5">Estadísticas</button>
		</div>
	</div>
	<?php $dataprovider = new ArrayDataProvider([
        'allModels' => $regdiario,
        ]); ?>
        <h2>Alimento consumidos Hoy</h2>
	<?= GridView::widget([
        'dataProvider' => $dataprovider,
        'columns' => [
            'Alimento',
            'Gramos',
            'fecha',
        ],
    ]);
     ?>
<?php 
} ?>
	<!-- Modificacion de actividad fisica
	======================================================= -->
	<div class="alert alert-dismissible alert-success row">
		<?php if ($paciente->actividadfisica) {?>
	  <button type="button" data-toggle="modal" data-target="#modal3" class="badge badge-success float-right boton-actualizar">Actualizar Peso</button>
	  <strong class="col-xs-12 col-md-5">Índice de Masa Corporal actual:  <?php echo $imc; ?> </strong>
	  <strong class="col-xs-12 col-md-5 text-md-right">Clasificación: <?php echo $clasificacion; ?> </strong>
	  <strong class="col-xs-12 col-md-5">Peso Ideal: <?php echo $pesoObjetivo; ?> Kg.</strong>
	<?php }else{ ?>
		<h2>Ingrese la actividad fisica que realiza para acceder al registro completo</h2>
		<?php } ?>
		<div class="col-md-12">
			<!-- FALTA pasar url por parametros en la funcion habmod(0, urlbase) y en el main -->
			<button type="button" onclick="habmod(0 , '<?php echo Url::base(''); ?>', <?php echo $paciente->actividadfisica; ?>);" class="badge badge-success actividad" id="btnmod">Modificar actividad</button>
			
			    <div class='row act imgp' id="contimg">
			    	<div class="des" id="openModal"></div>
			    <div>
				<h3 class="text-center">¿Cómo de activo eres a diario?</h3>
					<div class="contact">
				    	<div class='col-md-2 '>
					      	<img class='img-circle img-responsive imgcen' id="act11"  src=<?php  echo Yii::$app->request->baseUrl . '/img/check.png'; ?>>
					        <img class='img-circle img-responsive imgcen col-md-8' id="act1" onclick='modact(1, "<?php echo Url::base(''); ?>", <?php echo $paciente->actividadfisica; ?>);' src=<?php  echo Yii::$app->request->baseUrl . '/img/af1.png'; ?>>
					        <div class="col-md-12 text">
						        <P class="text-center"><strong>Poco o ningún ejercicio</strong></P>
						        
					        </div>
				    	</div>
						
					<div class='col-md-2'>
						<img class='img-circle' id="act21" src=<?php  echo Yii::$app->request->baseUrl . '/img/check.png'; ?>>
				        <img class='img-circle col-md-8' id="act2" onclick='modact(2, "<?php echo Url::base(''); ?>", <?php echo $paciente->actividadfisica; ?>);' src=<?php  echo Yii::$app->request->baseUrl . '/img/af2.png'; ?>>
				        <div class="col-md-12">
					        <P class="text-center"> <strong>Ejercicio ligero (1-3 días por semana)</strong></P>
					       
				        </div>
				      </div>

				    <div class='col-md-2'>
				    	<img class='img-circle' id="act31" src=<?php  echo Yii::$app->request->baseUrl . '/img/check.png'; ?>>
				        <img class='img-circle col-md-8' id='act3' onclick='modact(3,"<?php echo Url::base(''); ?>", <?php echo $paciente->actividadfisica; ?> );' src=<?php  echo Yii::$app->request->baseUrl . '/img/af3.png'; ?>>
				        <div class="col-md-12">
					        <P class="text-center"><strong>Ejercicio Moderado  (3-5 días por semana)</strong></P>
					        
				        </div>
				      </div>

				    <div class='col-md-2'>
				    	<img class='img-circle' id="act41" src=<?php  echo Yii::$app->request->baseUrl . '/img/check.png'; ?>>
				        <img class='img-circle col-md-8' id="act4"  onclick='modact(4, "<?php echo Url::base(''); ?>", <?php echo $paciente->actividadfisica; ?>);' src=<?php  echo Yii::$app->request->baseUrl . '/img/af4.png'; ?>>
				        <div class="col-md-12">
					        <P class="text-center"><strong>Ejercicio Fuerte (6 días por semana)</strong></P>
				        </div>
				      </div>

				      <div class='col-md-2'>
				    	<img class='img-circle' id="act51" src=<?php  echo Yii::$app->request->baseUrl . '/img/check.png'; ?>>
				        <img class='img-circle col-md-8' id="act5"  onclick='modact(5, "<?php echo Url::base(''); ?>", <?php echo $paciente->actividadfisica; ?>);' src=<?php  echo Yii::$app->request->baseUrl . '/img/af5.png'; ?>>
				        <div class="col-md-12">
					        <P class="text-center"><strong>Ejercicio profesional o extremo</strong></P>
				        </div>
				      </div>
			      </div>
				</div>		
			    </div>
				
	    </div>

	</div>
	<!-- fin Modificacion actividad fisica
	===================================================================== -->
	
<?php if ($paciente->actividadfisica) {
	
?>
<script type="text/javascript"> 
		modact(<?php echo $paciente->actividadfisica ?>, "<?php echo Url::base(''); ?>", <?php echo $paciente->actividadfisica; ?>);
	</script>
	

	<script>
		function miFuncion() {
			alert('OK');
		}
		
		</script>
	 <script src="js/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="js/jquery-asPieProgress.js"></script>

<script type="text/javascript" src="js/main.js">
	
</script>
<script>
	
	$(document).ready(function() {
		modact(<?php echo $paciente->actividadfisica ?>, "<?php echo Url::base('');  ?>");
	});
</script>
	<?php 
	if ($calorias != 0) {
	$porcentajeh = $carbohidratos *100 /$calorias;
	$porcentajeg=$grasas * 100 /$calorias;
	$porcentajep = $proteinas * 100 /$calorias;
	}else{
$porcentajeh = 0;
	$porcentajeg=0;
	$porcentajep =0;
	 
	}?>
	<div class="banner-content col-lg-12 col-md-12 ">
							
	<div class="row col-lg-12 col-md-12 ">
		<h4 class="float-left col-lg-12 pt-4 pl-4">Consumo diario</h4>
		<div class="pie_progress1 col-sm-6 col-md-3 col-lg-3 " role="progressbar" data-goal="<?php echo $porcentajeh ?>">
		  <div class="pie_progress__number"> <?php echo $porcentajeh ?> </div>
		  <div class="pie_progress__label">Carbohidratos</div>
		</div>
		<div class="pie_progress2 col-sm-6 col-md-3 col-lg-3 " role="progressbar" data-goal="<?php echo $porcentajeg ?>">
		  <div class="pie_progress__number"><?php echo $porcentajeg ?> </div>
		  <div class="pie_progress__label">Grasas</div>
		</div>
		<div class="pie_progress3 col-sm-6 col-md-3 col-lg-3 " role="progressbar" data-goal="<?php echo $porcentajep ?> ">
		  <div class="pie_progress__number"><?php echo $porcentajep ?> </div>
		  <div class="pie_progress__label">Proteínas</div>
		</div>

	</div>	
	<span class="col-xs-12 text-center">Debes consumir un 50% de Carbohidratos, 20% Proteínas, 30% Grasas del total de calorías para mantener una alimentación adecuada. </span>
</div>
		<?php
             Modal::begin([
            'header'=>'<h4 class="col-lg-12 text-center"> Estadísticas<h4>',
              'id'=>'modal5',
              'size'=>'modal-lg',
           
        ]);?>
    <div>
		
  
   <button class="btn btn-success btn-sm"  onclick="cambio()" id="ap">Peso</button>
  <button class="btn btn-primary btn-sm"  onclick="cambio1()"   id="aa">Agua</button>

		<?php 

		foreach ($peso as $v) {
           
			$p[]= $v->peso;
			$f[]= $v->fecha=date("d/m/y", strtotime($v->fecha));
        } 
        if(!empty($agua)){
        foreach ($agua as $v) {
           
			$a[]= $v->cantidad;
			$fa[]= $v->fecha=date("d/m/y", strtotime($v->fecha));
        } }else{$a=null;$fa=null;}
        ?>
<div id='peso'>
		<?= ChartJs::widget([
    'type' => 'line',
    'options' => [
        'height' => 100,
        'width' => 300
    ],
    'data' => [
        'labels' =>$f ,
        'datasets' => [
            [
                'label' => "Peso",
                //'fill'=>'false',
                'backgroundColor' => "transparent",
                'borderColor' => "green",
                'borderWidth' => "",
                'pointBackgroundColor' => "blue",
                'pointBorderColor' => "blue",
                'pointHoverBackgroundColor' => "blue",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data'=>$p,
            ],            
        ]
    ],

   
]);
?>
</div>	

	<div  id='agua' style="display: none;">
		<?= ChartJs::widget([
    'type' => 'line',
    'options' => [
        'height' => 100,
        'width' => 300
    ],
    'data' => [
        'labels' =>$fa,
        'datasets' => [
            [
                'label' => "Agua",
                //'fill'=>'false',
                'backgroundColor' => "transparent",
                'borderColor' => "red",
                'borderWidth' => "",
                'pointBackgroundColor' => "blue",
                'pointBorderColor' => "blue",
                'pointHoverBackgroundColor' => "blue",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data'=>$a,
            ],            
        ]
    ],

   
]);
?>
</div>
		</div>
     <?php Modal::end();?>

</div>


<?php } ?>