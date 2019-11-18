<?php 
	session_start();
	include("connect.php"); 
?>

<?php
	// get customer_details
 $cusid = ""; $customer_id = "";
  if (isset($_SESSION['id'])) {
  $cusid = $_SESSION['id'];
  $customer_select = mysqli_query($config,"select * from customers where id='$cusid'");
  $customer = mysqli_fetch_assoc($customer_select);
  $customer_id = $customer['id'];}
?>


<?php 
 	$err =""; # error message for an empty cart
	 $grand_total = 0; #initialise the value of the grand total
	// select products from cart
	$select_product = mysqli_query($config,"select * from cart where customer_id = '$cusid' and purchased = '0' " );
	if(mysqli_num_rows($select_product) and (!empty($_SESSION['id'])) )
	{
		while ($product = mysqli_fetch_array($select_product))
			{ 	$product_id = $product['product_id']; #get the product id of the product
				$quantity = $product['quantity'];
				$row_total = $product['product_price'] * $product['quantity'];
				// grand total
				
				$grand_total += $row_total;	

			}
			echo $grand_total;
	}	

	
?>
 
 <?php 
 	// this processor page calculates calculates the total of all the products in the cart without
 	// refreshing the page, each time a product is deleted from the cart. the results of this page are replaces the total computed by the cart page in the id="display_total" 
 ?>