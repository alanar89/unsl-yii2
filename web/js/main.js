function tiempofiltro (){
	var filtro =  $('#filtro');
	var btnfiltro = $('#btn-filtro');
	var filtrotiempo =  $('#filtrotiempo');
	var btnfiltrotiempo = $('#btn-filtrotiempo');
	
	if (btnfiltro.hasClass('esta')) {
		// filtro.css('width', '0');
		filtro.css('z-index','-10');
		filtro.css('visibility', 'hidden');
		// filtro.css('display', 'none');
		btnfiltro.attr('class','filtro btn btn-success');
	}
	
	if (btnfiltrotiempo.hasClass('esta')) {
		// filtro.css('width', '0');
		filtrotiempo.css('z-index','-10');
		filtrotiempo.css('visibility', 'hidden');
		filtro.css('display', 'none');
		btnfiltrotiempo.attr('class','filtro btn btn-info');
	}else{
		// filtro.css('display', 'block');
		// filtro.css('width', '100%');
		filtrotiempo.css('z-index','10');
		filtrotiempo.css('visibility', 'visible');
		filtro.css('display', 'block');
		btnfiltrotiempo.attr('class','filtro btn btn-info esta');
	}
}

function filtro(){
	var filtro =  $('#filtro');
	var btnfiltro = $('#btn-filtro');
	var filtrotiempo =  $('#filtrotiempo');
	var btnfiltrotiempo = $('#btn-filtrotiempo');
	
	if (btnfiltrotiempo.hasClass('esta')) {
		// filtro.css('width', '0');
		filtrotiempo.css('z-index','-10');
		filtrotiempo.css('visibility', 'hidden');
		btnfiltrotiempo.attr('class','filtro btn btn-info');
	}
	if (btnfiltro.hasClass('esta')) {
		// filtro.css('width', '0');
		filtro.css('z-index','-10');
		filtro.css('visibility', 'hidden');
		btnfiltro.attr('class','filtro btn btn-success');
	}else{
		filtro.css('display', 'block');
		// filtro.css('width', '100%');
		filtro.css('z-index','10');
		filtro.css('visibility', 'visible');
		btnfiltro.attr('class','filtro btn btn-success esta');
	}

}
function calcularAgua(comp){
				
				let id = comp.id;
				total=parseInt(document.getElementById('total').value);
				
				if (id==250) {
					total=(total+250);
					document.getElementById("total").value=total;

				}
				if (id==500) {
					total=(total+500);
					document.getElementById("total").value=total;

				}
				if (id==1000) {
					total=(total+1000);
					document.getElementById("total").value=total;
				}
				
				if(total>7000){
					total=7000;
					document.getElementById("total").value=total;
					document.getElementById("max").style.display="block";
				}else{document.getElementById("max").style.display="none";}
			}

function modif(){
		document.getElementById('ove').style.background='none';
	}

function habmod(act, url, actfisica=1){

	var mod =  $('#openModal');
	var btn = $('#btnmod');
	var cont = $('#contimg');
	if (mod.hasClass('des')) {
		mod.attr('class','');
		cont.attr('class', 'row act');
		btn.text('Guardar Actividad');
	}else {
		cont.attr('class', 'row act imgp');
		btn.text('Modificar Actividad');
		btn.removeAttr('onclick');
		btn.attr('onclick', 'habmod(0, "'+url+'", '+actfisica+');');
		mod.attr('class', 'des');

		$.ajax(
		{
		  url : url+'/index.php?r=paciente/acti',
		  type: "POST",
		  data : {act : act},
 		  dataType : 'json',
		   success : (function (data) {
		   	 alert(data.estado);
		   		if ( actfisica == 0) {
						location.reload();
					}
					
                  }),
		}).then(function(){
     
});
    
		
	}
	
	
}

