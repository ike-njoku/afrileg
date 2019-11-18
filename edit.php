<?php include("include/header.php");?>

<?php 
	// update the shipping address

	if (isset($_POST['change_delivery_address'])) {
		
		$firstname;
	}
?>

<?php 
	// change password
	if (isset($_POST['change_password'])) {

		$password_1=$_POST['password_1'];
		$password_2=$_POST['password_2'];

		if ($password_1 == $password_2) {
			
		
			$old_password =md5(md5($_POST['old_password'])) ;
			$new_password = md5(md5($_POST['password_2'])) ;

			// check if password_1 and password_2 are the same before inserting password_2 into db


			// check if the old password is correct and rhymes with the customer_email
			$check_password = mysqli_query($config,"select * from customers where id='$customer_id' and password ='$old_password'");
			if (mysqli_num_rows($check_password)) {
				
				// update the old password to the new password
				$update_password = mysqli_query($config,"update customers set password='$new_password' where id='$customer_id'");
				if (mysqli_affected_rows($config)) {
					$error_message = '<div class="alert alert-info">Your password was successfully updated</div>';
				}else{$error_message= '<div class="alert alert-warning">update unsuccessful</div>';}


			}else{$error_message='<div class="alert alert-warning"> invalid password</div>';}

			
		}else{$error_message='<div class="alert alert-warning">Your passwords do not match. please correct this and retry</div>' ;}
	
	}else{$error_message ="";}

?>


<?php
	// get the customer details from the delivery cart
	$delivery_details = mysqli_query($config, "select * from delivery_details where customer_id = '$customer_id' ");
	$delivery = mysqli_fetch_assoc($delivery_details);
?>

<section class="py-5"></section>
<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-5 mb-4 ">
			<div class="card">
				<div class="card-header alert alert-info text-center">
					<form method="post" class="form-group">
						<a href="#"><img id="display_avatar" height="150" width="150"class="rounded-circle"src="<?php if(empty($customer['avatar'])){echo 'images/avatar.png';}else{echo $customer['avatar'];} ?>"></a>
						<div>
							<hr>
							<input style="display:none;"type="file" name="avatar" value="<?php echo $customer['avatar'] ;?>" >
						</div>
				</div>
					<div class="card-body text-center">
						<div class=" text-left">
							<div class="row">
								<div class="col-md-12 col-lg-6">
									<label class="sr" for="firstname">First Name
										<input value="<?php if(empty($delivery['firstname'])){echo"null";}else{echo $delivery['firstname'];} ;?>" class="form-control" type="text" name="firstname">
									</label>
								</div>
								<div class="col-md-12 col-lg-6">
									<label class="sr" for="lastname">Last Name
										<input value="<?php if(empty($delivery['lastname'])){echo"null";}else{echo $delivery['lastname'];} ;?>" class="form-control" type="text" name="lastname">
									</label>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-lg-6">
									<label class="sr" for="lastname">Mobile
										<input value="<?php if(empty($delivery['mobile'])){echo"null";}else{echo $delivery['mobile'];}?>" class="form-control" type="text" name="mobile">
									</label>
								</div>
								<div class="col-md-12 col-lg-6">
									<label class="sr" for="address">Address
										<input value="<?php if(empty($delivery['address'])){echo"null";}else{echo $delivery['address'];}?>" class="form-control" type="text" name="address">
									</label>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-lg-6">
									<label>City
										<input value="<?php if(empty($delivery['city'])){echo"null";}else{echo $delivery['city'];}?>" class="form-control" type="text" name="">
									</label>
								</div>
								<div class="col-md-12 col-lg-3">
									<label>State
										<select class="form-control">
											<option class="form-control">
												Lagos
											</option>
										</select>
									</label>
								</div>
								<div class="col-md-12 col-lg-3">
									<label>Zip
										<input value="<?php if(empty($delivery['zip'])){echo"null";}else{echo $delivery['zip'];}?>" class="form-control" type="text" name="">
									</label>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-lg-6">
									<label>Email
										<input value="<?php if(empty($delivery['email'])){echo"null";}else{echo $delivery['email'];}?>" class="form-control" type="email" name="email">
									</label>
								</div>
								<div class="col-md-12 col-lg-6">
									<label class="sr" for="country">Country
										<select class="form-control">
											<option class="form-control">
												Nigeria
											</option>
										</select>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
							<button name="change_delivery_address" class="btn btn-sm btn-outline-info">update delivery address</button>
						</div>
					</form>
			</div>
		</div>
		<div class="col-md-4">
			<!-- change  password -->
			<div class="card">
				<div class="card-header py-5  alert-info">
					<h4>Change Password</h4>
				</div>
				<div class="card-body">
					<div class="progress" id="error_messages"><?php echo $error_message ;?>
						<div class="badge-success" style="display: none;width: 30%;" id="contains_caps" class="col-sm-3"> capital letter</div>
						<div class="badge-success" style="display: none;width: 30%;" id="contains_num" class="col-sm-3">contains number</div>
						<div class="badge-success" style="display: none;width: 30%;" id="six_characters" class="col-sm-3">atleast six charaters</div>
					</div>
					<form method="post" class="form-group">
						<input name="old_password" type="password" class="form-control mb-2" placeholder="Enter current password" required>

<br>
						<input type="password" name="password_1" id="password_1" class="form-control mb-2" placeholder="New Password" required>
						<input type="password" name="password_2" id="password_2" class="form-control mb-2" placeholder="Re-type new password"required>
					
				</div>
				<div class="card-footer">
					<button name="change_password" id="change_password" class="btn btn-sm btn-outline-info">change</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php include("include/footer.php");?>































<script type="text/javascript">

	//validagte password_strength:
	document.getElementById("password_1").addEventListener("keyup",function(){
		var password_1 = document.getElementById("password_1").value;

		var characterss = password_1.split();

		// create an array of numbers
		var numberss = [1,2,3,4,5,6,7,8,9,0];
		 // if the character is in the array of numbers

		


		if (password_1.length >= 6) {document.getElementById("six_characters").style.display="inline"; return true;}else{ return false;}
		
	})







	document.getElementById("password_2").addEventListener("keyup",function(){
		var password_1 = document.getElementById("password_1").value;
		var password_2 = document.getElementById("password_2").value;


		if (password_1 != password_2) {

			document.getElementById("error_messages").innerHTML = "passwords do not match";return(false);

		}else{
			document.getElementById("error_messages").innerHTML = "passwords match";

		}

	})
</script>


<script type="text/javascript">
	document.getElementById("display_avatar").addEventListener("click",function(){window.alert("hellow world")})
</script>