<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Nutricionista */

$this->title ='Datos Personales';
$this->params['breadcrumbs'][] = ['label' => 'Investigador', 'url' => ['panel']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="Investigador-view">
<?php $this->beginBlock('block1'); ?>
        <div class="row">
          
             <h1 class="title-inv"><?= Html::encode($this->title) ?></h1>
        </div>
    <?php $this->endBlock(); ?>
   

   

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
             'usuarios.nombre' ,
            'usuarios.apellido', 
            'usuarios.email' ,
            'usuarios.telefono' ,
            'dni',
            'universidad',
            'facultad',
        ],
    ]) ?>
      <div class="row">

       <div class="col-md-4"> <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
          
            <button type="button" data-toggle="modal" data-target="#modal3" class="btn btn-primary">Cambiar contraseña</button></div>


       <div class="col-md-2 col-md-offset-6">
       <?= Html::a('Eliminar cuenta', ['delete', 'id' => $model->id], ['class' => 'btn btn-primary','onclick'=>"return confirm('estas seguro? se eliminaran todos sus datos')"]) ?></div>
     

      </div><br>

    <?php
        Modal::begin([
        'header'=>'<h4 align="center">Cambiar contraseña<h4>',
        'id'=>'modal3',
        'size'=>'modal-sm',
        ]);?>
        <div class="row">
       <form     method="post" id="formu" action ="index.php?r=investigador/pass">
       <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
        <div class="row col-lg-12">
            <div class="form-group col-lg-12 col-md-6">
            <div class="input-group">
             
             nueva contraseña
        <input type="password" class="form-control" id="pas" name="pas" aria-describedby="basic-addon1" required="">
        </div><br>
     <div class="input-group">
             
             repita contraseña
    <input type="password" class="form-control" id="pas1" name="pas1" aria-describedby="basic-addon1" required="">
   
    </div>
           <div  class="alert alert-danger" role="alert" id="error" style="display: none;">las contraseñas deben ser iguales</div>
           </div>
        <div class="row col-lg-12 col-xs-12">
        <div class="form-group col-lg-12  col-md-6">
           <input type="button" class="btn btn-success" value="Guardar" onclick="contra()">
           </form>
        </div>
        </div>
  
  </div>
    </div>
    <?php Modal::end();?>
</div>