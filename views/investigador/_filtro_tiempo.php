<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html; 
use yii\jui\DatePicker;?>
<script>

    function funcfech(){
        var fech = new Date($("#filtro-fecha").datepicker('getDate'));
        var fechd = $('#filtro-fechadesde');
        var fechh = $('#filtro-fechahasta');
        var error = $('#errorfech');
        var fecha_actual = new Date();
        fechd.val("");
        fechh.val("");
        var boton = $('#filt');

        if(fecha_actual > fech){
            error.text("");
            boton.removeAttr("disabled");
        }else{
                error.text("Seleccione una fecha anterior a la actual");
                boton.attr('disabled','disabled');
             }
    }

    function funcfech2(){
        var fech = $('#filtro-fecha');
        fech.val("");
        var fecha_actual = new Date();
        var error = $('#errorfecha');
        var boton = $('#filt');
        if($('#filtro-fechahasta').val()!="" && $('#filtro-fechadesde').val()!=""){
            
            var fechd = new Date($("#filtro-fechadesde").datepicker('getDate'));
            var fechh = new Date($('#filtro-fechahasta').datepicker('getDate'));
            if(fecha_actual > fechh){
                
                
                 if (fechd > fechh){
                    error.text("Seleccione un periodo valido");
                    boton.attr('disabled','disabled');
                 }else{
                    error.text("");
                    boton.removeAttr("disabled");
                 }
             }else{
                error.text("Seleccione un periodo anterior al actual");
                boton.attr('disabled','disabled');
             }
         }
    }
</script>

<div class="col-xs-12 row filtro-tiempo" id="filtrotiempo">      
  <div class="alert alert-dismissible alert-success row">
      <?php $form = ActiveForm::begin([
        "method" =>"post",
        // "id" => "formulario",
        "enableAjaxValidation" => true,
        'options'=>['autocomplete' => 'off']
    ]); ?>


      <div class="form-group col-xs-10 ">
        <label for="filtro-fecha">Seleccione el día:</label>
       <?php 
        echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'fecha',
            'language' => 'es',
            'options' => ['onchange' => 'funcfech();'],
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [ 
                             'changeMonth' => true, 
                             'changeYear' => true, 
                             'showButtonPanel' => true, 
                             'yearRange' => '1900:2020' 
                            ],
        ]); ?>
      </div>
      <div class="form-group field-usuarios-apellido required has-error">
            <div class="help-block" id="errorfech"></div>
        </div>
      <div class="form-group col-xs-10">
        <label >Seleccione un periodo de tiempo:</label>
    
        <label for="filtro-fechadesde">Desde:</label>
       <?php 

        echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'fechadesde',
            'language' => 'es',
            'options' => ['onchange' => 'funcfech2();'],
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [ 
                             'changeMonth' => true, 
                             'changeYear' => true, 
                             'showButtonPanel' => true, 
                             'yearRange' => '1900:2020' 
                            ],
        ]); ?>
        <label for="filtro-fechahasta">Hasta:</label>
        <?php 
        echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'fechahasta',
            'language' => 'es',
            'options' => ['onchange' => 'funcfech2();'],
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [ 
                             'changeMonth' => true, 
                             'changeYear' => true, 
                             'showButtonPanel' => true, 
                             'yearRange' => '1900:2020' 
                            ],
        ]); ?>
      </div>
        <div class="form-group field-usuarios-apellido required has-error">
            <div class="help-block" id="errorfecha"></div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Aplicar', ['class' => 'btn btn-success', 'id'=>'filt']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
      
</div>  


            
