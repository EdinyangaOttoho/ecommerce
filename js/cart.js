/* The err() function is a function meant to toggle a div that stores the message. The parameters parsed are message
i.e err(message) and it pops out, displaying the given message */
var ct = 0;
function discart() {
    // This handles the display toggling of the shopping cart
	if (ct == 0) {
		_('shopcart').style.display = 'block';
		ct = 1;
	}
	else {
		_('shopcart').style.display = 'none';
		ct = 0;
	}
}
function addcart(x){
    //Parses the id of the product to the workOn function for query
	workOn(x);
}
function see(){
	if (cartnum >= 1) {
		_("num-cart").style.display = 'block'; //Toggles the cart item count if the user is logged in
	}
}
function workOn(x) {
	var xhttp;
    	if (XMLHttpRequest) {
    		xhttp = new XMLHttpRequest();
    	}
    	else {
    		xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    	}
    	xhttp.onreadystatechange = function() {
    		if (this.readyState == 4 && this.status == 200) {
    			if (this.responseText != 'error') {
    				_("num-cart").style.display = 'block';
    				_("num-cart").innerText = this.responseText.split("||||")[1]; //Splits the response in form of items |||| total number and displays
    				document.querySelectorAll(".checkout-inner")[0].innerHTML = this.responseText.split("||||")[0];
                    err("Added to cart");
               }
               else {
                    err("Unable to complete. Item already included"); //Error viewer
               }
    		}
    	}
    	xhttp.open('POST','https://www.247naijaforum.com/ecommerce/settings.php?id='+x,true);
    	xhttp.send();
}
var cartarray = new Array(); //New array to hold the cart product ids
function checkbuy() {
		cartarray = [];
        for (var i = 0;i<document.querySelectorAll(".ids").length;i++) {
            cartarray.push(document.querySelectorAll(".ids")[i].id);
        }
        var xhttp;
        if (XMLHttpRequest) {
            xhttp = new XMLHttpRequest();
        }
        else {
            xhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                    _("view-details").style.display = 'block';
                    _("inner").innerHTML = this.responseText;
               }
               else {
                    err("Unable to complete!"); //Error message
               }
        }
        xhttp.open('GET','https://www.247naijaforum.com/ecommerce/settings.php?arr='+cartarray,true);
        xhttp.send();
}
function remelem(x) {
		var xhttp;
    	if (XMLHttpRequest) {
    		xhttp = new XMLHttpRequest();
    	}
    	else {
    		xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    	}
    	xhttp.onreadystatechange = function() {
    		if (this.readyState == 4 && this.status == 200) {
    			if (this.responseText != 'error') {
    				_("num-cart").style.display = 'block';
    				_("num-cart").innerText = this.responseText.split("||||")[1]; //Splits the response in form of items |||| total number and displays
    				document.querySelectorAll(".checkout-inner")[0].innerHTML = this.responseText.split("||||")[0];
                    err("Removed from cart!");
               }
               else {
                    err("Unable to complete!");
               }
    		}
    	}
    	xhttp.open('POST','https://www.247naijaforum.com/ecommerce/settings.php?remid='+x,true);
    	xhttp.send();
}
