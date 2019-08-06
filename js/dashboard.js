/* The err() function is a function meant to toggle a div that stores the message. The parameters parsed are message
i.e err(message) and it pops out, displaying the given message */
var id = 0;
var uscanada = ['Next Day Delivery ($20)','3-4 Days ($10)','7 Days ($5)']; //An array to hold dropdown for US/Canada Shipping types
var europe = ['By air (7 days, $25)','By sea (28 days, $10)']; //An array to hold dropdown for Europe Shipping types
var other = ['By air (10 days, $35)','By sea (28 days, $30)']; //An array to hold dropdown for Rest of World Shipping types
var shippingid = '1'; //Default instance of shipping ID
var nation = ''; //Nation (Empty)
function pop(x) {
	_("full-screen-size").style.display = 'block'; //Toggles the update form
	id = x;
}
function err(message) { //Message popup
    document.querySelectorAll("#error")[0].style.display = 'block';
    document.querySelectorAll("#error")[0].innerHTML = '<center>'+message+'</center>';
    document.querySelectorAll("#error")[0].style.transition = '0.6s';
    setTimeout(function(){
        document.querySelectorAll("#error")[0].style.opacity = '1';
        document.querySelectorAll("#error")[0].style.top = '10vh';
    },100);
    setTimeout(function(){
        fin();
    },2500);
}
function fin() {//Hides the message popup after the message is served
    document.querySelectorAll("#error")[0].style.transition = '0.6s';
    document.querySelectorAll("#error")[0].style.opacity = '0';
    document.querySelectorAll("#error")[0].style.top = '-200px';
    setTimeout(function(){
    	window.location.replace("https://www.247naijaforum.com/ecommerce/options.php");
        document.querySelectorAll("#error")[0].style.display = 'none';
    },500);
}
/* This block adds the appropriate data required when the select option value is changed to match the corresponding shipping details
Like US/Canada fetches the array us/canada and so on */
function inptype(x,y) {
	if (x == 'region') {
		if (y == 'US/Canada') {
			_("type").innerHTML = '';
			for (var i = 0; i < uscanada.length; i++) {
				_("type").innerHTML += '<option>'+uscanada[i]+'</option>';
			}
			shippingid = '2';
		}
		else if (y == 'Europe') {
			_("type").innerHTML = '';
			for (var i = 0; i < europe.length; i++) {
				_("type").innerHTML += '<option>'+ europe[i]+'</option>';
			}
			shippingid = '3';
		}
		else {
			_("type").innerHTML = '';
			for (var i = 0; i < other.length; i++) {
				_("type").innerHTML += '<option>'+other[i]+'</option>';
			}
			shippingid = '4';
		}
	}
}
_("uporders").onclick = function(){ //Serves the purpose of updating the order shipping changes
	nation = _("nation").value;
	type = _("type").value;
	var xhttp;
    	if (XMLHttpRequest) {
    		xhttp = new XMLHttpRequest();
    	}
    	else {
    		xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    	}
    	xhttp.onreadystatechange = function() {
    		if (this.readyState == 4 && this.status == 200) {
                    err("Successfully Updated!");
    		}
    	}
    	xhttp.open('POST','https://www.247naijaforum.com/ecommerce/settings.php?id='+ id +'&shippingid='+shippingid+'&nation='+nation+'&type='+type,true);
    	xhttp.send();
}
