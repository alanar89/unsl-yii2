<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NutricionistaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nutricionista-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'dni') ?>

    <?= $form->field($model, 'direccion') ?>

    <?= $form->field($model, 'provincia') ?>

    <?= $form->field($model, 'departamento') ?>

    <?php // echo $form->field($model, 'localidad') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
