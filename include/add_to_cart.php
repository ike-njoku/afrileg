<?php session_start();?>
<?php include("connect.php");?>
<?php 
	// check if the customer is logged in
	$cusid="";
	if (isset($_SESSION['id'])) {
		$cusid = $_SESSION['id'];
		$qry = mysqli_query($config,"select * from customers where id ='$cusid' " );
		$customer = mysqli_fetch_assoc($qry);
		
		// check if the data is available and then insert it
		if (isset($_GET['product_id']) and isset($_GET['product_name'])) {

			// get the product details 
			$product_id = $_GET['product_id'];
			$product_name = $_GET['product_name'];
			$product_price = $_GET['product_price'];

			
			// enter data 
			
			// check if the product already exists in the cart with user id. if it does,
			// update the number
			// else, insert it as new data

			$check_cart = mysqli_query($config," select * from cart where customer_id = '$cusid' and product_id='$product_id' and purchased='0' " );
			if (mysqli_num_rows($check_cart)) {
				// update
				if(mysqli_query($config,"update cart set quantity = (quantity + 1) where customer_id = '$cusid' and product_id ='$product_id' and purchased='0' " ))
					{echo '<span class="far fa-check-circle success"></span>';}
				else{echo'<span class="far fa-times-circle success"></span>'; }

			}else{
				// insert
				$insert_ = mysqli_query($config,"insert into cart(customer_id, product_id, product_price ,quantity ) values ('$cusid','$product_id', '$product_price','1' ) " );
				if ($insert_) {
					echo '<span class="far fa-check-circle success"></span>';
				}else{echo '<span class="far fa-times-circle success"></span>';}
			}
		}
		
	} else{echo "log in";}
;?>

<?php
	// notes
	// the pages that use this processor page are the index page and the shop page and view product page. 
	// the result this process is displayed in <a href="cart.php">cart</a> where the span id="cart_items"
	
?>