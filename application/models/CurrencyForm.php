<?php
namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class CurrencyForm extends Model
{
    public $amountpur;
	public $currencypur;
	public $amountzar;
	public $amountpzar;
	public $paycurrency;
	public $amountp;
	public $operationtype;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['amountpur', 'filter', 'filter' => 'trim'],
			['amountpzar', 'filter', 'filter' => 'trim'],
			[['amountpur','amountpzar'], 'required'],
			[['amountpur','amountpzar'], 'double'],	
			[['amountpur','amountpzar'], 'double', 'min'=>1],	
            ['currencypur', 'required'],
			['paycurrency', 'required', 'message'=>'Currency type must be selected.'],
        ];
    }
		
	public function attributeLabels(){
		
   		 return [
      		  'amountpzar' => 'Amount in ZAR',
			  'amountpur' => 'Amount',
			  'currencypur' => 'Currency type',
    ];
}	
}
