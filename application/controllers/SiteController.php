<?php
namespace app\controllers;

use Yii;
use app\models\LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\CurrencyForm;
use app\models\Rate;
use app\models\Order;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl; 

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            //return $this->goHome();
			return $this->redirect(['currencies']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
			return $this->redirect(['currencies']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    //return $this->goHome();
					return $this->redirect(['currencies']);
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
	
	public function actionCurrencies()
	{
		if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		
		$model = new CurrencyForm();   
		
		 return $this->render('currencies', [
            'model' => $model,
        ]);
	 
	}

public function actionCalculate()
	{
		 Yii::$app->response->format = Response::FORMAT_JSON;
		 if (Yii::$app->request->isAjax) {
			 // will return a json object
			 $return = ['notify'=>false,'discount'=>false,'sendmailnotification'=>false];      		 
			 $post = (Yii::$app->getRequest()->getBodyParams());
			 // to be used for update notification
				$notify_update = false;
				// amount value
				$amount_purchase = $post['amount'];
				// currency type
				$currency_purchase = $post['currency'];
				// get parameter Key to set call via json rates API
				$jrapiky = Yii::$app->params['jsonratesAPIKey'];
			// operation is purchasing
			if($post['operation']==='purchase'){
				// check api domain availability
				if(Rate::GoogleIsConnected()){ 
				// check for upddates stored rates
				# Deprecated
				/*
				$api_call = file_get_contents('http://jsonrates.com/get/?from=ZAR&to='.$currency_purchase.'&apiKey='.$jrapiky);				
				$datacallback = json_decode($api_call);
				$rate_value = (float) $datacallback->rate;
				*/
				$rate_value = Rate::getOnlineCurrencyRate('ZAR',$currency_purchase,1);
				// get time zone of RSA
				date_default_timezone_set('Africa/Johannesburg');
				$utc_offset =  date('Z') / 3600;
				if($utc_offset<10) $utc_offset = '0'.$utc_offset;
				$utc_offset = $utc_offset.":00";				
				$utc_value = (string) date("Y-m-d\TH:i:s+$utc_offset");
				// check rate value
				// use Rate Model
				$rate = new Rate();
				if($rate->getRateByParams('ZAR',$currency_purchase)!==$rate_value){
					// do update stored rate value
					$return['rate_record'] = $rate->doRateUpdate('ZAR',$currency_purchase,$rate_value,$utc_value);
					$notify_update = true;
				}
				}
				// calculate initial result
				$rate = new Rate();
				$rate_id = $rate->getRateId('ZAR',$currency_purchase);
				$surcharge = $rate->getRateSurchargeById($rate_id);
				$result = $rate->calculateToZAR($amount_purchase,$rate_id);	
				$return['zar'] = $result;
				// save order
				$return['saved'] = $rate->saveOrder($rate_id,'purchase',$currency_purchase,$amount_purchase,$result);
				$return['notify'] = true;
				$return['notify_message'] = 'The operation has been done successfully!';
				$order_details = Order::findOne($return['saved']);
				$amount_after_surchaging = $order_details['fcp_amount_surcharged'];
				$return['surchargerate'] = $surcharge;
				$return['total_purchased'] = $amount_after_surchaging;
				$return['amount_of_surcharge'] = $order_details['amount_of_surcharge'];
				if($currency_purchase==="EUR"){
				   	// apply discount of 2% in this case
					$return['discount'] = true;
					Rate::setDiscountOrder($return['saved'],$amount_after_surchaging);
				}else if($currency_purchase==="GBP"){
					// send email notification
					$return['sendmailnotification'] = true;
					Rate::setNotifyOrder($return['saved'],$amount_after_surchaging);
					// send email to user including order details
					//Yii::$app->timeZone = 'Africa/Johannesburg';
					Yii::$app->timeZone = 'UTC';
					$htmlbody_content = "Dear ".Yii::$app->user->identity->username.";<br />You have purchased an amount of ".$amount_purchase." (".$currency_purchase."), the details of the operation are mentioned below:";
					$htmlbody_content .= "<br />";
					$htmlbody_content .= "<table cellpadding='5' cellspacing='5'>";
					$htmlbody_content .= "<tr>".""
					."<tr><th>Order Number</th><td>#".$order_details["id"]."</td></tr>".""				
					."<tr><th>Foreign currency purchased</th><td>".$order_details["fcp"]."</td></tr>".""
					."<tr><th>Exchange rate for foreign currency</th><td>".$order_details["rate"]."</td></tr>".""
					."<tr><th>Surcharge percentage</th><td>".$order_details["surcharge"]."%</td></tr>".""
					."<tr><th>Amount of foreign currency purchased</th><td>".Yii::$app->formatter->asDecimal($order_details["initial_amout"])." (".$order_details["fcp"].")</td></tr>".""
					."<tr><th>Amount to be paid in ZAR</th><td>".Yii::$app->formatter->asDecimal($order_details["fcp_amount_surcharged"])." (ZAR)</td></tr>".""
					."<tr><th>Amount of surcharge</th><td>".Yii::$app->formatter->asDecimal($order_details["amount_of_surcharge"])." (ZAR)</td></tr>".""
					."<tr><th>Date Created</th><td>".Yii::$app->formatter->asDatetime($order_details["created_at"], "php:d-M-Y @ H:i:s")."</td></tr>";
					$htmlbody_content .= "</table>";
					$htmlbody_content .= "<br /><p align='left'><i>&copy; Purchase Foreign Currencies. All rights reserved.</i></p>";
					Yii::$app->mailer->compose('layouts/html', ['content' => $htmlbody_content])
					->setFrom([Yii::$app->params['adminEmail'] => 'Purchase Foreign Currencies'])
					->setTo(Yii::$app->user->identity->email)
					->setSubject('Purchase foreign currencies - Order Details' )
					->send();
				}			
				}else{
				// operation is paying
				// check api domain availability
				if(Rate::GoogleIsConnected()){ 
				// check for upddates stored rates
				# Deprecated
				/*
				$api_call = file_get_contents('http://jsonrates.com/get/?from=ZAR&to='.$currency_purchase.'&apiKey='.$jrapiky);
				$datacallback = json_decode($api_call);
				$rate_value = (float) $datacallback->rate;
				*/
				$rate_value = Rate::getOnlineCurrencyRate('ZAR',$currency_purchase,1);
				// get time zone of RSA
				date_default_timezone_set('Africa/Johannesburg');
				$utc_offset =  date('Z') / 3600;
				if($utc_offset<10) $utc_offset = '0'.$utc_offset;
				$utc_offset = $utc_offset.":00";
				$utc_value = (string) date("Y-m-d\TH:i:s+$utc_offset");
				// check rate value
				// use Rate Model
				$rate = new Rate();
				if($rate->getRateByParams('ZAR',$currency_purchase)!==$rate_value){
					// do update stored rate value
					$return['rate_record'] = $rate->doRateUpdate('ZAR',$currency_purchase,$rate_value,$utc_value);
					$notify_update = true;
				}
				}	
				// calculate result
				$rate = new Rate();
				$rate_id = $rate->getRateId('ZAR',$currency_purchase);
				$result = $rate->calculateFromZAR($amount_purchase,$rate_id);	
				$return['pfc'] = $result;
				// save order
				$return['saved'] = $rate->saveOrder($rate_id,'pay',$currency_purchase,$amount_purchase,$result);
				$return['notify'] = true;
				$return['notify_message'] = 'The operation has been done successfully!';
				$order_details = Order::findOne($return['saved']);
				$return['total_paid'] = $order_details['fcp_amount'];									
			}
 
    }else{
		$return = ['error'=>true,'code'=>'UDCEx','exception'=>'Unauthorized HTTP Exception'];
	}
	        return $return;

	}
		
	public function actionHistory(){
		if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		// use Query Build to handle join issues instead of creation of relations in models with Active Record
		$query = new \yii\db\Query;
    	$query->select('orders.*, discount.action, discount.total_amount_discount')
            ->from('orders')
            ->leftJoin('discount', '`orders`.`id` = `discount`.`order_id`')  
            ->where(['`orders`.`userid`'=>Yii::$app->user->identity->id])
			->orderBy('orders.created_at');
    	$command = $query->createCommand();
    	$orders = $command->queryAll();
	
		return $this->render('history', [
            'orders' => $orders
        ]);
	}
}
