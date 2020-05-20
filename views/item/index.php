<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'item_id',
            'item_name',
//            'quantity',
            [
                'attribute' => 'quantity',
                'contentOptions' => ['class' => 'text-center'],
            ],

//            'price:currency',
// old method, you can manually change each attribute
            [
                'attribute' => 'price',
                'format' => 'currency',
                'contentOptions' => ['class' => 'text-center'],
            ],

            'description:ntext',
            //'created_at',
            //'created_by',
            'createdBy.username',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>



</div>
