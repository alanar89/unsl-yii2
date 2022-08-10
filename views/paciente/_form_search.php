<?php use yii\widgets\Pjax; ?>
<script>
	function buscar(){
		var alimento = $('#search-alimento').val();
       $.pjax.reload({container: '#lista', url: '<?php  echo Yii::$app->request->baseUrl . '/index.php?r=paciente/index' ?>',data: { alimento : alimento } ,method: 'POST'});
	}
	function addalimento(codigo, alimento,id){
		var coccion = $("input[name=tipo]").prop("checked",true);
		$.pjax.reload({container: '#lista', url: '<?php  echo Yii::$app->request->baseUrl . '/index.php?r=paciente/index' ?>',data: { al : alimento , codigo : codigo , idal : id, coccion : coccion.val()} ,method: 'POST'});
	}
	function racion (codigo, alimento, id){
		var gramos = $('#racion-alimento');
		var gramo = gramos.val();
		var valido = true;
		var calo = $('#caloria');
		var alertcalc = $('#calculo-alert');
		 coccion = $('input:radio[name=tipo]:checked');
		if (gramo == 0 || gramo==""){
			alertcalc.text('Ingrese una cantidad de gramos');
			valido=false;
			calo.text('0');
		}
		if (gramo < 0 ){
			alertcalc.text('Ingrese una cantidad de gramos que sea positiva');
			valido=false;
			calo.text('0');
		}
		if (valido) {
			$.pjax.reload({
				container: '#lista', 
				url: '<?php  echo
			Yii::$app->request->baseUrl . '/index.php?r=paciente/index'
			?>',
				data: { al : alimento , codigo : codigo , gramos : gramo, idal: id, coccion : coccion.val(),}
	                ,method: 'POST',}); 
		            
		}
	}
	
	function guardar(codigo , alimento , id, gram){
		
		var alertcalc = $('#calculo-alert');
		var grame  = $('#racion-alimento');
		var coccionalert = $('#coccion-alert');
		var coccion = $('input:radio[name=tipo]:checked');
		var valido = true;
		var calo = $('#caloria');
		if (grame.val()!= "") {
			racion (codigo, alimento, id);
		}
		var gramos = $('#caloria').text();
		if (grame.val() == 0 || grame.val()==""){
			alertcalc.text('Calcula la cantidad de gramos');
			valido=false;
			calo.text('0');
		}
		if (grame.val() < 0 ){
			alertcalc.text('Ingrese una cantidad de gramos que sea positiva');
			valido=false;
			calo.text('0');
		}
		if (valido) {
		setTimeout(function(){
		

		
			if (confirm("Desea añadir el alimento")) {
				$.pjax.reload({container: '#lista', url: '<?php  echo Yii::$app->request->baseUrl . '/index.php?r=paciente/index' ?>',data: { coccion : coccion.val() , gramos : grame.val(), idal : id} ,method: 'POST'});
				
				 window.location.reload(true);  
				
			}
		
	},4000);
	}
	}
	

</script>
<div class='row'> 
  <div class='col-lg-12'>
    <div class='input-group'>
      <input type='text' id="search-alimento" class='form-control' placeholder='Buscar alimento'>
      <span class='input-group-btn'>
        <button class='btn btn-primary' type='button' onclick="buscar();">Buscar</button>
      </span>
    </div>
  </div>
	
  <div class="col-xs-12 modalcon">
  	
  		<?php Pjax::begin(['id'=>'lista', 'timeout'=> false, 'enablePushState' => false, 'clientOptions' => ['method'=> 'POST']]); ?>
  			<ul class="busqueda">
		  		<li>
					<div class="alert alert-dismissible alert-info alimen">
					 	<span><strong>Realice una búsqueda</strong></span>
					</div>
		  		</li>
	  		</ul>			
  		<?php Pjax::end(); ?>
 		
  
  </div>
</div>