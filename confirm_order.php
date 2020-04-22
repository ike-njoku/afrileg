<?php include("include/header.php");?>

<?php 
	$amount_in_wallet = 0;
	// get the wallet balance
	$get_wallet = mysqli_query($config,"select * from wallet where customer_id='$customer_id' ");
	if (mysqli_num_rows($get_wallet)) {
		$wallet = mysqli_fetch_assoc($get_wallet);
		$wallet_balance = $wallet['amount'];

		if ($wallet_balance > 0) {
			
			$amount_in_wallet = $wallet_balance;
		}else{
			$amount_in_wallet = "0.00";
		}
	}
?>
<?php	
	// initialise the value of the customer's wallet balance to zero
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
		$coupon_value="0.00";
			// get the coupon
		$get_coupon = mysqli_query($config,"select * from coupons where customer_id ='$customer_id' and customer_type ='$customer_type' and used='1' and tracking_id='0'");
		if (mysqli_num_rows($get_coupon)) {
			$coupon = mysqli_fetch_assoc($get_coupon);
			$coupon_value = $coupon['value'];
		}
		$shipping_fee=0.34;

		$grand_total= ($cart_total-$coupon_value + $shipping_fee);

	} else {header("location:index.php");}

	// subtract the grand total from persons wallet
	// tell the customer how much will be left in their wallet if they make that payment
	$new_wallet_balance = $wallet_balance - $grand_total;
?>
<section class="py-5"></section>
	<div class="container-fluid">
		<div class="row mb-4">
			<div class="col-md-4 mb-4">
				<div class="card">
					<div class="card-header py-5">
						<h1>Order Preview</h1>
						
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-12">
								<?php
								 //get the products in the cart 

								$get_cart_products = mysqli_query($config,"select * from cart where customer_id = '$customer_id' and customer_type ='$customer_type' and purchased='0' ");
								if(mysqli_num_rows($get_cart_products)):
								?>	<div class="row">
									<?php while($cart_product = mysqli_fetch_array($get_cart_products)): $cart_product_id = $cart_product['product_id'];?>
										<?php 
										// get the product from the products table 
										$get_product_detils = mysqli_query($config,"select * from products where id = '$cart_product_id' "); 
										if(mysqli_num_rows($get_product_detils)):?>
												
											<?php while ($product = mysqli_fetch_assoc($get_product_detils)): ?>
												
												<!-- products_details -->
												
													<div class=" col-6 col-sm-4 col-md-3">	
														
														<div class="sm">
															<img height="50" width="50" src="admin/<?php echo $product['image1'];?>"><br>
															<span class="small sm">
																<?php echo $product['name'];?>
															</span>
														</div>
														<div class="sm">
															<div class="sm">
																<span class="small">(
																	<?php echo $cart_product['product_price'];?> x
																	<?php echo $cart_product['quantity'];?>
																)</span>
															</div>
														</div>
													
													</div>

												
											<?php endwhile;?>
												

										<?php endif;?>
									<?php endwhile;?>
									</div>

								<?php endif;?>
							</div>
						</div>

						<div class="row">
							<!-- calculations -->
							<div class="col-12 ">
								<hr>
								<div>
									<b>Cart Total: NGN </b><?php echo $cart_total;?><br>
								</div>
								<div>
									<b>Delivery Fee: NGN </b>  <?php echo $shipping_fee;?> <br>
								</div>
								<?php if(mysqli_num_rows($get_coupon)>0): ?>
								<div id="hide_coupon" class="bg-light p-2">
									<div class="text-right sm">remove coupon <span id="remove_coupon" class="sm  fas fa-times-circle"></span></div>
									<div><b>Coupon: -NGN </b>  <?php echo $coupon_value;?> <br></div>
								</div>
								<?php else:?>
								<div id="show_coupon" class="bg-light p-2">
									<div class="text-right sm"><a href="checkout.php">add coupon <span class="far fa-arrow-alt-circle-left"></span></a></div>
									<div><b>Coupon: -NGN </b>  <?php echo $coupon_value;?> <br></div>
								</div>
								<?php endif;?>
								<hr>
								<div>
									<b>Grand Total: NGN </b><?php echo $grand_total;?><br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- delivery details-->
			<div class="col-md-4 mb-4">
				<div class="card">
					<div class="card-header alert alert-info py-5">
						<b><h1>Delivery Address</h1></b>
					</div>
					<div class="card-body">
						<?php 
							// get the customer's delivery details from the deliverys table
							$get_customer_delivery_details = mysqli_query($config,"select * from delivery_details where customer_id='$customer_id' and customer_type = '$customer_type' ");
						?>
						<?php if(mysqli_num_rows($get_customer_delivery_details)): $customer_address = mysqli_fetch_assoc($get_customer_delivery_details);?>
							<div><b>First Name:</b> <?php echo $customer_address['firstname'] ;?><br></div>
							<div><b>Last Name:</b> <?php echo $customer_address['lastname'] ;?><br></div>
							<div><b>Email:</b> <?php echo $customer_address['email'] ;?> <br></div>
							<div><b>Mobile:</b> <?php echo $customer_address['mobile'] ;?> <br> </div>
							<div><b>Address:</b> <?php echo $customer_address['address'] ;?> <br></div>
							<div><b>City:</b> <?php echo $customer_address['city'] ;?> <br></div> 
							<div><b>Zip:</b> <?php echo $customer_address['zip'];?> <br> </div>
							<div><b>State:</b> <?php echo $customer_address['state']; ?>  <br></div>
							<div><b>Country:</b> <?php echo $customer_address['country'] ;?> <br> </div>
							<?php else: ?>
								<?php header("location:checkout.php"); return;?>
						<?php endif;?>

						<hr>
						<div class="text-right">
							<a class="btn btn-secondary btn-sm" href="checkout.php">edit</a>
						</div>
					</div>
				</div>
			</div>

			<!-- payment -->
			<div class="col-md-4">
				<div class="card">
					<div class="card-header alert badge-info py-5">
						<b><h1>Payment</h1></b>
					</div>
					<div class="card_body">
						<div class="m-2">
							<h5>Here are some important things to note:</h5>
						</div>
						<ol>
							<li><div> You will receive an order confirmation email containing your order tracking id</div></li>
							<li><div>The email will be sent to the email address provided in the delivery form</div></li>
							<li><div>You will receive receipt(s) for your purchase via email </div></li>
							<li><div>You will receive shipment tracking information via the email address povided in your delivery form and the mobile number contained therein</div></li>
						</ol>
					</div>

					<!-- card footer -->
					<div class="card-footer d-flex justify-content-right">
						<div>
							<a class="btn btn-small btn-secondary btn-outline-secondry"  href="cart.php">
								back to shop<i class="ti-shopping-cart "></i>
							</a>
						</div>
						<div style="float:right;" class="btn-group">
							<?php if(isset($_SESSION['id'])): ?>
								<!-- if the person is a registered customer -->
							<button data-toggle="modal" data-target="#payment_modal" class="btn btn-info btn-outline-secondry">
								pay Now
							</button>
							<?php else:?>
								<form>
									<?php 
									// this is the payment method for rave.flutterwave
									?>
								    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
								    <button s class="btn btn-secondary  btn-info" type="button" onClick="payWithRave()">Pay with card <i class="ti-wallet"></i> </button>
								</form>
							<?php endif;?>
							<?php if(isset($_SESSION['id'])): ?>
							<div id="payment_modal" class="modal fade">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<b>Please select a payment Method:</b>
										</div>
										<div class="modal-body">
											<div>
												<div class="lead mb-4">
													<?php echo "your wallet balance is NGN".$amount_in_wallet; ?><br>
												</div>	
												<div style="display: none;" id="confirm_wallet_pay" class="mt-4 mb-4">
													<?php if(($grand_total > $amount_in_wallet) or ($wallet_balance - $grand_total >= 0)):?>
													you do not have enough funds to complete this purchase. please try a different payment method Or click <a href="fund_wallet.php">here</a> to fund your wallet.
													<?php else:?>
														the sum of <b>NGN<?php echo $grand_total;?></b> will be deducted from your wallet. click <a href="success.php?mtd=wallet"> here</a> to confirm.
													<?php endif;?>
												</div>
											</div>
											<div class="row">
												<div class="col d-flex justify-content-left">
													<button id="wallet_pay" class="btn btn-secondary">pay from wallet</button>
													<script type="text/javascript">
														document.getElementById("wallet_pay").addEventListener("click",function(){
															document.getElementById("confirm_wallet_pay").style.display="block";
														})
													</script>
													<form>
														<?php 
														// this is the payment method for rave.flutterwave
														?>
													    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
													    <button s class="btn btn-secondary  btn-info" type="button" onClick="payWithRave()">Pay with card <i class="ti-wallet"></i> </button>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div> 
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<!-- end of payment -->
				</div>
			</div>
		</div>
	</div>

