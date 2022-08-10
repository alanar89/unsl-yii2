<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\Investigador */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="investigador-form">

    <?php $form = ActiveForm::begin(
        [ "method" =>"post",
        "id" => "formulario",
        "enableAjaxValidation" => true,
        'options'=>['class' => 'reg-form']]); ?>
    <h3>Datos Personales</h3>
    <div class=" col-xs-12">
        <hr class="mt-0">  
    </div>
    <div class="row col-xs-12">  
        <div class="form-group col-xs-12 col-md-6">
            <?= $form->field($model1, 'nombre') ?>
            <?= $form->field($model1, 'apellido') ?>
            <?= $form->field($model1, 'dni')->textInput([
                                 'type' => 'number',]) ?>
            <?= $form->field($model1, 'email') ?>
            <?= $form->field($model1, 'telefono') ?>
            <?= $form->field($model1, 'pass')->passwordInput() ?>
            <?= $form->field($model, 'universidad') ?>
                <?= $form->field($model, 'facultad') ?>
        </div>
    <div class="row col-xs-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
</div>