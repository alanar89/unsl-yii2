<?php

use yii\helpers\Html;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Investigador */

$this->title = 'Alta Investigador';
$this->params['breadcrumbs'][] = ['label' => 'Investigador', 'url' => ['panel']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="investigador-create">
	<?php $this->beginBlock('block1'); ?>
   	 <h1 class="title-inv"><?= Html::encode($this->title) ?></h1>
	<?php $this->endBlock(); ?>
    <?= $this->render('_form', [
        'model' => $model,'model1'=>$model1
    ]) ?>

</div>
