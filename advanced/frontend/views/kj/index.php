<?php
/* @var $this yii\web\View */
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
?>
<h1>kj/index</h1>

<?php $form = ActiveForm::begin(); ?>
    <?php echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'username' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '输入...']],
        ]
    ]);?>
<?php ActiveForm::end() ?>

