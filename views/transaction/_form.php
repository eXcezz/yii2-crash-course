<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Item;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $model app\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>


    <?php $itemMain = ArrayHelper::map(Item::find()->orderBy('item_name')->all(), 'item_id','item_name')?>

    <?= @$form->field($model, 'item_id')->dropDownList(
        $itemMain,[
            'prompt'=>'Select Item',
            'onchange' => '
                    $.post("index.php?r=item/pricequantity&id='.'"+$(this).val(),
                    function (data){
                        $("#item-price").val(data.split("_")[0]);
                        $("#transaction-quantity_order").html(data);
                    });'
        ]
    ); ?>

    <?= $form->field($modelItem, 'price',)->textInput(['maxlength' => true, 'readonly'=> true,]) ?>

    <?= @$form->field($model, 'quantity_order',)->dropDownList([]); ?>

    <?= $form->field($model, 'total_amt')->textInput(['maxlength' => true, 'readonly'=> true,]) ?>

    <?= $form->field($model, 'txn_report')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'order_id')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs('

            jQuery(document).on("change" ,"#'. Html::getInputId($model ,'quantity_order') .'" ,function(){

                var first = $("#'. Html::getInputId($model ,'quantity_order') .'").val();
                var second = $("#'. Html::getInputId($modelItem ,'price') .'").val();
                var third = first * second;
                $("#'. Html::getInputId($model ,'total_amt') .'").val(third);

            });

            jQuery(document).on("change" ,"#'. Html::getInputId($model ,'item_id') .'" ,function(){
                var blank = 0.00;
                $("#'. Html::getInputId($model ,'total_amt') .'").val(blank);
                $("#'. Html::getInputId($model ,'quantity_order') .'").val(blank);

            });

        ');
?>

<?php /* 2 dependant dropdown list....notice the select# line

             //        ArrayHelper::map(Item::find()->asArray()->orderBy('item_name')->all(), 'item_id','item_name'),


    <?= @$form->field($model, 'item_id')->dropDownList(
            $itemMain,[
                'prompt'=>'Select Item',
                'onchange' => '
                    $.post("index.php?r=item/lists&id='.'"+$(this).val(), function (data){
                        $("select#transaction-total_amt").html(data);
                    });'
                ]

    ); ?>

    <?php $itemPrice = ArrayHelper::map(Item::find()->all(), 'item_id','price')?>


    <?= @$form->field($model, 'total_amt')->dropDownList(
        $itemPrice,[
            'prompt'=>'-',
        ]
    );  ?>

*/?>





