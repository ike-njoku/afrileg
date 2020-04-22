<?php 
	session_start();
	include("connect.php");
?>

<?php 
	// check if the customer is logged in or the person is a guest
	if (isset($_SESSION['id'])) {
		$customer_id = $_SESSION['id'];
		$customer_type = "customer";
		
	}else{
		// the person is not a registered customer
		// get the cookie id

		$guest_id = $_COOKIE['guest_id'];
		$customer_id = $guest_id;
		$customer_type = "guest";
	}	
?>

<?php 
 // find coupon to remove 
	$find_coupon = mysqli_query($config,"select * from coupons where customer_id ='$customer_id' and customer_type ='$customer_type' and used='1' and tracking_id='0'");
	if (mysqli_num_rows($find_coupon)) {
		echo "coupon was found";
		// changed the value of "used" to zero
		$update_query = mysqli_query($config,"update coupons set used='0' where customer_id ='$customer_id' and customer_type ='$customer_type' and used='1' and tracking_id='0'");

		if ($update_query) {
			echo "coupon removed";
		}

	}else{echo "coupon could not be retrieved";}

?>