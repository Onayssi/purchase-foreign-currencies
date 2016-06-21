<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'History / Saved Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-history">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(count($orders)==0){?>
    <p align="left">&nbsp;</p>
    <div class="alert alert-warning">There are no orders saved yet. The History is empty.</div>
    <?php }else{?>
    <div class="table-responsive">
       <table class="table activerecords">
       <tr>
       <?php $array_th = ["Ref.","Operation","Currency","Rate","Surcharge","Amount","Calculated Amount","Amount of Surcharge","Total Amount","Final Amount","Created at"];	   
	   foreach($array_th as $th){?>
       <th><?=$th?></th>
       <?php }?>
       </tr>
       <?php foreach($orders as $order){?>
       <tr>
       <td>#<?=$order['id']?></td>
       <td><?=$order['operation']?></td>
       <td><?=$order['fcp']?></td>
       <td><?=$order['rate']?></td>
       <td><?=$order['surcharge']?></td>
       <td><?=Yii::$app->formatter->asDecimal($order["initial_amout"]);?></td>
       <td><?=Yii::$app->formatter->asDecimal($order['fcp_amount'])?> (<?=($order['operation']=="Pay")?$order['fcp']:"ZAR";?>)</td>
       <td><?=Yii::$app->formatter->asDecimal($order['amount_of_surcharge'])?><?=($order['operation']=="Pay")?"":" (ZAR)";?></td>
       <td><?=Yii::$app->formatter->asDecimal($order['fcp_amount_surcharged'])?> (<?=($order['operation']=="Pay")?$order['fcp']:"ZAR";?>)</td>
       <td><?=($order['action']=="Apply a 2% discount" && $order['operation']=="Purchase")?Yii::$app->formatter->asDecimal($order['total_amount_discount']).(" (ZAR)<br /><span class='alert-info'>".$order['action']."</span>"):Yii::$app->formatter->asDecimal($order['fcp_amount_surcharged']).(($order['operation']=="Purchase")?" (ZAR)":" (".$order['fcp'].")");?></td>
       <td><?=Yii::$app->formatter->asDatetime($order["created_at"], "php:d-M-Y")?><br /><?=Yii::$app->formatter->asDatetime($order["created_at"], "php:@ H:i A")?></td>
       </tr>
       <?php }?>
       </table>   
    </div>
    <?php }?>
</div>
