// JavaScript Document
// purchasing operation
$('body').on('beforeSubmit', 'form#form-purchase', function () {
     var form = $(this);
     // return false if form still have some validation errors
     if (form.find('.has-error').length) {
		  alert("Please, make sure you have filled all the inputs properly!");
          return false;
     }
	 $("button[name='purchase-button']").prop('disabled', true);
	 $("form#form-purchase #currencyform-amountpur, form#form-purchase #currencyform-currencypur").prop('disabled', true);
	 $(".loader-icon-xs-purchase").fadeIn('400');
	 var currency_purchaced = $('form#form-purchase #currencyform-currencypur').val();
	 var initial_amount  = $('form#form-purchase #currencyform-amountpur').val();
     // submit form
     $.ajax({
          url: form.attr('action'),
          type: 'post',
          //data: form.serialize(),
		  data: {
		    operation:$('form#form-purchase #currencyform-operationtype').val(),
	        amount:initial_amount,
		    currency:currency_purchaced		  
			    },
          success: function (response) {
               // do something with response
			   $("button[name='purchase-button']").removeAttr('disabled');
			   $("form#form-purchase #currencyform-amountpur, form#form-purchase #currencyform-currencypur").removeAttr('disabled');
			   $(".loader-icon-xs-purchase").fadeOut('400');
			   $("#currencyform-amountzar").val(response.zar+' (ZAR)');
			   if(response.notify){
				   $(".alert-currency").remove();
				   $("#purchase-view-tpl").prepend('<div class="col-lg-9 alert-currency"><div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><p>'+response.notify_message+'</p>'+''
				   +'<hr size="1" class="pfc-notify-hr" />'+''
				   +'<strong>Amount Purchased:</strong> '+initial_amount+' ('+currency_purchaced+').'+''
				   +'<br /><strong>Calculation in ZAR:</strong> '+$('#currencyform-amountzar').val()+'.'+''
				   +'<br /><strong>Amount of surcharge:</strong> '+response.amount_of_surcharge+' (ZAR).'+''
				   +'<br /><strong>Value after surcharging ('+response.surchargerate+'%):</strong> '+response.total_purchased+' (ZAR).'
				   +'</div></div>');
				   if(response.discount){
					 $('body').append('<div class="notify-flash"></div>'); 	
					 $('body .notify-flash').html('<strong>Tip:</strong> Due of ('+currency_purchaced+') currency, the amount '+response.total_purchased+' (ZAR)  has be discounted for a ratio of 2%, and saved to the operations list.').fadeIn(500).delay(5000).fadeOut(500,function(){
					$('.notify-flash').remove();	 
					 });  ;				
				   }
				   if(response.sendmailnotification){
					 $('body').append('<div class="notify-flash"></div>'); 	
					 $('body .notify-flash').html('<strong>Tip:</strong> Due of ('+currency_purchaced+') currency, a message notification has been sent to your email address, including the details of order that was requested early.').fadeIn(500).delay(5000).fadeOut(500,function(){
					$('.notify-flash').remove();	 
					 });  ;				
				   }
				   // adjust height view after remving alert box
				   $("#purchase-view-tpl .alert-currency a.close").click(function() {
				   $("#purchase-view-tpl .alert-currency").remove();
				   });				   
			   }
          }
     });
     return false;
});
// payment operation
$('body').on('beforeSubmit', 'form#form-pay', function () {
     var form = $(this);
     // return false if form still have some validation errors
     if (form.find('.has-error').length) {
		  alert("Please, make sure you have filled all the inputs properly!");
          return false;
     }
	 $("button[name='pay-button']").prop('disabled', true);
	 $("form#form-pay #currencyform-amountpzar, form#form-pay #currencyform-paycurrency").prop('disabled', true);
	 $(".loader-icon-xs-pay").fadeIn('400');
	 var currency_purchaced = $('form#form-pay #currencyform-paycurrency').val();
	 var initial_amount  = $('form#form-pay #currencyform-amountpzar').val();
     // submit form
     $.ajax({
          url: form.attr('action'),
          type: 'post',
          //data: form.serialize(),
		  data: {
		    operation:$('form#form-pay #currencyform-operationtype').val(),
	        amount:initial_amount,
		    currency:currency_purchaced		  
			    },
          success: function (response) {
               // do something with response
			   $("button[name='pay-button']").removeAttr('disabled');
			   $("form#form-pay #currencyform-amountpzar, form#form-pay #currencyform-paycurrency").removeAttr('disabled');
			   $(".loader-icon-xs-pay").fadeOut('400');
			   $("#currencyform-amountp").val(response.pfc+' ('+currency_purchaced+')');
			   if(response.notify){
				   $(".alert-currency").remove();
				   $("#pay-view-tpl").prepend('<div class="col-lg-9 alert-currency"><div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><p>'+response.notify_message+'</p>'+''
				   +'<hr size="1" class="pfc-notify-hr" />'+''
				   +'<strong>Amount Paid:</strong> '+numberFormat(initial_amount)+' (ZAR).'+''
				   +'<br /><strong>Calculation in '+currency_purchaced+':</strong> '+response.pfc+' ('+currency_purchaced+')'+''
				   +'</div></div>');			   
			   }
			   	   // adjust height view after remving alert box
				   $("#pay-view-tpl .alert-currency a.close").click(function() {
				   $("#pay-view-tpl .alert-currency").remove();
				   });	
          }
     });
     return false;
});

function numberFormat(value) {
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}