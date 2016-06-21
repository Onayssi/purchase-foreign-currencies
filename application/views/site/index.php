<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Purchase Foreign Currencies';
?>

<div class="site-index">

    <div class="jumbotron">
        <h2>Purchase Foreing Currencies</h2>       
    </div>

    <div class="body-content">

	<!-- Display output data links -->
             
         <div class="output-data-view">
         <h3>The currencies that can be purchased are:</h3>
         <ul align="center">
         <li>US Dollars (USD)</li>
         <li>British Pound (GBP)</li>
         <li>Euro (EUR)</li>
         <li>Kenyan Shilling (KES)</li>
         </ul>
		 </div>
         
         <h5>The currency used for payment with be South African Rands (ZAR).</h5>
	<!-- Display main access links -->
    
		<div align="center">
        <br clear="all" />
         <?php if(Yii::$app->user->isGuest){?>
   				 <div align="center" class="alert alert-warning">In order to Purchase / Pay currencies, you should login before, or Sign Up for a new account if you do not have one yet.</div>
         <div class="col-md-12">
         <a class="btn btn-default btn-primary" href="<?= Url::to(['site/login'])?>">Login</a>
		 &nbsp;
         <a class="btn btn-default btn-primary" href="<?= Url::to(['site/signup'])?>">Sign Up</a>
         </div>  
                       
         <?php }else{?>
         
         <div class="col-md-12">
         <a class="btn btn-default btn-success" href="<?= Url::to(['site/currencies'])?>">Purchase / Pay</a>
         </div>
           
         <?php }?>
         
	    </div> 
      
        <br clear="all" />
        
        <hr size="1" />

    </div>
</div>
