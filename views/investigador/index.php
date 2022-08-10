<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InvestigadorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Investigadores';
$this->params['breadcrumbs'][] = ['label' => 'Investigador', 'url' => ['panel']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="investigador-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Investigador', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'dni',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
