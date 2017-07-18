<?php
/* @var $this yii\web\View */
use yii\widgets\LinkPager;
use yii\helpers\Url;
use common\widgets\HelloWidget;
$this->title = '博客首页-上榴人士';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>上榴人士</h1>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-8"></div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= HelloWidget::widget(['message' => '文章']); ?>
    </div>
    <div class="panel-body">
<?php
    foreach ($models as $model) {
?>
        <div class="media">
            <!-- <div class="media-left">
            <a href="#">
                <img class="media-object" src="..." alt="...">
            </a>
            </div> -->
            <div class="media-body">
                <h4 class="media-heading"><a href="<?php echo Url::toRoute(['post/item', 'id' => $model->id]); ?>">
                    <?php echo $model->title; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <small>作者：<?php echo $model->author;?></small>
                </h4>
                <p><?php echo substr($model->content,0,250).".....";?></p>
            </div>
        </div>
        <?php
        }
        echo LinkPager::widget(['pagination' => $pages,]);
        ?>
    </div>
</div>
