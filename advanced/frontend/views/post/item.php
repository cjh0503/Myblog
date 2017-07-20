<?php
use yii\helpers\Url;
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .media-reply {margin-left: 30px;}
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
<hr>





<h4>评论区</h4>
<?= Html::beginForm(['comment/add', 'id' => $post->id], 'post') ?>
<?= yidashi\markdown\Markdown::widget(['name' => 'comment', 'language' => 'zh'])?>
<br>
<?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
<?= Html::endForm(); ?>
<hr>
<br>
<div class="hidden" id="reply">
    <?= Html::beginForm(['reply/add'], 'post') ?>
    <?= Html::hiddenInput('comment_id', 0, ['id' => 'comment_id'])?>
    <?= yidashi\markdown\Markdown::widget(['name' => 'reply', 'language' => 'zh'])?>
    <br>
    <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
    <a class="retract" href="javascript:viod(0)" style="float: right;">收起</a>
    <?= Html::endForm(); ?>
</div>

<!-- 评论 -->
<ul class="media-list">
<?php foreach ($comments as $comment){?>
    

    <li class="media">
        <a class="pull-left" href="#">
            <img class="media-object" data-src="holder.js/64x64">
        </a>
        <div class="media-body">
            
            <h6 class="media-heading" style="color: #d32 !important;margin-bottom: 15px;"><?php ?></h6>
            <?php echo yii\helpers\Markdown::process($comment->comment, 'gfm'); ?>
            
            <small>
            <?php echo date("Y-m-d H:i", $comment->created_at);?>
            <a class="reply" href="javascript:void(0)" style="margin-left: 30px;"onclick="reply(this,<?php echo $comment->id;?>)">回复</a>
            </small>
            
            <?php if ($reply = $replys[$comment->id]){
                    foreach($reply as $reply){ ?>
                <div class="media media-reply">
                    <?php echo yii\helpers\Markdown::process($reply->reply, 'gfm'); ?>
                    <small><?php echo date("Y-m-d H:i", $reply->create_at); ?></small>
                </div>
            <?php }} ?>
        </div>
    </li>
    <hr>
<?php } ?>
</ul>


</div>

<script type="text/javascript">
    function reply(reply, comment_id){
        $('#comment_id').val(comment_id);
        $('#reply').removeClass('hidden');
        $(reply).after($('#reply'));
    }
    
    $('.retract').click(function(){
        $('#reply').addClass('hidden');
    });
</script>