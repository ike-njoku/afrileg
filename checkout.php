<?php include("include/header.php");?>
<?php 
	if (isset($_SESSION['id'])) {
		$customer_id = $_SESSION['id'];
		$customer_type = 'customer';
	}else{
		$customer_id = $_COOKIE['guest_id'];
		$customer_type ='guest';
	}
?>


<section class="py-5" ></section>
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
		$coupon_value=0;
		$shipping_fee=0.34;

		$grand_total= ($cart_total-$coupon_value + $shipping_fee);

	} else {header("location:index.php");}

	// subtract the grand total from persons wallet
	// tell the customer how much will be left in their wallet if they make that payment
	$new_wallet_balance = $wallet_balance - $grand_total;
?>


<?php 
	// esesntially, what we are trying to do here is:
	// if the person is a registered customer, check if there is a delivery address... if so, update the person's delivery details to be this new one
	
	// if the person is not a registered customer :
		// check if the person's address is already there. if it is not, insert the address. else, change it


	//check if there is a registered address for the customer 
	$check_delivery_address = mysqli_query($config,"select * from delivery_details where customer_id ='$customer_id' and customer_type ='$customer_type' ");
	// if such a row exiss, we are gonna wanna update that information
	// there's an address, we will echo this later in the input form value
	$customer_address = mysqli_fetch_assoc($check_delivery_address);
	if(isset($_POST['submit'])){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		$moobile = $_POST['mobile'];
		$zip = $_POST['zip'];
		$country = $_POST['country'];
		$city = $_POST['city'];
		$mobile = $_POST['mobile'];

		// coupon
		$coupon = $_POST['coupon'];
	


		// make the variables above into an array and loop through them
		$input_fields = array("$firstname","$lastname","$email","$address","$mobile","$country","$city","$mobile");

		// validate each input field to make sure that the fields are not empty
		for ($input_value=0; $input_value < count($input_fields) ; $input_value++) { 
			if (strlen($input_fields[$input_value]) < 2) {
				// redirect to the checkout page
			 	header("location:checkout.php?incomplete_form");
			 	break;
		 	}
		}
	 
	}	
	

	// checck if the person submitted the form
	if (isset($_POST['submit'])) {

		// here we are going to validate the coupon that the person used
		if (strlen($coupon)>0) {
			$get_coupon_used = mysqli_query($config,"select * from coupons where code ='$coupon' and customer_id ='$customer_id' and customer_type ='$customer_type' and used='0' and tracking_id='0'");
			if (mysqli_num_rows($get_coupon_used)) {
				echo "coupon found <br>";
				$coupon_used = mysqli_fetch_assoc($get_coupon_used);

				// update the coupon value of used to 1... this can be undone if the customer wants to remove the coupon in thr confirm order page
				
				$coupon_update = mysqli_query($config,"update coupons set used='1' where customer_id ='$customer_id' and customer_type ='$customer_type' and code ='$coupon' and used='0' and tracking_id='0' ");				
				if ($coupon_update) {
					echo "coupon updated";
					header("location:confirm_order.php");
				}else{echo "coupon can not be used";}
			}
		}

		if (mysqli_num_rows($check_delivery_address)>0) {

			
			// update delivery details
			$update_delivery_details = mysqli_query($config,"update delivery_details set firstname ='$firstname' , lastname ='$lastname' , email ='$email' , city='$city' , mobile='$mobile' , country='$country' , customer_type ='$customer_type' , customer_id ='$customer_id' , zip ='$zip' where customer_type ='$customer_type' and customer_id ='$customer_id' ");
			if ($update_delivery_details) {
			 	echo "successfully updated delivery details";
			 	 header("location:confirm_order.php");
			 } else{echo "unsuccessful";}

			// send the new delivery address to the delivery table incase the customer changes his address

			 // when the customer completes the purchase, on the success page, we will copy the new address into the orders table
		}else{
			// insert the address into the database
			$insert_address = mysqli_query($config,"insert into delivery_details(customer_id , customer_type , firstname , lastname , email , address , mobile , country , city) values('$customer_id' , '$customer_type', '$firstname', '$lastname', '$email', '$address', '$mobile', '$country','$city') ");
			if ($insert_address) {
				echo "successfully created";
				 header("location:confirm_order.php");
				// on the success page, transfer the address to the address column of the order table
			}else{echo "unable to create entry";}
		}
	}
	
