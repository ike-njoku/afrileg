<?php include("include/header.php");
	// check if the customer is logged in or the person is a guest
	$cusid="";
	if (isset($_SESSION['id'])) {
		$cusid = $_SESSION['id'];
		$customer_type = "customer";
		$qry = mysqli_query($config,"select * from customers where id ='$cusid' " );
		$customer = mysqli_fetch_assoc($qry);
	}else{
		// the person is not a registered customer
		// get the cookie id

		$guest_id = $_COOKIE['guest_id'];
		$cusid = $guest_id;
		$customer_id = $guest_id;
		$customer_type = "guest";
	}	
?>
<?php 
// first, you can only access this page by referal
?>
<section class="py-5"></section>
<div class="container-fluid">
	<div class="row">
		<div class="col-12 text-center">
			<?php 
				// pre declear the "message" variable that is going to be the message conveyed per page
				$message ="";
				// make the image to display into a variable too
				$img_displayed = "";

				// /get the referring url... if there is none, redirect to the indexpage.

				if (isset($_SERVER['HTTP_REFERER'])) {
					// get the referring url
					$referer_url = $_SERVER['HTTP_REFERER'];

					// the case scenerios:
					/* if the person  funded their wallet*/
					/* if the person changed their password*/
					/* if the person bought a product>>>>>>>> i: paid with cart. ii: paid from wallet */


					/*password change */
					if ($referer_url == "https://afrileg.herokuapp.com/change_password.php") {
						// these are editable later
						$img_displayed ="<img src='images/tick-loop-1.gif' ><br> ";
						$message ="Your Password has been changed successfully. <br> Click <a href='dashboard.php'> here </a> to retur to your dashboard ";
						
						// display the image and the message:
					
						return;

						// close the page
					}


					/*funded wallet*/
					if ($referer_url =="https://afrileg.herokuapp.com/fund_wallet.php") {

						// check if the person just funded his wallet
						if (isset($_GET['mthd'])) {
							// check the refering page

							
							if($_GET['mthd']="fund_wallet")
							{	
								// image_to_be_displayed
								$img_displayed ="<img src='images/tick-loop-1.gif' ><br> ";

								// define new balance to be zero
								$new_balance = 0;					

								// update the user's wallet balance
								$get_amount_funded= mysqli_query($config,"select * from fund_wallet where customer_id='$customer_id' and paid='0' ");
								if (mysqli_num_rows($get_amount_funded)<1) { 
									// check for foul play
									header("location:fund_wallet.php");return;
								}
								$amount_funded = mysqli_fetch_assoc($get_amount_funded);
								$funded_amount = $amount_funded['amount'];


								// get the customer's current wallet balance
								$get_current_balance = mysqli_query($config,"select * from wallet where customer_id ='$customer_id' ");

						

									$current_balance = mysqli_fetch_assoc($get_current_balance); 
									$wallet_balance = $current_balance['amount'];

									$new_balance = $wallet_balance + $funded_amount;
									
									// update the persons wallet balance with the amount-funded
									$update_wallet_balance = mysqli_query($config,"update wallet set amount ='$new_balance' where customer_id='$customer_id' ");
									if (mysqli_affected_rows($config)>0) {
										// change "paid from 0 to 1 in the fund_wallet table "

										$update_fund_wallet_table = mysqli_query($config,"update fund_wallet set paid='1', regdate = NOW() where customer_id ='$customer_id' and paid='0' ");
										if (mysqli_affected_rows($config)>0) {
											// new balance
											$new_balance = $wallet_balance + $funded_amount;
											$message =  "your new wallet balance is : NGN $new_balance";

											
									
										}else{
											$message = "we are currently experiencing a server-side lag. Please contace our team for help";
										}

									}else{
										$update_fund_wallet_table = mysqli_query($config,"update fund_wallet set paid='1', regdate =NOW() where customer_id ='$customer_id' and paid='0' ");
										if (mysqli_affected_rows($config)>0) {
											// new balance
											$new_balance = $wallet_balance + $funded_amount;
											$message = "your new wallet balance is : NGN $new_balance";
											
										}
										
									}
								
								
							}
						}else{
							header("location:index.php");
							return;
						}
							
					/*fund wallet ends*/ 
					}


					/* if the person bought a product*/

					if($referer_url =="https://afrileg.herokuapp.com/checkout.php")
					{	
						// avoid double entry and generating invalid tracking id
						$wallet_balance=0;
						// select products from cart
						$get_products = mysqli_query($config,"select * from cart where customer_id = '$customer_id' and customer_type='$customer_type' and purchased ='0' ");
						if (mysqli_num_rows($get_products)) {
							$cart_total =0;
							while($cart = mysqli_fetch_array($get_products)){
								$quantity =$cart['quantity'];
								$price = $cart['product_price'];
								$row_total = $quantity * $price;
								
								$cart_total = $cart_total + $row_total;

							}
							// initialise the value of the coupon to zero, that is, if there is a coupon
							$coupon_value=0;
							$shipping_fee=0.34;

							$grand_total= ($cart_total-$coupon_value + $shipping_fee);

						} else {header("location:shop.php");return;}

						// initialize the referer_id to be zero for non customers and customers that were not refered...
						// if a customer was referred, his referer id has a value
						$referer_id =0;

						// define what image to display
						$img_displayed ="<img src='images/tick-loop-1.gif' ><br> ";


						// avoid double entry ie, return if the cart is empty
						$get_products = mysqli_query($config,"select * from cart where customer_id = '$customer_id' and purchased ='0' and customer_type='$customer_type'");
						if (mysqli_num_rows($get_products)) {
							$cart_total =0;
							while($cart = mysqli_fetch_array($get_products)){
								$quantity =$cart['quantity'];
								$price = $cart['product_price'];
								$row_total = $quantity * $price;
								
								$cart_total = $cart_total + $row_total;
								/*if the person paid from their wallet*/

								// check the person's method of payment
								if(isset($_GET['mtd']))
								{
									// check if the person is paying from their wallet;
									if($_GET['mtd']="wallet")
									{	

										$coupon_value=0;
										$shipping_fee=0.34;
										$get_wallet_balance = mysqli_query($config,"select * from wallet where customer_id ='$customer_id' ");

										if(mysqli_num_rows($get_wallet_balance))
										{
											$wallet = mysqli_fetch_assoc($get_wallet_balance);
											$wallet_balance = $wallet['amount'];

											$grand_total= ($cart_total-$coupon_value +$shipping_fee);
											$new_wallet_balance = $wallet_balance - $grand_total;
											// update the wallet after subtracting waht the person has paid 
											$update_wallet = mysqli_query($config, "update wallet set amount ='$new_wallet_balance' where customer_id ='$customer_id' ");
										}

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

						$check_if_first_purchase = mysqli_query($config,"select * from orders where customer_id='$customer_id' and customer_type ='$customer_type' ");
						if (mysqli_num_rows($check_if_first_purchase)<1) { #ie if this is the customer's first purchase
							

							$referer_bonus = (5/100)* $cart_total;
							// give the referer the referal bonus

							// first check if the referer is already in the wallet

							// if a customer is in session:
							if(isset($_SESSION['id'])){
								$get_referer_id = mysqli_query($config,"select * from customers where id ='$customer_id'");
								if (mysqli_num_rows($get_referer_id)) {
									$customer = mysqli_fetch_assoc($get_referer_id);
									$referer_id = $customer['referer_id'];
									
								}
							}

							if(($referer_id >0) or (!empty($referer_id)))
							{

								$referer_wallet_check = mysqli_query($config,"select * from wallet where customer_id ='$referer_id' ");

								if (mysqli_num_rows($referer_wallet_check)>0) { #ie the referer already has money in his wallet
									
									// add the referer bonus to what is already in the wallet
									$update_referer_wallet = mysqli_query($config,"update wallet set amount = (amount + $referer_bonus) where customer_id ='$referer_id' ");
								}else{

									//ie if the referer is new to the wallet system, insert his name and give him referer_bonus
									$insert_referer = mysqli_query($config,"insert into wallet(customer_id,amount) values('$referer_id','$referer_bonus') ");

										

								}
							}
						}

							// give coupons if the person is a customer
							if(isset($_SESSION['id']))
							{
								$coupon =0;
								if ($cart_total>=12000) {

									$coupon_code = crc32(rand(1,80000998));
									$coupon_value = 1000;

									// check if the customer has any unused coupon
									$get_coupon = mysqli_query($config,"select * from coupons where customer_id='$customer_id' and event='purchase' and used='0'");
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
							}
						}
						$user = '';
						// give allowance for people who are not registered customers to buy
						if(isset($_SESSION['id'])){$customer_id = $_SESSION['id'];}
						else{$customer_id = $guest_id; $customer_type = "guest";}


						/*
						step one: insert customer_id into 'orders' table as well as the time the transaction was completed
						step two: select this particular entry and make the make the order id into an md5 string and call it transaction id
						update cart: set transaction_id = 'transaction_id' where customer_id = customer_id and purchased != 0

						*/

							// make an entry into the orders database with the time of transaction and the user or customer who purchased products
							$insert_order = mysqli_query($config,"insert into orders(customer_id,regdate,customer_type) values('$customer_id',NOW() ,'$customer_type'  )");
							

							// get the order_id
							$get_order_id =mysqli_query($config,"select * from orders where customer_id='$customer_id' and regdate=NOW() and customer_type ='$customer_type' ");
							$order = mysqli_fetch_assoc($get_order_id);
							$tracking_id = crc32($order['id']);
							

							// update cart to set 'purchased' and tracking_id
							mysqli_query($config,"update cart set tracking_id='$tracking_id',purchased='1' where customer_id='$customer_id' and purchased='0' and customer_type ='$customer_type' ");

							//add the generated tracking id to the orders table
							$add_tracking_id = mysqli_query($config,"update orders set tracking_id='$tracking_id' where customer_id='$customer_id' and regdate='0' and customer_type ='$customer_type' ");

							// update the inventory of each product:
							$select_cart_products = mysqli_query($config,"select * from cart where customer_id='$customer_id' and tracking_id='$tracking_id' and customer_type ='$customer_type' ");
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

						//end of product purchase 
						}					
										
					}	

				else{
					header("location:index.php");
					return;
				}

				// end of php scripts
			?>

			<?php 

				// display output
				echo $img_displayed;
				echo $message; 

				// if the customer purchased a product
				if (isset($tracking_id)) 
				{	echo "Your Purchase was successful<hr> <br> Your tracking id is: <br>";
					echo $tracking_id;
					echo "<hr>";
				}
				
			?>

		</div>
	</div>
</div>
<div class="fixed-bottom">
	<?php include("include/footer.php");?>
</div>