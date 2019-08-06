//This is the JS payment processor
var amt;//Instantiates the amount variable
function buynow(x) {
	_("view-details").style.display = 'none';//Hides the Cart detail form
	   var xhttp;
       if (XMLHttpRequest) {
            xhttp = new XMLHttpRequest();
       }
       else {
            xhttp = new ActiveXObject('Microsoft.XMLHTTP');
       }
       xhttp.onreadystatechange = function () {
           if (this.readyState == 4 && this.status == 200) {
            	amt = parseFloat(this.responseText);
            	if (amt == 0) {//This checks if the product is FREE or not
        		   var xhttp;
		           if (XMLHttpRequest) {
		                xhttp = new XMLHttpRequest();
		           }
		           else {
		                xhttp = new ActiveXObject('Microsoft.XMLHTTP');
		           }
		           xhttp.onreadystatechange = function () {
		               if (this.readyState == 4 && this.status == 200) {
		                   if (this.ResponseText != 'error') {
		                       errr("Thanks for buying our product");
		                   }
		                   else {
		                       err("Unable to complete payment");
		                   }
		               }
		           }
		           xhttp.open('GET','https://www.247naijaforum.com/ecommerce/settings.php?paid=0&ref=0000000000',true);
		           xhttp.send();
            	}
            	else {
            		payWithPaystack(amt);	
            	}
           }
       }
       xhttp.open('GET','https://www.247naijaforum.com/ecommerce/settings.php?amt='+x,true);
       xhttp.send();
}
function payWithPaystack(x) { //Displays the Paystack payment page and parses amount
	  var amount = parseFloat(x) * 100;
	  var email = 'elzucky@gmail.com';
	  var handler = PaystackPop.setup({
	       key:'pk_test_ccb78c39f39b80d0b47734286a4a2d1d9dcc3ab1',
	       amount:amount,
	       email:email,
	       currency:'NGN',	       metadata:{
	           custom_fields:[
	               {
	                   display_name:'Product Payment',
	                   variable_name:'product_payment',
	                   value:'NGN'+amount
	               }
	           ]
	       },
	       onclose:function() {
	           err("Transaction Cancelled");
	       },
	       callback:function(response) {
	           var xhttp;
	           if (XMLHttpRequest) {
	                xhttp = new XMLHttpRequest();
	           }
	           else {
	                xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	           }
	           xhttp.onreadystatechange = function () {
	               if (this.readyState == 4 && this.status == 200) {
	                   if (this.ResponseText != 'error') {
	                       errr("Thanks for buying our product");
	                   }
	                   else {
	                       err("Unable to complete payment");
	                   }
	               }
	           }
	           //This sends the payment amount and the reference to the Back-end
	           xhttp.open('GET','https://www.247naijaforum.com/ecommerce/settings.php?paid='+x+'&ref='+response.reference,true);
	           xhttp.send();
	       }
	  });
	  handler.openIframe();
}