function modact(act, url,actfisica=1){
	var btn = $('#btnmod');
	var act1 = $('#act1');
	var act11 = $('#act11');
	var act2 = $('#act2');
	var act21 = $('#act21');
	var act3 = $('#act3');
	var act31 = $('#act31');
	var act4 = $('#act4');
	var act41 = $('#act41');
	var act5 = $('#act5');
	var act51 = $('#act51');

	if(act == 1){
		
		act1.css('display', 'none');
		act1.attr('class','img-circle img-responsive');
		act11.attr('class','img-circle img-responsive col-md-8');
		act11.css('display','block');

		act21.css('display', 'none');
		act21.attr('class','img-circle img-responsive');
		act2.attr('class','img-circle img-responsive col-md-8');
		act2.css('display','block');

		act31.css('display', 'none');
		act31.attr('class','img-circle img-responsive');
		act3.attr('class','img-circle img-responsive col-md-8');
		act3.css('display','block');

		act51.css('display', 'none');
		act51.attr('class','img-circle img-responsive');
		act5.attr('class','img-circle img-responsive col-md-8');
		act5.css('display','block');

		act41.css('display', 'none');
		act41.attr('class','img-circle img-responsive');
		act4.attr('class','img-circle img-responsive col-md-8');
		act4.css('display','block');
		btn.removeAttr('onclick');
		btn.attr('onclick', 'habmod(1,"'+url+'",'+actfisica+');');
	} else if(act ==2){
		act2.css('display', 'none');
		act2.attr('class','img-circle img-responsive');
		act21.attr('class','img-circle img-responsive col-md-8');
		act21.css('display','block');

		act11.css('display', 'none');
		act11.attr('class','img-circle img-responsive');
		act1.attr('class','img-circle img-responsive col-md-8');
		act1.css('display','block');

		act31.css('display', 'none');
		act31.attr('class','img-circle img-responsive');
		act3.attr('class','img-circle img-responsive col-md-8');
		act3.css('display','block');

		act51.css('display', 'none');
		act51.attr('class','img-circle img-responsive');
		act5.attr('class','img-circle img-responsive col-md-8');
		act5.css('display','block');

		act41.css('display', 'none');
		act41.attr('class','img-circle img-responsive');
		act4.attr('class','img-circle img-responsive col-md-8');
		act4.css('display','block');
		btn.removeAttr('onclick');
		btn.attr('onclick', 'habmod(2,"'+url+'",'+actfisica+');');
	}else if(act ==3){
		act3.css('display', 'none');
		act3.attr('class','img-circle img-responsive');
		act31.attr('class','img-circle img-responsive col-md-8');
		act31.css('display','block');

		act11.css('display', 'none');
		act11.attr('class','img-circle img-responsive');
		act1.attr('class','img-circle img-responsive col-md-8');
		act1.css('display','block');

		act21.css('display', 'none');
		act21.attr('class','img-circle img-responsive');
		act2.attr('class','img-circle img-responsive col-md-8');
		act2.css('display','block');

		act51.css('display', 'none');
		act51.attr('class','img-circle img-responsive');
		act5.attr('class','img-circle img-responsive col-md-8');
		act5.css('display','block');

		act41.css('display', 'none');
		act41.attr('class','img-circle img-responsive');
		act4.attr('class','img-circle img-responsive col-md-8');
		act4.css('display','block');
		btn.removeAttr('onclick');
		btn.attr('onclick', 'habmod(3,"'+url+'",'+actfisica+');');
	}else if(act ==4){
		act4.css('display', 'none');
		act4.attr('class','img-circle img-responsive');
		act41.attr('class','img-circle img-responsive col-md-8');
		act41.css('display','block');

		act11.css('display', 'none');
		act11.attr('class','img-circle img-responsive');
		act1.attr('class','img-circle img-responsive col-md-8');
		act1.css('display','block');

		act21.css('display', 'none');
		act21.attr('class','img-circle img-responsive');
		act2.attr('class','img-circle img-responsive col-md-8');
		act2.css('display','block');

		act51.css('display', 'none');
		act51.attr('class','img-circle img-responsive');
		act5.attr('class','img-circle img-responsive col-md-8');
		act5.css('display','block');

		act31.css('display', 'none');
		act31.attr('class','img-circle img-responsive');
		act3.attr('class','img-circle img-responsive col-md-8');
		act3.css('display','block');
		btn.removeAttr('onclick');
		btn.attr('onclick', 'habmod(4,"'+url+'",'+actfisica+');');
	}else if(act ==5){
		act5.css('display', 'none');
		act5.attr('class','img-circle img-responsive');
		act51.attr('class','img-circle img-responsive col-md-8');
		act51.css('display','block');

		act11.css('display', 'none');
		act11.attr('class','img-circle img-responsive');
		act1.attr('class','img-circle img-responsive col-md-8');
		act1.css('display','block');

		act21.css('display', 'none');
		act21.attr('class','img-circle img-responsive');
		act2.attr('class','img-circle img-responsive col-md-8');
		act2.css('display','block');

		act31.css('display', 'none');
		act31.attr('class','img-circle img-responsive');
		act3.attr('class','img-circle img-responsive col-md-8');
		act3.css('display','block');
		btn.removeAttr('onclick');
		btn.attr('onclick', 'habmod(4,"'+url+'",'+actfisica+');');

		act41.css('display', 'none');
		act41.attr('class','img-circle img-responsive');
		act4.attr('class','img-circle img-responsive col-md-8');
		act4.css('display','block');
		btn.removeAttr('onclick');
		btn.attr('onclick', 'habmod(5,"'+url+'",'+actfisica+');');
	}

}

jQuery(function($) {
  
      // Example with grater loading time - loads longer
      $('.pie_progress1').asPieProgress({
        namespace: 'pie_progress',
        goal: 100,
        min: 0,
        max: 100,
        speed: 30,
        barcolor: '#006eff',
        easing: 'linear'
      });
      // Example with grater loading time - loads longer
      $('.pie_progress2').asPieProgress({
        namespace: 'pie_progress',
        goal: 100,
        min: 0,
        max: 100,
        speed: 30,
        barcolor: '#ff0000',
        easing: 'linear'
      });
      // Example with grater loading time - loads longer
      $('.pie_progress3').asPieProgress({
        namespace: 'pie_progress',
        goal: 100,
        min: 0,
        max: 100,
        speed: 30,
        barcolor: '#00ff65',
        easing: 'linear'
      });
    $('.pie_progress').asPieProgress('start');

   
    });

	function cambio(){
	
			document.getElementById("peso").style.display="block";
			document.getElementById("agua").style.display="none";
	}

	function cambio1(){
	
			document.getElementById("agua").style.display="block";
			document.getElementById("peso").style.display="none";
			
	}