<?php 	session_start();
	include("connect.php");
	// select customer
	if (isset($_SESSION['id'])) {
		$cusid = $_SESSION['id'];
		if($customer_select = mysqli_query($config,"select * from customers where id = '$cusid' " ))
			{
				$customer = mysqli_fetch_assoc($customer_select);

			}
		
			// get the data to be deleted from the cart
			if (isset($_GET['customer_id']) and (isset($_GET['product_id'])) ) {
				$customer_id = $_GET['customer_id'];
				$product_id = $_GET['product_id'];

				// find the corresponding data in the database and delete it
				if ($delete_product = mysqli_query($config, "delete  from cart where customer_id ='$customer_id' and product_id = '$product_id' ")) {
					echo "successful";
				}else{
					echo " please try again later";
			}

		}

		// update the contents of the cart
		
	}		
		

?>

<?php
	// this page deletes whole rows of items from the cart on request and returns 
	// the result to the header (header.php) where id = "cart_items"
?>