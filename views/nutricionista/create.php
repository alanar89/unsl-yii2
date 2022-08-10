<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Nutricionista */

$this->title = 'Alta Nutricionista';
$this->params['breadcrumbs'][] = ['label' => 'Investigador', 'url' => ['investigador/panel']];
 $this->params['breadcrumbs'][] = $this->title;

?>

<div class="nutricionista-create">
	<?php $this->beginBlock('block1'); ?>
   	 <h1 class="title"><?= Html::encode($this->title) ?></h1>
	<?php $this->endBlock(); ?>
   
    <?= $this->render('_form', [
        'model' => $model,'model1'=>$model1, 'prov'=>$prov, 'dept' => $dept, 'loc' => $loc
    ]) ?>

</div>