?>
<form method="post">
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
						 	Shipping costs are calculated based on information from your delivery details
						 </p>
						 <hr>
					</div>
					 <div>
					 	Cart Total: <b>NGN</b> <?php echo $cart_total;?>
					 </div>
					 <hr>
					 <div>
					 	
					 		<input class="form-control mb-2" type="text" id="coupon" name="coupon" placeholder="Enter coupon code"> 
					
					 	<div id="get_coupon_response"></div>
					 </div>
					 
					 <div class="">
					 	<hr>
					 	Delivery Fee: <?php echo $shipping_fee;?>
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
					
						<div class="row">
							<div class="col-6">
								<label for="firstname" > First Name</label>
									<input class="form-control" type="text" name="firstname" value="<?php if(empty($customer_address['firstname'])){echo"";}else {echo $customer_address['firstname'];}?>" required>	
							</div>
							<div class="col-6">
								<label for="lastname"> Last Name </label>
								<input class="form-control" type="text" name="lastname" value="<?php if(empty($customer_address['lastname'])){echo "";} else{ echo $customer_address['lastname'];}?>"required>			
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<label for="mobile">Mobile</label>
								<input class="form-control" type="text" name="mobile" value="<?php if(empty($customer_address['mobile'])){ echo "";}else {echo $customer_address['mobile'];}?>"required>
							</div>
							<div class="col-6">
								<label for="email"> Email</label>
								<input class="form-control" type="email" name="email" required value="<?php if(empty($customer_address['email'])){echo "";}else {echo $customer_address['email'];}?>" required>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<label for="address">Address</label>
								<textarea class="form-control" type="text" name="address" value="<?php if(empty($customer_address['address'])){echo "";}else {echo $customer_address['address'];}?>"required></textarea>
							</div>
		
						</div>
						<div class="row">
							<div class="col-6">
								<label for="city" >City</label>
								<input class="form-control" type="text" name="city" value="<?php if(empty($customer_address['city'])){echo "";}else{ echo $customer_address['city'];}?>"required>
							</div>
							<div class="col-6">
								<label for="zip" >Zip </label>
								<input class="form-control" type="text" name="zip" value="<?php if(empty($customer_address['zip'])){echo"";} else {echo $customer_address['zip'];}?>" required>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<label for="state" >State</label>
								<select value="<?php if(empty($customer_address['state'])){echo "";} else{ echo $customer_address['state'];}?>" name="state" class="form-control" required>
									<option  class="form-control">
										Abuja
									</option>
								</select>
							</div>

							<div class="col-6">
								<label for="country" >Country</label>
								<select name="country" class="form-control" required>
									<option value="country" class="form-control">
										Nigeria
									</option>
									<option value="<?php if(empty($customer_address['country'])){echo "";}else {echo $customer_address['country'];}?>" class="form-control">
										Ghana
									</option>
								</select>
							</div>
						</div>			
				</div>
				<div class="card-footer text-right">
					<button class="btn btn-small btn-info" type="submit" name="submit">Proceed</button>
				</div>	
				
		</div>
		<!-- end of delivery details -->
	</div>
</div>
</form>






<?php include("include/footer.php");?>
							
<?php 
?> 

<script type="text/javascript">
	// ajax call to find and load
	var coupon_input = document.getElementById('coupon');
	coupon_input.addEventListener("keyup",function(){

		// send request
		var coupon_request;
		if (window.XMLHttpRequest){coupon_request = new XMLHttpRequest(); } else{coupon_request =new ActiveXObject("Microsoft.XMLHTTP"); }
		coupon_request.open("GET","include/find_coupon.php?key_="+coupon_input.value, true);
		coupon_request.onload = function(){
			document.getElementById("get_coupon_response").innerHTML = coupon_request.responseText;
			console.log(coupon_input.value); 
		}
		coupon_request.send();
	})
	
</script> 