<?php
use yii\helpers\Url;
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    
</style>

<h1><?php echo $post->title; ?></h1>
<p class="text-muted">作者：<?php echo $post->author;?></p>
<div class="col-md-8">
<?php foreach ($tags as $tag){ ?>
<a class="label label-primary" href="<?php echo Url::toRoute(['post/index', 'id' => $tag['id'],]); ?>">
    <?php echo $tag['tag']; ?>
</a>
<?php } ?>
<p>
    <?php echo yii\helpers\Markdown::process($post->content, 'gfm'); ?>
</p>

<ul class="media-list">
<?php foreach ($comments as $comment){?>
    <li class="media">
        <a class="pull-left" href="#">
            <img class="media-object" data-src="holder.js/64x64">
        </a>
        <div class="media-body">
            <h4 class="media-heading">@<?php echo Yii::$app->user->identity->username; ?></h4>
            <?php echo yii\helpers\Markdown::process($comment->comment, 'gfm'); ?>
            <?php if ($reply = $replys[$comment->id]){
                    foreach($reply as $reply){ ?>
                <div class="media">
                    <?php echo yii\helpers\Markdown::process($reply->reply, 'gfm'); ?>
                </div>
            <?php }} ?>
        </div>
    </li>
    <hr>
<?php } ?>
</ul>

<?php Html::beginForm(['comment/add', 'id' => $post->id], 'post') ?>
<?= yidashi\markdown\Markdown::widget(['name' => 'comment', 'language' => 'zh'])?>
<?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
<?= Html::endForm(); ?>
</div>