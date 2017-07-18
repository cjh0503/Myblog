<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
?>
<h1>Tag</h1>

<?php foreach($tags as $tag) {?>
<a class="btn btn-primary" type="button" href="<?php echo Url::toRoute(['post/index', 'id' => $tag['id'],]); ?>">
    <?php echo $tag['tag']; ?> &nbsp;<span class="badge"><?php echo $num[$tag['id']]; ?></span>
</a>
<?php } ?>