<div class="mt-4">
	<?php include("include/footer.php");?>
</div>

<script>
    const API_publicKey = "FLWPUBK-d021b72dd1b6caf08bf9df2828dc6666-X";

    function payWithRave() {
        var x = getpaidSetup({
            PBFPubKey: API_publicKey,
            customer_email: "<?php echo $customer_address['email'];?>",
            amount: <?php echo $grand_total;?>,
            customer_phone: "<?php echo $customer_address['mobile'];?> ",
            currency: "NGN",
            txref: "rave-123456",
            meta: [{
                metaname: "flightID",
                metavalue: "AP1234"
            }],
            onclose: function() {},
            callback: function(response) {
                var txref = response.tx.txRef; // collect txRef returned and pass to a 					server page to complete status check.
                console.log("This is the response returned after a charge", response);
                if (
                    response.tx.chargeResponseCode == "00" ||
                    response.tx.chargeResponseCode == "0"
                ) {
                    // redirect to a success page
                	window.location.href = "success2.php?mtd=payment" ;//later, change this to grand-total
                } else {
                    // redirect to a failure page.
                    window.location.href ="failed.php";
                }

                x.close(); // use this to close the modal immediately after payment.
            }
        });
    }
    
</script>

<?php if(mysqli_num_rows($get_coupon)):?>
	<script type="text/javascript">
		// remove coupon and reload the page
		var remove_coupon_button = document.getElementById("remove_coupon");
		remove_coupon_button.addEventListener("click",function(){
			var remove_coupon_request;
			if (window.XMLHttpRequest) {remove_coupon_request = new XMLHttpRequest();} else {remove_coupon_request = new ActiveXObject("Microsoft.XMLHttp");}
			remove_coupon_request.open("GET","include/remove_coupon.php",true);
			remove_coupon_request.onload = function(){			
				// hide the div then refresh the page
				document.getElementById("hide_coupon").style.display = "none";
				// reload the page:
				window.location.href="confirm_order.php";
			}
			remove_coupon_request.send();
		})	
	</script>
<?php endif;?>