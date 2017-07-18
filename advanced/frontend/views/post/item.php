<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?php echo $post->title; ?></h1>
<p class="text-muted">作者：<?php echo $post->author;?></p>
<?php foreach ($tags as $tag){ ?>
<a class="label label-primary" href="<?php echo Url::toRoute(['post/index', 'id' => $tag['id'],]); ?>">
    <?php echo $tag['tag']; ?>
</a>
<?php } ?>
<p>
    <?php echo yii\helpers\Markdown::process($post->content, 'gfm'); ?>
</p>