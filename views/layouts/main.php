<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
use app\models\User;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <?= Html::csrfMetaTags() ?>
     
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="header-top">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-sm-6 col-4 header-top-left no-padding">
                                <a href="index.php"><img src="<?php echo  Url::base(); ?>/img/logo.png" alt="" title="" /></a>         
                            </div>
                            
                        </div>                              
                    </div>
                </div>
                <div class="container main-menu">
                    <div class="row col-lg-12">
                      <nav class="nav menu col-lg-12">
                         <?php 
                         if (isset(Yii::$app->user->identity->dni)) {
                           if (User::isUserNutricionista(Yii::$app->user->identity->dni)){
                           echo Nav::widget([
                          'options' => ['class' => 'nav-menu active'],
                          'items' => [
                              
                            ['label' => 'Pacientes', 'url' => ['/nutricionista']],
                            ['label' => 'Perfil', 'url' => ['/nutricionista/perfil']],
                             ['label' => 'Salir '.Yii::$app->user->identity->username,
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                             
                          ],
                      ]);}elseif (User::isUserInvestigador(Yii::$app->user->identity->dni)){
                                  echo Nav::widget([
                          'options' => ['class' => 'nav-menu active'],
                          'items' => [
                             
                               
                                
                                ['label' => 'Panel', 'url' => ['investigador/panel']],
                               ['label' => 'Perfil', 'url' => ['/investigador/perfil']],
                             ['label' => 'Salir '.Yii::$app->user->identity->username,
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                             
                          ],
                      ]);  
                      }elseif (User::isUserSimple(Yii::$app->user->identity->dni)){
                                  echo Nav::widget([
                          'options' => ['class' => 'nav-menu active'],
                          'items' => [
                            ['label' => 'Panel', 'url' => ['/paciente']],
                               ['label' => 'Perfil', 'url' => ['/paciente/perfil']],
                             ['label' => 'Salir '.Yii::$app->user->identity->username,
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                             
                          ],
                      ]);  
                      }
                        }else{
                        echo Nav::widget([
                          'options' => ['class' => 'nav-menu active'],
                          'items' => [
                              
                              
                               ['label' => 'Registrarse', 'url' => ['paciente/create']],
                               ['label' => 'Ingresar', 'url' => ['/site/login']]
                          ],
                      ]);
                      }

                     ?> 
                     </nav>            
                    </div>
                </div>
    <div class="contenido title-nav">
      <div class="container ">
          
       <?php if (isset($this->blocks)) { 
       if(array_key_exists('block1', $this->blocks)){ ?>
         <?=

         $this->blocks['block1']; ?>
         <?php } }?>

      </div>

    </div>
    <?php if (Yii::$app->user->enableSession = false): ?>
    <div><?= Alert::widget() ?></div>
    <div class="container breadcrumb">
    <?= Breadcrumbs::widget([
              'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
          ]) ?>
          </div>
          
    <?php endif ?>
    <?php if (isset($this->blocks)) {
    if(array_key_exists('block2', $this->blocks)){ ?>
      <?= $this->blocks['block2']; ?>
    <?php } }?>
    <div class="contenido2 mt-5 contenido3">
      <div class="container ">
        <?= $content ?> 
      </div>
    </div>
</div>
<footer class="footer" >
   
       
        <div class=" credit col-xs-12 col-sm-12 col-md-12 col-lg-12  text-center" style=" background-color: #62B900;" >
        <span class="col-xs-12 col-sm-12  col-md-6 col-lg-6">&copy; Nutrici&oacute;n 2018 | Todos los derechos reservados </span>
         <span class="col-xs-12 col-sm-12  col-md-6 col-lg-6 "> Dise&ntilde;ado por Juan Manuel Ruiz | Alan Arregui</span>
        </div>
  
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
