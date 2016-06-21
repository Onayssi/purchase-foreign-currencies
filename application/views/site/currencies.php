<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
$this->title = 'Purchase / Pay Foreign Currencies';
$this->params['breadcrumbs'][] = $this->title;

?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>

<div class="col-md-6">
    <h3>Purchase Foreign Currency:</h3>
    
    <!-- purchase form -->
        <div class="row" id="purchase-view-tpl">
        <div class="col-lg-9">
            <?php $form = ActiveForm::begin(['id' => 'form-purchase','action'=>Url::to(['site/calculate'])]); ?>
               <?= $form->field($model, 'amountpur',['inputOptions' => ['class'=>'form-control','autocomplete' => 'off',]])?>             
               <?= $form->field($model, 'currencypur')->dropDownList(
            ['USD'=>'US Dollars (USD)','GBP'=>'British Pound (GBP)','EUR'=>'Euro (EUR)','KES'=>'Kenyan Shilling (KES)'], // Flat array ('id'=>'label')
            ['prompt'=>'Select Foreign Currency']    // options
        )->label('Purchasing Currency');?>
                <?= $form->field($model, 'amountzar')->textInput(['readonly' => true])->label('Amount in ZAR'); ?>
                <div class="form-group rlvpos" align="right">
                	<div class="loader-icon-xs-purchase"></div>
                    <?= Html::activeHiddenInput($model, 'operationtype',['value'=>'purchase']) ;?>
                    <?= Html::submitButton('Calculate', ['class' => 'btn btn-primary', 'name' => 'purchase-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    
    </div>
    
    <div class="col-md-6">
    
    <h3>Pay with ZAR Currency:</h3>
    
     <!-- pay form -->
        <div class="row" id="pay-view-tpl">
        <div class="col-lg-9">
            <?php $form = ActiveForm::begin(['id' => 'form-pay','action'=>Url::to(['site/calculate'])]); ?>
                <?= $form->field($model, 'amountpzar',['inputOptions' => ['class'=>'form-control','autocomplete' => 'off',]])->label('Amount in ZAR') ?>
                <?= $form->field($model, 'paycurrency')->dropDownList(
            ['USD'=>'US Dollars (USD)','GBP'=>'British Pound (GBP)','EUR'=>'Euro (EUR)','KES'=>'Kenyan Shilling (KES)'],  
            ['prompt'=>'Select Foreign Currency']    // options
        )->label('Paying Currency');?>
                <?= $form->field($model, 'amountp')->textInput(['readonly' => true])->label('Amount to be paid'); ?>
                <div class="form-group rlvpos" align="right">
                    <div class="loader-icon-xs-pay"></div>
                    <?= Html::activeHiddenInput($model, 'operationtype',['value'=>'pay']) ;?>
                    <?= Html::submitButton('Calculate', ['class' => 'btn btn-primary', 'name' => 'pay-button']) ?>

                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    
    </div>
    
	<br clear="all" />
    
</div>
