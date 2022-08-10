<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Nutricionista */

$this->title ='Actualizar perfil';
$this->params['breadcrumbs'][] = ['label' => 'Nutricionista', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'datos personales', 'url' => ['perfil']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nutricionista-update">
<?php $this->beginBlock('block1'); ?>
        <div class="row">
          
             <h1 class="title-inv"><?= Html::encode($this->title) ?></h1>
        </div>
    <?php $this->endBlock(); ?>

    <?= $this->render('_form1', [
       'model' => $model,'model1'=>$model1, 'prov'=>$prov, 'dept' => $dept, 'loc' => $loc,'update'=>'1',
    ]) ?>

</div>
