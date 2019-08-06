<?php
	if (isset($_POST['emailaddress'])) {
		$email = $_POST['emailaddress'];
		$pass = $_POST['pass'];
		$signin = new SignIn($_POST['emailaddress'],$_POST['pass']);
	}
	if (isset($_POST['email'])) {
		$email = $_POST['email'];
		$pass = $_POST['password'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$signup = new SignUp($email,$pass,$firstname,$lastname);
	}
	if (isset($_GET['offset'])) {
		$off = $_GET['offset'];
		$cat = $_GET['cat'];
		$dep = $_GET['dep'];
		$fetchsales =  new FetchSales($off,$cat,$dep);
	}
	if (isset($_GET['logout'])) {
		@session_start();
		unset($_SESSION['account_email']);
		header('location:https://247naijaforum.com/ecommerce/index.php');
	}
	if (isset($_GET['id'])) {
		$addtocart = new AddToCart($_GET['id']);
	}
	if (isset($_GET['amt'])) {
		$fetchprice = new FetchPrice($_GET['amt']);
	}
	if (isset($_GET['remid'])) {
		$addtocart = new RemoveFromCart($_GET['remid']);	
	}
	if (isset($_GET['arr'])) {
		$printarr = new PrintArray($_GET['arr']);
	}
	if (isset($_GET['paid'])) {
		$pay = $_GET['paid'];
		$ref = $_GET['ref'];
		$success = new SuccessfulPayment($pay,$ref);
	}
	if (isset($_GET['shippingid'])) {
		$id = $_GET['id'];
		$shippingid = $_GET['shippingid'];
		$type= $_GET['type'];
		$nation = $_GET['nation'];
		$setorders = new ShippingUpdate($id,$nation,$shippingid,$type);
	}
	if (isset($_GET['qstr'])){
		$qstr = new SearchProduct($_GET['qstr']);
	}
?>