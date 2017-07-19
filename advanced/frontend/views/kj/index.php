<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use kartik\widgets\DatePicker;
use kartik\builder\Form;
?>
<h1>kj/index</h1>

<?php 
echo Html::beginForm('','', ['class' => 'form-horizontal']); 
echo Form::widget([
    'formName' => 'kvform',
    'columns' => 2,
    'attributeDefaults' => [
        'type' => Form::INPUT_TEXT,
        'labelOptions' => ['class' => 'col-md-3'],
        'inputContainer' => ['class'=>'col-md-9'],
        'container' => ['class'=>'form-group'],
    ],
    'attributes' => [
        'fld1' => ['label' => 'Name', 'value' => 'Kartik'],
        'fld2' => ['label' => 'Email', 'value' => 'info@solutions.com'],
        'fld3' => ['label' => 'From Date', 'type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\widgets\DatePicker'],
        'fld4' => ['label' => 'To Date', 'type' => Form::INPUT_WIDGET, 'widgetClass'=> '\kartik\widgets\DatePicker'],
        'fld5' => [
            'label' => 'Categories',
            'items' => [0 => 'one',1 => 'two',2 => 'three'],
            'type' => Form::INPUT_CHECKBOX_BUTTON_GROUP,
        ],
    ],
]);        
?>
<?php Html::endForm();?>