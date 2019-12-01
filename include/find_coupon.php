<?php
	session_start();
	include("connect.php");

	if (isset($_SESSION['id'])) {
		$customer_id = $_SESSION['id'];


	 	// get the variables
		
		if (isset($_GET['key_'])) {
			
			$key_ = $_GET['key_'];

			if ($key_ =="" or empty($key_)) {
				
				return;
			}

			$get_coupon = mysqli_query($config,"select * from coupons where customer_id='$customer_id' and used='0' and code='$key_' ");
			$coupon = mysqli_fetch_assoc($get_coupon);

			echo '<b>-N</b>'.$coupon['value'];
			
	
		}
	}
?>