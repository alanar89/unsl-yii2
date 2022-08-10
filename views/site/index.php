<?php

use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

<script type="text/javascript">
    function calcular(){
        

        
       a= parseFloat(document.getElementById("altura").value)/100;
        p= parseFloat(document.getElementById("peso").value);
 pe=$('#peso');
 ae=$('#altura');
        boton=$('#buton');
        alert=$('#alertpeso');
        if(ae.val()!="" &&ae.val() < 250 && ae.val() > 40){
            document.getElementById("error2").style.display="none";
        }else{
              document.getElementById("error2").style.display="block";
        }
        if (pe.val() < 500 && pe.val() > 20 && pe.val()!="") {
            document.getElementById("error").style.display="none";
        }else{
              document.getElementById("error").style.display="block";
        }
        if (pe.val() < 500 && pe.val() > 20 && pe.val()!="" ) {
            if(ae.val()!="" &&ae.val() < 250 && ae.val() > 40){
        document.getElementById("error").style.display="none";
        r=p/(a*a);
        r=r.toFixed(2);
        
        if(r<18.5){
            document.getElementById("ua").style.background='#fcf8e3';
            document.getElementById("ub").style.background='#fcf8e3';
            }else{document.getElementById("ua").style.background='white';
            document.getElementById("ub").style.background='white';}
            
       if(r >= 18.5  && r <24.9 ){
            document.getElementById("da").style.background='#dff0d8';
            document.getElementById("db").style.background='#dff0d8';
            }else{document.getElementById("da").style.background='white';
            document.getElementById("db").style.background='white';}

            if(r>24.9 && r <=29.9){
            document.getElementById("ta").style.background='#fcf8e3';
            document.getElementById("tb").style.background='#fcf8e3';
            }else{document.getElementById("ta").style.background='white';
            document.getElementById("tb").style.background='white';}

        if(r>30){
            document.getElementById("ca").style.background='#f2dede';
            document.getElementById("cb").style.background='#f2dede';
            } else{document.getElementById("ca").style.background='white';
            document.getElementById("cb").style.background='white';} 

      document.getElementById("res").innerHTML = "Su imc es: "+r;
        document.getElementById("res").style.display="block"; 
        }else{
           
            
        }
        }else{
            
        }
    }
</script>
<?php $this->beginBlock('block1'); ?>
        <h1 class="title-inv">Nutrición</h1>
<?php $this->endBlock(); ?>
<?php $this->beginBlock('block2'); ?>
<div class="img-baner">
        <h2 class="text-center">Comenzá una vida sana</h2>
        <p class="text-center">Manten el control de los alimentos que consumes y adelgaza de forma saludable</p>
        <div class="buttons1"><a class="btn1 green" href="<?php echo Url::base(''); ?>/index.php?r=paciente%2Fcreate">Comenzá Ahora!!</a></div>
</div>
<?php $this->endBlock(); ?>
<div class="container">
    <div class="row calc">
  
             <div class="col-xs-12 col-sm-6 col-sm-push-6 calc-text">
        <h2>Calculadora del índice de masa corporal (IMC)</h2><br>    

         <p>El sobrepeso puede causar la elevación de la concentración de colesterol total y de la presión arterial, y aumentar el riesgo de sufrir la enfermedad arterial coronaria. La obesidad aumenta las probabilidades de que se presenten otros factores de riesgo cardiovascular, en especial, presión arterial alta, colesterol elevado y diabetes.</p>
        </div>
        <div class="col-xs-12 col-sm-6 col-sm-pull-6  jumbotron img-calculadora">
        <h4 class="title-inv"> Para calcular su índice de masa corporal, ingrese su estatura y peso.</h4><br>
        <form >
            <div class="form-group ">
                <label for="altura" class="title-inv">Altura</label>
                <input  class="form-control" type="number" min="50" max="260"  name="altura" id="altura" required>
                <span class="title-inv">ingrese su altura en centimetros</span>
                 <div  class="alert alert-danger" role="alert" id="error2" style="display: none;">La altura no puede ser superior a 250 e inferior a 40</div>
            </div>
            <div class="form-group ">
                <label for="peso" class="title-inv"> Peso </label>
                <input type="number" class="form-control"   min="20" name="peso" max="500"  id="peso" required>
                 <span class="title-inv">ingrese su peso en kg</span>
                 <div  class="alert alert-danger" role="alert" id="error" style="display: none;">El peso no puede ser superior a 500 e inferior a 20</div>
            </div>
            <div class="form-group">
                <input type="button" class="btn btn-primary  " onclick="calcular()" value="calcular">
            </div>
        </form> 
         <div class="alert alert-info" role="alert" id="res" style="display: none;"></div>
        </div>
     
    <div class="col-xs-12"> 

        <ul class="list-group">
         <li class="list-group-item col-lg-6 "> <h6>Composición corporal</h6></li>  
         <li class="list-group-item col-lg-6"><h6>  Índice de masa corporal (IMC)</h6></li>
         <li class="list-group-item col-lg-6 "  id='ua'>Peso inferior al normal</li>
         <li class="list-group-item col-lg-6 " id='ub'>Menos de 18.5</li>
         <li class="list-group-item col-lg-6 "  id='da'>Normal</li>
         <li class="list-group-item col-lg-6 "  id='db'>18.5 – 24.9</li>
         <li class="list-group-item col-lg-6 "  id='ta'>Peso superior al normal </li>
         <li class="list-group-item col-lg-6 "  id='tb'>25.0 – 29.9</li>
         <li class="list-group-item col-lg-6 " id='ca'>Obesidad</li>
         <li class="list-group-item col-lg-6 " id='cb'>Más de 30.0</li>
        </ul>

    </div>

 </div>   
   <div class="llamado">
      <h5 class="col-sm-6 text-llamado">Contacta con profesionales de la salud y Comienza una Vida Sana</h5>
      <div class="buttons1 buttons11 col-sm-6"><a class="btn1 green" href="<?php echo Url::base(''); ?>/index.php?r=paciente%2Fcreate">Comenzá Ahora!!</a></div>
   </div>

</div>



    
