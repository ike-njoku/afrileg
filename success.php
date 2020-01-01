<?php /*
	
	//  if the refering page does not contain rave.flutterwave (name of the billing service), redirect to  index
	if (isset($_SERVER['HTTP_REFERER'])and ($_SERVER['HTTP_REFERER']=="http://localhost/afrileg.com/checkout.php" or $_SERVER['HTTP_REFERER']=="http://afrileg.herokuapp.com/checkout.php")) {
		echo "";
	}else{
		header("location:index.php");
		return;
	}
	*/
	
?>

<?php include("include/header.php");?>
<section class="py-5"></section>
<div class="container">
	<div  class="text-center py-5">
		<img src="images/tick-loop-1.gif"><br><br>
		<h6>Your Order Was Successful. <br>
		please click <a href="shop.php">here </a> to return to our shop</h6>

<?php 

	// avoid double entry ie, return if the cart is empty
	$get_products = mysqli_query($config,"select * from cart where customer_id = '$customer_id' and purchased ='0' ");
	if (mysqli_num_rows($get_products)) {
		$cart_total =0;
		while($cart = mysqli_fetch_array($get_products)){
			$quantity =$cart['quantity'];
			$price = $cart['product_price'];
			$row_total = $quantity * $price;
			
			$cart_total = $cart_total + $row_total;

			// check the person's method of payment
			if(isset($_GET['mtd']))
			{
				// check if the person is paying from their wallet;
				if($_GET['mtd']="wallet")
				{
					$coupon_value=0;
					$shipping_fee=0.34;
					$get_wallet_balance = mysqli_query($config,"select * from wallet where customer_id ='$customer_id' " );
					$wallet = mysqli_fetch_assoc($get_wallet_balance);
					$wallet_balance = $wallet['amount'];

					$grand_total= ($cart_total-$coupon_value  +$shipping_fee);
					$new_wallet_balance = $wallet_balance - $grand_total;
					// update the wallet after subtracting waht the person has paid 
					$update_wallet = mysqli_query($config, "update wallet set amount ='$new_wallet_balance' where customer_id ='$customer_id' ");

				}
			}


		}

		/*
			let store credits be 1% of $cart_total. for each check out, the person earns 
			1 percent of the cart tota as store credits which can be used to purchase stuff 
			from the company without actually paying money
		*/


	// check if the customer is in the orders table. if the customer is there,ignore it
	// else,  it means that the customer has never bought anything before and this is his first purchase. so we will now give the referer 5% of the customer's first purchase

	$check_if_first_purchase = mysqli_query($config,"select * from orders where customer_id='$customer_id' ");
	if (mysqli_num_rows($check_if_first_purchase)<1) { #ie if this is the customer's first purchase
		

		$referer_bonus = (5/100)* $cart_total;
		// give the referer the referal bonus2

		// first check if the referer is already in the wallet

		$referer_id = $customer['referer_id'];

		$referer_wallet_check = mysqli_query($config,"select * from wallet where customer_id ='$referer_id' ");

		if (mysqli_num_rows($referer_wallet_check)>0) { #ie the referer already has money in his wallet
			
			// add the referer bonus to what is already in the wallet
			$update_referer_wallet = mysqli_query($config,"update wallet set amount = (amount + $referer_bonus) where customer_id ='$referer_id' ");
		}else{

			//ie if the referer is new to the wallet system, insert his name and give him referer_bonus
			$insert_referer = mysqli_query($config,"insert into wallet(customer_id,amount) values('$referer_id','$referer_bonus') ");

				

		}
		
	}

		// coupons
		$coupon =0;
		if ($cart_total>=12000) {

			$coupon_code = crc32(rand(1,80000998));
			$coupon_value = 1000;

			// check if the customer has any unused coupon
			$get_coupon = mysqli_query($config,"select * from coupons where customer_id='$customer_id' and event='purchase' and used='0' ");
			if (mysqli_num_rows($get_coupon)) {
				echo'';
			}else#insert give the person the coupon
			{
				$give_coupon = mysqli_query($config,"insert into coupons(customer_id,event,value,code) values('$customer_id','purchase','$coupon_value','$coupon_code') ");
				if ($give_coupon) {
					echo 'You have been awarded a N '.$coupon_value.' click <a href="coupons.php"> here to view</a> ';
				}
			}
		}

	}else{return;}

	$user = '';
	// give allowance for people who are not registered customers to buy
	if(isset($_SESSION['id'])){$user = $_SESSION['id'];}


	/*
	step one: insert customer_id into 'orders' table as well as the time the transaction was completed
	step two: select this particular entry and make the make the order id into an md5 string and call it transaction id
	update cart: set transaction_id = 'transaction_id' where customer_id = customer_id and purchased != 0

	*/


		// make an entry into the orders database with the time of transaction and the user or customer who purchased products
		mysqli_query($config,"insert into orders(customer_id,regdate) values('$user',NOW() ) ");

		// get the order_id
		$get_order_id =mysqli_query($config,"select * from orders where customer_id='$user' and regdate=NOW() ");
		$order = mysqli_fetch_assoc($get_order_id);
		$tracking_id = crc32($order['id']);


		// update cart to set 'purchased' and tracking_id
		mysqli_query($config,"update cart set tracking_id='$tracking_id',purchased='1' where customer_id='$user' and purchased='0' ");

		//add the generated tracking id to the orders table
		$add_tracking_id = mysqli_query($config,"update orders set tracking_id='$tracking_id' where customer_id='$user' and regdate='0' ");

		// update the inventory of each product:
		$select_cart_products = mysqli_query($config,"select * from cart where customer_id='$user' and tracking_id='$tracking_id' ");
		if (mysqli_num_rows($select_cart_products)) {
			echo"";
			while($cart_products = mysqli_fetch_array($select_cart_products))
				{	
					$old_quantity =$cart_products['quantity']; #the quantity of the products that the customer ordered
					$cart_product_id = $cart_products['product_id'];#reassign a variable to the id of the product in the cart

					// select the particular product from the products database
					$select_product_from_products_db = mysqli_query($config,"select * from products where id = '$cart_product_id' ");
					if (mysqli_num_rows($select_product_from_products_db)) {
						
						$update_products_quantity = mysqli_query($config,"update products set inventory = (inventory - $old_quantity) where id = '$cart_product_id' ");
						if ($update_products_quantity) {
							echo '';
							// if the update doesnt work, update it again
						}else{$update_products_quantity;}
					}



					
				}



		}

	
?>
		<div> 
			<hr>
			Your Tracking ID is:<br> <b><?php echo $tracking_id; ?></b><br>
			<small>
				This can be used to check the delivery stats of your order.
			</small>
			
			<hr>
		</div>

	</div>
</div>
 
<div class="fixed-bottom">
	<?php include("include/footer.php");?>
</div>
