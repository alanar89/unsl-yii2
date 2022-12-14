<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Iniciar Sesión';
?>
<div class="site-login">
    <?php $this->beginBlock('block1'); ?>
        <h1 class="title-inv"><?= Html::encode($this->title) ?></h1>
        <p class="title-inv">Por favor complete los siguientes campos para iniciar sesión:</p>

    <?php $this->endBlock(); ?>

 

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput()->label('contraseña') ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ])->label('recuerdame') ?>
<div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
               <?= Html::a('No tienes cuenta? registrate', ['paciente/create']) ?>
           
        </div>
   </div>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            
        </div>
         
    <?php ActiveForm::end(); ?>


</div>
