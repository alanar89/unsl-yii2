    <?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Paciente */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
?>
 <script> 


function mifunc() {
        var prov = $('#paciente-provincia').val();
       $.pjax.reload({container: '#some-id', url: '<?php  echo Yii::$app->request->baseUrl . '/index.php?r=paciente/llenar' ?>',data: { prov : prov }, method: 'POST'});
       
    }
function mifunc2() {
        var dept = $('#paciente-ciudad').val();
        var prov = $('#paciente-provincia').val();
       $.pjax.reload({container: '#some2-id', url: '<?php  echo Yii::$app->request->baseUrl . '/index.php?r=paciente/llenarl' ?>',data: { dept : dept ,prov : prov } ,method: 'POST'});
    }
</script>
<div class="paciente-form">

    <?php $form = ActiveForm::begin([
        "method" =>"post",
        "id" => "formulario",
        "enableAjaxValidation" => true,
        'options'=>['class' => 'reg-form','autocomplete' => 'off']
    ]); 
        ?>
    
    <h3>Datos Personales</h3>
    <div class=" col-xs-12">
        <hr class="mt-0">  
    </div>
    <div class="row col-xs-12">  
        <div class="form-group col-xs-12 col-md-6">
            <?= $form->field($model1, 'nombre', ['options'=>['class' => '']]) ?>
            <?= $form->field($model1, 'apellido',['options'=>['class' => '']]) ?>
            <?= $form->field($model1, 'email',['options'=>['class' => '']]) ?>
            <?= $form->field($model1, 'telefono',['options'=>['class' => '']]) ?>
        </div> 
        <div class="form-group col-xs-12 col-md-6">
            <?= $form->field($model1, 'pass',['options'=>['class' => '']])->passwordInput() ?>
            <?= $form->field($model1, 'dni',['options'=>['class' => '']])->textInput([
                                 'type' => 'number',]) ?>
          
            <?= $form->field($model, 'fechanac')->widget(\yii\jui\DatePicker::className(), [
            // si estás usando bootstrap, la siguiente linea asignará correctamente el estilo del campo de entrada
            'language' => 'es', 
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control',
                             ],
                              'clientOptions' => [ 
                             'changeMonth' => true, 
                             'changeYear' => true, 
                             'showButtonPanel' => true, 
                             'yearRange' => '1900:2020' 
                            ],
            
            // ... puedes configurar más propiedades del DatePicker aquí
            ]); ?>
        
             <?= $form->field($model, 'sexo',['options'=>['class' => '']])->radioList( $options = ["femenino","masculino"]) ?>
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
            <?= $form->field($model, 'domicilio',['options'=>['class' => '']]) ?>

            <?php if(!isset(Yii::$app->user->identity->dni)){ ?>

             <?=  $form->field($model, 'dninutricionista'
                )->dropdownList($nut,['prompt'=>'No tengo']);?>
             <?php } ?> 
        </div>
    </div>

    <h3>Datos Antropométricos</h3>
    
    <div class="row col-xs-12">    
        <div class="form-group col-xs-12 col-md-6">
            <hr class="mt-0">
            <?= $form->field($model, 'talla',['options'=>['class' => '']])->textInput()->hint('ingrese su altura') ?>
            <?= $form->field($model, 'peso',['options'=>['class' => '' ]])->textInput()->hint('Ej: 90.5 Kg') ?>

        </div>
    </div>
    <div class="row col-xs-12">
        <div class="form-group">
            <?= Html::submitButton('Registrarse', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
