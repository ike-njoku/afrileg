<?php include("include/header.php");?>
<?php

	
	// select products from cart
	$get_products = mysqli_query($config,"select * from cart where customer_id = '$customer_id' and purchased ='0' ");
	if (mysqli_num_rows($get_products)) {
		$cart_total =0;
		while($cart = mysqli_fetch_array($get_products)){
			$quantity =$cart['quantity'];
			$price = $cart['product_price'];
			$row_total = $quantity * $price;
			
			$cart_total = $cart_total + $row_total;

		}
		// initialise the value of the coupon to zero, that is , if there is a coupon
		$coupon_value=0;
		$shipping_fee=0;

		$grand_total= ($cart_total-$coupon_value  +$shipping_fee);

	}else{header("location:shop.php");}
?>

<section class="py-5" ></section>
<div class="container-fluid">
	<div class="row">	
		<!-- order summary -->
		<div class="col-md-4 col-lg-3 mb-4">
			<div class="card">
				<div class="card-header py-5">
					<h1>Order Summary</h1>
				</div>
				<div class="card-body">
					<div>
						<p>
						 	Shipping and additional costs are calculated based on the values you have entered.
						 </p>
						 <hr>
					</div>
					 <div>
					 	Cart Total: <b>NGN</b> <?php echo $cart_total;?>
					 </div>
					 <hr>
					 <div>
					 	<form method="post">
					 		<input class="form-control mb-2" type="text" id="coupon" name="coupon" placeholder="Enter coupon code"> 
					 	</form>
					 	<div id="get_coupon_response"></div>
					 </div>
					 
					 <div class="">
					 	<hr>
					 	Delivery Fee:
					 </div>
					 <hr>
					 <div class="">
					 	Grand Total: <b>NGN</b> <?php echo $grand_total;?>
					 </div>
				</div>
			</div>
		</div>


		<!-- order suary ends -->
		<div class="col-md-6 mb-4">
			<div class="card">
				<div class="py-5 card-header badge-info">
					<h1>Delivery Details <i class="ti-location-pin "></i> </h1>
				</div>
				<div class="card-body">
					<form>
						<div class="row">
							<div class="col-md-6">
								<label for="firstname" > First Name</label>
									<input class="form-control" type="text" name="firstname">	
							</div>
							<div class="col-md-6">
								<label for="lastname"> Last Name </label>
								<input class="form-control" type="text" name="lastname">			
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label for="mobile">Mobile</label>
								<input class="form-control" type="text" name="mobile">
							</div>
							<div class="col-md-6">
								<label for="address">Address</label>
								<input class="form-control" type="text" name="address">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label for="city" >City</label>
								<input class="form-control" type="text" name="city">
							</div>
							<div class="col-md-6">
								<label for="state" >Country</label>
								<select name="state" class="form-control">
									<option value="" class="form-control">
										Nigeria
									</option>
									<option value="" class="form-control">
										Ghana
									</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label for="email"> Email</label>
								<input class="form-control" type="email" name="email" required>
							</div>
							<div class="col-md-3">
								<label for="zip" >Zip </label>
								<input class="form-control" type="text" name="zip">
							</div>
							<div class="col-md-3">
								<label for="state" >State</label>
								<select name="state" class="form-control">
									<option value="" class="form-control">
										Abuja
									</option>
								</select>
							</div>
						</div>	
				</div>
				</form>
				<div class="card-footer">
					<div style="float:right;" class="btn-group">
						<a href="cart.php" class="btn btn-secondary btn-outline-secondry">
							back to cart <i class="ti-shopping-cart "></i>
						</a>
							
<form>
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <button class="btn btn-info" type="button" onClick="payWithRave()">Pay Now <i class="ti-wallet"></i> </button>
</form>

<script type="text/javascript">
 	//process the search for coupon
 	document.getElementById("coupon").addEventListener("keyup",function(){
 		var get_coupon;
 		if (window.XMLHttpRequest) {get_coupon = new XMLHttpRequest() ;}else{get_coupon = new ActiveXObject("Microsoft.XMLHTTP");}
 		var key_ = document.getElementById("coupon").value;
 		get_coupon.open("GET","include/find_coupon.php?key_="+key_,true);
 		get_coupon.onreadystatechange = function(){
 			if (get_coupon.status==200 && get_coupon.readyState==4) {document.getElementById("get_coupon_response").innerHTML=get_coupon.responseText; }
 		}
 		get_coupon.send();
 	})
</script>

<script>
    const API_publicKey = "FLWPUBK-d021b72dd1b6caf08bf9df2828dc6666-X";

    function payWithRave() {
        var x = getpaidSetup({
            PBFPubKey: API_publicKey,
            customer_email: "<?php echo $customer['email'];?>",
            amount: <?php echo $grand_total;?>,
            customer_phone: "234099940409",
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
                	window.location.href = "success.php" ;//later, change this to grand-total
                } else {
                    // redirect to a failure page.
                    window.location.href ="failed.php";
                }

                x.close(); // use this to close the modal immediately after payment.
            }
        });
    }
</script>

					</div>
				</div>
					
			</div>
		</div>

		<!-- end of delivery details -->
	</div>
</div>

<?php include("include/footer.php");?>