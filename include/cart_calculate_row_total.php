<?php 
	session_start();
	include("connect.php");
	// this page calclates the row total for each product each time the quantity to be purchased is updated in the cart
?>

<?php 
	// get customer_id
	if (isset($_SESSION['id'])) {
		$customer_id = $_SESSION['id'];
	}
?>

<?php
$select_product = mysqli_query($config,"select * from cart where customer_id = '$customer_id' and purchased='0' " );
	if(mysqli_num_rows($select_product) )
	{
		while ($product = mysqli_fetch_array($select_product))
			{ 	$product_id = $product['product_id']; #get the product id of the product
				$quantity = $product['quantity'];
				$row_total = $product['product_price'] * $product['quantity'];
				// cart total
				

				// get the product's image from the products table
				$get_product = mysqli_query($config,"select * from products where id = '$product_id' " );
				$g_product = mysqli_fetch_array($get_product);
				
			}

		echo $row_total;
	}

?>