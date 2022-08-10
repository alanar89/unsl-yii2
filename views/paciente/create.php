<?php

use yii\helpers\Html;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */


if (isset(Yii::$app->user->identity->dni)){

if(User::isUserInvestigador(Yii::$app->user->identity->dni)){
$this->title = 'Alta Paciente';
$this->params['breadcrumbs'][] = ['label' => 'Investigador', 'url' => ['investigador/panel']];
$this->params['breadcrumbs'][] = $this->title; ?>

	<div class="paciente-create">
	<?php $this->beginBlock('block1'); ?>
    	<h1 class="title-inv"> <?= Html::encode($this->title) ?></h1>
	<?php $this->endBlock(); ?>
    <?= $this->render('_form', [
        'model' => $model,'model1'=>$model1, 'prov'=>$prov, 'dept' => $dept, 'loc' => $loc,'nut'=>$nut
    ]) ?>
    
</div>
<?php  }
if(User::isUserNutricionista(Yii::$app->user->identity->dni)){
$this->title = 'Alta Paciente';
$this->params['breadcrumbs'][] = ['label' => 'Pacientes', 'url' => ['nutricionista/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
	<div class="paciente-create">
	<?php $this->beginBlock('block1'); ?>
    	<h1 class="title-inv"> <?= Html::encode($this->title) ?></h1>
	<?php $this->endBlock(); ?>
    <?= $this->render('_form', [
        'model' => $model,'model1'=>$model1, 'prov'=>$prov, 'dept' => $dept, 'loc' => $loc,'nut'=>$nut
    ]) ?>
    
</div>
<?php 
}
}else{

$this->title = 'Crear cuenta';
$this->params['breadcrumbs'][] = $this->title;
}?>
<?php if (isset(Yii::$app->user->identity->dni)){
if (!(User::isUserNutricionista(Yii::$app->user->identity->dni)) && !(User::isUserInvestigador(Yii::$app->user->identity->dni))) { ?>
	<?php $this->beginBlock('block1'); ?>
    	<h1 class="title-inv"> Registrarse</h1>
	<?php $this->endBlock(); ?>
		<h2>Ya estas registrado</h2>
        <?php }  else{ ?> 
           
<?php } ?>
<?php } else{ ?>
		<div class="paciente-create">
	<?php $this->beginBlock('block1'); ?>
    	<h1 class="title-inv"> <?= Html::encode($this->title) ?></h1>
	<?php $this->endBlock(); ?>
    <?= $this->render('_form', [
        'model' => $model,'model1'=>$model1, 'prov'=>$prov, 'dept' => $dept, 'loc' => $loc,'nut'=>$nut
    ]) ?>
    
</div>

 <?php  }  ?>
