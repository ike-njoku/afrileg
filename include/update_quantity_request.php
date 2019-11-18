<?php 
	// this page processes the  request to update the quantity of products the customer is purchasing;  This page is called by the cart page and reflects its results in the inputs of each row in the cart
?>

<?php session_start();?>
<?php include("connect.php");?>

<?php 
	if (isset($_SESSION['id'])) {
		$customer_id = $_SESSION['id'];
	}
?>

<?php 
	// get the product qantity from the form
	if (isset($_GET['qty']) and isset($_GET['product_id'])) {
		$quantity = $_GET['qty'];
		$product_id = $_GET['product_id'];
	

		// create an array or list of acceptable characters
		// split the input ie quantity
		// if any of the characters contained in the  $quantriry is not found in the 
		// unacceptable characters, return.
 
		$acceptable_input = array(1,2,3,4,5,6,7,8,9);

		$a = str_split($quantity);#split the $quantity variable

		foreach ($a as  $character_) {
			// check if each element is in the list of acceptable input
			if (in_array($character_, $acceptable_input)) {

				//check if the quantity of products that the customer wants to buy is 
				// greater thatn the inventory;
				$get_product = mysqli_query($config,"select * from products where id='$product_id' ");
				$product = mysqli_fetch_assoc($get_product);
				if ($product['inventory']<1) {
					echo "out of stock";
				}

				// update the cart
				$update_cart = mysqli_query($config,"update cart set quantity='$quantity' where customer_id='$customer_id' and purchased='0' and product_id='$product_id' ");

				// give out the output of the operation
				$get_new_quantity = mysqli_query($config,"select * from cart where customer_id ='$customer_id' and product_id='$product_id' and purchased='0' ");
				$cart = mysqli_fetch_assoc($get_new_quantity);
				

			}else{echo "invalid input"; return;}
		}

		echo $cart['quantity'];

	}

?>