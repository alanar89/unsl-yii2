<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Nutricionista */
/* @var $form yii\widgets\ActiveForm */
?>
 <script> 


function mifunc() {
        var prov = $('#nutricionista-provincia').val();
       $.pjax.reload({container: '#some-id', url: '<?php  echo Yii::$app->request->baseUrl . '/index.php?r=nutricionista/llenar'; echo isset($update)? '&1' : ''; ?>',data: { prov : prov } ,method: 'POST'});
    }
function mifunc2() {
        var dept = $('#nutricionista-ciudad').val();
        var prov = $('#nutricionista-provincia').val();
       $.pjax.reload({container: '#some2-id', url: '<?php  echo Yii::$app->request->baseUrl . '/index.php?r=nutricionista/llenarl'; echo isset($update)? '&1' : ''; ?>',data: { dept : dept ,prov : prov } ,method: 'POST'});
    }
</script>
<div class="nutricionista-form">

    <?php $form = ActiveForm::begin([
        "method" =>"post",
        "id" => "formulario",
        "enableAjaxValidation" => true,
        'options'=>['class' => 'reg-form']
    ]); ?>
      <h3>Datos Personales</h3>
    <div class=" col-xs-12">
        <hr class="mt-0">  
    </div>
    <div class="row col-xs-12">  
        <div class="form-group col-xs-12 col-md-6">

   <?= $form->field($model1, 'nombre') ?>
    <?= $form->field($model1, 'apellido') ?>
    <?= $form->field($model1, 'email') ?>
    <?= $form->field($model1, 'telefono') ?>
    
 </div>
  <div class="form-group col-xs-12 col-md-6">
  <?= $form->field($model1, 'pass')->passwordInput() ?>
     <?= $form->field($model1, 'dni',['options'=>['class' => '']])->textInput([
                                 'type' => 'number',])?>
    <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'centrodetrabajo')->textInput(['maxlength' => true]) ?>
 </div>
</div>
 <h3>Localidad</h3>
    
    <div class="row col-xs-12">    
        <div class="form-group col-xs-12 col-md-6">
            <hr class="mt-0">
            <?=  $form->field($model, 'provincia'
                )->dropdownList($prov,
                ['prompt'=>'Seleccione Cargo', 'onchange'=>'mifunc();', ['name'=> 'prov']]
            );?>
            <?php Pjax::begin(['id'=>'some-id', 'timeout'=> false, 'enablePushState' => false, 'clientOptions' => ['method'=> 'POST']]); ?>
            <?=  $form->field($model, 'ciudad'
                )->dropdownList($dept,
                ['prompt'=>'Seleccione Cargo', 'onchange'=>'mifunc2();', ['name'=> 'dept']]
            );?>
            <?php Pjax::end(); ?>

            <?php Pjax::begin(['id'=>'some2-id', 'timeout'=> false, 'enablePushState' => false, 'clientOptions' => ['method'=> 'POST']]); ?>
            <?=  $form->field($model, 'barrio'
                )->dropdownList($loc,
                ['prompt'=>'Seleccione Cargo']
            );?>
            <?php Pjax::end(); ?>
        </div>
    </div>
    <div class="row col-xs-12">
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
</div>