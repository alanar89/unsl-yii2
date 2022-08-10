<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form ActiveForm */
?>
<div class="usuario-formUsuario">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model1, 'dni') ?>
        <?= $form->field($model1, 'nombre') ?>
        <?= $form->field($model1, 'apellido') ?>
        <?= $form->field($model1, 'email') ?>
        <?= $form->field($model1, 'telefono') ?>
        <?= $form->field($model1, 'pass') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- usuario-formUsuario -->
