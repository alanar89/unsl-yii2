<?php 
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Html; ?>
<script>
  function mifunc() {
        var prov = $('#filtro-provincia').val();
       $.pjax.reload({container: '#some-id', url: '<?php  echo Yii::$app->request->baseUrl . '/index.php?r=investigador/llenar' ?>',data: { prov : prov } ,method: 'POST'});
    }
function mifunc2() {
        var dept = $('#filtro-ciudad').val();
        var prov = $('#filtro-provincia').val();
       $.pjax.reload({container: '#some2-id', url: '<?php  echo Yii::$app->request->baseUrl . '/index.php?r=investigador/llenarl' ?>',data: { dept : dept ,prov : prov } ,method: 'POST'});
    }
function imc(){
  var imcdesde = $('#filtro-imcdesde');
  var imchasta = $('#filtro-imchasta');
  var error = $('#errorimc');
  var boton = $('#filt');
  if (imcdesde.val()!="" && imchasta.val()!="") {
    if (imchasta.val() < imcdesde.val()) {
      error.html("La imc inicial debe ser menor que la imc final");
      imcdesde.val("");
      imchasta.val("");
      imcdesde.focus();
    }else{
      error.html("");
       if (imchasta.val() < 0 || imcdesde.val()< 0) {
      error.html("El rango de IMC debe ser numeros positivos");
      imcdesde.val("");
      imchasta.val("");
      imcdesde.focus();
    }else{
      error.html("");
    }
    }
  }
}

function edad(){
  var edaddesde = $('#filtro-edaddesde');
  var edadhasta = $('#filtro-edadhasta');
  var error = $('#erroredad');
  var boton = $('#filt');
  if (edaddesde.val()!="" && edadhasta.val()!="") {
    if (edadhasta.val() < edaddesde.val()) {
      error.html("La edad inicial debe ser menor que la edad final");
      edaddesde.val("");
      edadhasta.val("");
      edaddesde.focus();
    }else{
      error.html("");
      if (edadhasta.val() < 0 || edaddesde.val()< 0) {
      error.html("El rango de edades debe ser números positivos");
      edaddesde.val("");
      edadhasta.val("");
      edaddesde.focus();
    }else{
      error.html("");
      if (edadhasta.val() > 150 || edaddesde.val() > 150) {
      error.html("La edad debe ser menor a 150");
      edaddesde.val("");
      edadhasta.val("");
      edaddesde.focus();
    }else{
      error.html("");
    }
    }


    }


  }
}
</script>

