<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\User;
use app\models\Order;

class Rate extends ActiveRecord{

public static function jsonratesIsConnected(){
    $connected = @fsockopen("http://www.jsonrates.com", 80); 
    //site, port  (try 80 or 443)
    if ($connected){
        $is_conn = true; //action when connected
        fclose($connected);
    }else{
        $is_conn = false; //action in connection failure
    }
    return $is_conn;
}

public static function GoogleIsConnected(){
	$host = 'google.com';
	if($socket =@ fsockopen($host, 80, $errno, $errstr, 30)) {
	fclose($socket);
	return true;
	} else {
	return false;
	}
}

public static function getOnlineCurrencyRate($from,$to,$amount) {
    $amount = urlencode($amount);
    $from_Currency = urlencode($from);
    $to_Currency = urlencode($to);
    $url = "http://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
    $ch = curl_init();
    $timeout = 0;
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $rawdata = curl_exec($ch);
    curl_close($ch);
    $data = explode('bld>', $rawdata);
    $data = explode($to_Currency, $data[1]);
    return round($data[0], 8);
}

public function getRateByParams($from,$to){
	$record = $this::find()->where(['from'=>$from,'to'=>$to])->one();
	return $record['rate'];
}

public function getRateId($from,$to){
	$record = $this::find()->where(['from'=>$from,'to'=>$to])->one();
	return $record['id'];
}

public function getRateById($id){
	$record = $this::findOne($id);
	return $record['rate'];
}

public function getRateSurchargeById($id){
	$record = $this::findOne($id);
	return $record['surcharge'];
}

public function doRateUpdate($from,$to,$value,$utc){
	 $rate_id = $this::getRateId($from,$to);
	 $rate =  $this::findOne($rate_id);
     $rate->utctime = $utc;
	 $rate->rate = $value;
     $rate->save();
	 return $rate_id;
}

public function calculateFromZAR($amount,$id){
	$rate =  $this::findOne($id);
	$ratio = $rate['rate'];
	// get 7 digits after '.'
	return round($amount*$ratio,7);	
}

public function calculateToZAR($amount,$id){
	$rate =  $this::findOne($id);
	$ratio = $rate['rate'];
	// get 7 digits after '.'
	return round($amount/$ratio,7);
}

public function calculateSurchargedToZAR($freezeamount,$id){
	$surcharge = $this::getRateSurchargeById($id);
	$amount_surcharged = ($freezeamount + (($freezeamount*$surcharge)/100));
	// get 7 digits after '.'
	return round($amount_surcharged,7);	
}
// get amount of surchage for an order
public function amountOfSurcharge($amount,$id){
	return $this::calculateSurchargedToZAR($amount,$id) - $amount;
}

public function saveOrder($id,$operation,$fcp,$initialamount,$fcpamount){
     $order = new Order();
     $order->userid = Yii::$app->user->identity->id;
	 $order->operation = $operation;
	 $order->fcp = $fcp;
	 $order->rate = $this::getRateById($id);
	 $order->initial_amout = $initialamount;
	 $order->fcp_amount = $fcpamount;
	 if($operation==="pay"){
		 // not necessary because 0 will be added by default
	 $order->surcharge = 0;
	 $order->fcp_amount_surcharged = $fcpamount;
	 // not necessary because 0 will be added by default
	 $order->amount_of_surcharge = 0;		 
	 }else{
	 $order->surcharge = $this::getRateSurchargeById($id);
	 $order->fcp_amount_surcharged = $this::calculateSurchargedToZAR($fcpamount,$id);
	 $order->amount_of_surcharge = $this::amountOfSurcharge($fcpamount,$id);		 
	 }
     $order->save();
	 return $order->id;
}
// make discount
public static function setDiscountOrder($id,$amount){
     $discount = new Discount();
	 $discount->order_id = $id;
	 $discount->action = 'Apply a 2% discount';
	 $discount->total_amount_discount = ($amount - (($amount*2)/100));
     $discount->save();
	 return $discount->id;	
}
// reserver the operation notification
public static function setNotifyOrder($id,$amount){
     $discount = new Discount();
	 $discount->order_id = $id;
	 $discount->action = 'Send an Email Notification';
	 $discount->total_amount_discount = $amount;
     $discount->save();
	 return $discount->id;	
}

}
?>