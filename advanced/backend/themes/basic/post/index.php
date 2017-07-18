<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

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
<?php Pjax::begin(['id' => 'testPjax']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter' => true,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'id',
            ],
            [
             'class' => 'yii\grid\SerialColumn',
             'header'=>'id'
            ],
            'title',
            'author',
            [
                'attribute' => 'status',
                'value' => function ($model,$key,$index,$column){
                        return $model->status==1?'正常':'已删除';
                },
                'filter' => ['1' => '正常','0' => '已删除'],
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            // 'updated_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
            ],
        ],
       
    ]); ?>
<?php Pjax::end(); ?>
</div>