<div class="row cont-filt">
        <div class="col-xs-8 col-md-4">
            <button type="button" class="filtro btn btn-success" id="btn-filtro" onclick="filtro();"><span class=" fas fa-filter"> Filtrar </span><span class="fas fa-caret-down"></span></button>
            <?php $session = Yii::$app->session;
            if($session->has('fecha')){
              $fecha=$session['fecha'];
              $fechaini = "";
              $fechafin = ""; 
            }else if ($session->has('fechaper')){
              $fechaper=$session['fechaper'];
              $fechaini = $fechaper['0'];
              $fechafin = end($fechaper);
              $fecha="Desde: " . $fechaini . " Hasta: " . $fechafin;
            }else{
              $fechaini = "";
              $fechafin = "";
              $fecha="";
            }?>
            <button type="button" class="filtro btn btn-info" onclick="tiempofiltro();" id="btn-filtrotiempo" ><span class=" far fa-calendar-alt"> Periodo de tiempo </span><span class="fas fa-caret-down"></span></button><span class="badge badge-pill badge-info"><?php echo $fecha; ?></span>

            
        </div>
        <?php $form = ActiveForm::begin([
            // "method" =>"post",
            // "id" => "formulario",
            // "enableAjaxValidation" => true,
            'options'=>['autocomplete' => 'off', 'class'=>'col-xs-2 float-rigth']
            ]); ?>
             <?= Html::submitButton('Borrar Filtro', ['class' => 'btn btn-warning badge badge-warning  redb', 'value'=>'1']) ?>
             <?php ActiveForm::end(); ?>
        <div class="col-xs-12 row filtro-div" id="filtro">      
            <div class="alert alert-dismissible alert-success row">
                <?php $form = ActiveForm::begin([
                  // "method" =>"post",
                  // "id" => "formulario",
                  // "enableAjaxValidation" => true,
                  'options'=>['class' => 'reg-form']
              ]); ?>
                <fieldset class="form-group col-xs-12 col-sm-4">
                  <legend>Sexo</legend>
                  <div class="form-check">
                    <?= $form->field($model, 'sexo')->radio(['label' => 'Hombre', 'value' => '1', 'uncheck' => null]) ?>
                  </div>
                  <div class="form-check">
                  <?= $form->field($model, 'sexo')->radio(['label' => 'Mujer', 'value' => '0', 'uncheck' => null]) ?>
                  </div>
                </fieldset>    
            
                <div class="form-group col-xs-12 col-sm-4">
                  <legend>Edad</legend>
                    <div class="form-check">
                      <?= $form->field($model, 'edaddesde',['options'=>['class' => 'col-xs-7']])->textInput([
                                 'type' => 'number',
                                 'OnBlur'=>'edad();',
                            ]) ?>
                    </div>
                    <div class="form-check">
                     <?= $form->field($model, 'edadhasta',['options'=>['class' => 'col-xs-7']])->textInput([
                                 'type' => 'number',
                                 'OnBlur'=>'edad();',   
                            ]) ?>
                    </div>
                    <div class="form-group field-usuarios-apellido required has-error col-xs-12
                    ">
                      <div class="help-block" id="erroredad"></div>
                  </div>
                </div>

                <div class="form-group col-xs-12 col-sm-4">
                  <legend>IMC</legend>
                    <div class="form-check">
                      <?= $form->field($model, 'imcdesde',['options'=>['class' => 'col-xs-7']])->textInput([
                                 'type' => 'number',
                                 'OnBlur'=>'imc();', 
                            ]) ?>
                    </div>
                    <div class="form-check">
                       <?= $form->field($model, 'imchasta',['options'=>['class' => 'col-xs-7']])->textInput([
                                 'type' => 'number',
                                 'OnBlur'=>'imc();', 
                            ]) ?>
                    </div>
                    <div class="form-group field-usuarios-apellido required has-error col-xs-12
                    ">
                      <div class="help-block" id="errorimc"></div>
                  </div>
                </div>
                <hr class="mt-0 col-xs-12"> 
               <fieldset class="form-group col-xs-12 row">
                  <legend>Actividad</legend>
                  
                  <div class="form-check col-xs-12 col-sm-4 actf">
                    <?= $form->field($model, 'actividadfisica')->radio(['label' => 'Poco ejercicio', 'value' => '1', 'uncheck' => null]) ?>
                  </div>
                  <div class="form-check col-xs-12 col-sm-4 actf">
                  <?= $form->field($model, 'actividadfisica')->radio(['label' => 'Ejercicio ligero', 'value' => '2', 'uncheck' => null]) ?>
                  </div>
                    <div class="form-check col-xs-12 col-sm-4 actf">
                     <?= $form->field($model, 'actividadfisica')->radio(['label' => 'Ejercicio moderado', 'value' => '3', 'uncheck' => null]) ?>
                    </div>
                    <div class="form-check col-xs-12 col-sm-4 actf">
                      <?= $form->field($model, 'actividadfisica')->radio(['label' => 'Ejercicio fuerte', 'value' => '4', 'uncheck' => null]) ?>
                    </div>
                    <div class="form-check col-xs-12 col-sm-4 actf">
                      <?= $form->field($model, 'actividadfisica')->radio(['label' => 'Ejercicio extremo', 'value' => '5', 'uncheck' => null]) ?>
                    </div>
                </fieldset>   
                    <hr class="mt-0 col-xs-12"> 
                <fieldset class="form-group col-xs-12 row">
                  <legend>Región</legend>
                  
                  <div class="form-check col-xs-12 col-sm-4">
                    <?=  $form->field($model, 'provincia'
                      )->dropdownList($prov,
                      ['prompt'=>'Seleccione Cargo', 'onchange'=>'mifunc();', ['name'=> 'prov']]
                  );?>
                  </div>
                  <div class="form-check col-xs-12 col-sm-4">
                  <?php Pjax::begin(['id'=>'some-id', 'timeout'=> false, 'enablePushState' => false, 'clientOptions' => ['method'=> 'POST']]); ?>
                    <?=  $form->field($model, 'ciudad'
                        )->dropdownList($dept,
                        ['prompt'=>'Seleccione Cargo', 'onchange'=>'mifunc2();', ['name'=> 'dept']]
                    );?>
                    <?php Pjax::end(); ?>
                  </div>
                    <div class="form-check col-xs-12 col-sm-4">
                        <?php Pjax::begin(['id'=>'some2-id', 'timeout'=> false, 'enablePushState' => false, 'clientOptions' => ['method'=> 'POST']]); ?>
                          <?=  $form->field($model, 'barrio'
                              )->dropdownList($loc,
                              ['prompt'=>'Seleccione Cargo']
                          );?>
                          <?php Pjax::end(); ?>
                    </div>
                    
                </fieldset>   
                <div class="row col-xs-12">
                  <div class="form-group">
                      <?= Html::submitButton('Aplicar', ['class' => 'btn btn-success']) ?>
                  </div>
              </div>
                <?php ActiveForm::end(); ?>
            </div>  
            
        </div>
    </div>