<?php
	session_start();
	include("connect.php");

	if (isset($_SESSION['id'])) {
		$customer_id = $_SESSION['id'];
		$customer_type ='customer';
	}else{
		$customer_id = $_COOKIE['guest_id'];
		$customer_type = "guest";
	}
	 	// get the variables
		
		if (isset($_GET['key_'])) {
			
			$key_ = $_GET['key_'];

			if ($key_ =="" or empty($key_)) {
				
				return;
			}

			$get_coupon = mysqli_query($config,"select * from coupons where customer_id='$customer_id' and used='0' and code='$key_' and customer_type ='$customer_type' ");
			if(mysqli_num_rows($get_coupon))
				{
				$coupon = mysqli_fetch_assoc($get_coupon);

				echo '<b>-N</b>'.$coupon['value'];
			}else{
				echo "<span class ='small'>...coupon not found</span>";
			}
			
			
	
		}
	
?>