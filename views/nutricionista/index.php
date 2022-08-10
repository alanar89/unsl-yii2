<?php

use yii\helpers\Html;
use yii\grid\GridView;
 use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NutricionistaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nutricionista';
 $this->params['breadcrumbs'][] = $this->title;
?>
<div class="nutricionista-index">

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $this->beginBlock('block1'); ?>
      <h2 class="title-inv col-xs-8 col-md-10"><?= Html::encode("Nutricionista ".Yii::$app->user->identity->nombre." ".Yii::$app->user->identity->apellido) ?></h2>
    <?php $this->endBlock(); ?>
  
    <p>
        <?=  
         Html::a('Alta Paciente', ['paciente/create'], ['class' => 'btn btn-success'])
        
         ?>
        <?=  
         Html::a('Ver datos', ['investigador/panel'], ['class' => 'btn btn-success float-right'])
        
         ?>
    <?php
        Modal::begin([
            'header'=>'<h3 align="center">Pacientes sin nutricionista<h3>',
              'size'=>'modal-lg',
           'toggleButton'=>['label'=>'Paciente Libre','class'=>'btn btn-primary'],
        ]);
        echo 

        GridView::widget([
         'dataProvider' => $libre,
       
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'dni',
            'usuarios.nombre' ,
            'usuarios.apellido', 
            'usuarios.email' ,
            'usuarios.telefono' ,
            'fechanac',
            'talla',
            'peso',
            ['class' => 'yii\grid\ActionColumn',
           'template'=>'{asignar}',
           'buttons'=>[
           'asignar'=>function($url,$model){
            return Html::a('<span class="glyphicon glyphicon-plus-sign"></span>',
                $url,
                ['title'=>'agregar a mis pacientes']);
           }
           
           ],
           'urlCreator'=>function($action,$model,$key,$index) {
            if ($action== 'asignar'){
            return Url::to(['nutricionista/asignar','id'=>$key]);}
           }
           ],
        
        
        ], 
    ]); 
        Modal::end();

      ?>
    </p>
    
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
       
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'dni',
            'usuarios.nombre' ,
            'usuarios.apellido', 
            'usuarios.email' ,
            'usuarios.telefono' ,
            'fechanac',
            'talla',
            'peso',

           ['class' => 'yii\grid\ActionColumn',
           'template'=>'{delete}',
           ],
        
        ],
    ]); ?>

</div>


