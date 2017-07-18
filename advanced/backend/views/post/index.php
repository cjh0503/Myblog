<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Posts', ['create'], ['class' => 'btn btn-success']) ?>

        <?= Yii::t('app' , 'ID'); ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',//序列号从1自增长
                'header'=>'id'],

            //'id',
            'title',
            'author',
            //'content:ntext',
            //'status',
            [
                'attribute' => 'status',
                'value' => function ($model,$key,$index,$column){
                        return $model->status==1?'正常':'已删除';
                },
                'filter' => ['1' => '正常','0' => '已删除'],
            ],
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn',//动作列yii\grid\ActionColumn 用于显示一些动作按钮，如每一行的更新、删除操作。
             'header' => '操作',
            ],
        ],
    ]); ?>
</div>
