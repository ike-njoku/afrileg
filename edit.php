<?php include("include/header.php"); if(empty($customer_id)){header("location:index.php"); } ?>
<?php 
	$err="";
	// Password Change
	if (isset($_POST['check_old_password'])) {
		$current_password="";
		// ensure that this code only runs if the form is not empty
		if ($current_password != " ") {
			
			$current_password = crc32(md5(md5($_POST['old_password'])));
			// echo crc32(md5(md5($_POST['check_old_password'])));
			// compare the entered password with the password from the data base
			$password_check = mysqli_query($config,"select * from customers where id ='$customer_id' and password='$current_password'");
			if (mysqli_num_rows($password_check) ) {
				// redirect the page to the actual page where the password change is done
				header("location:change_password.php");

			}else{
				$err = '<div class="alert alert-warning mb-2 small sm text-center">You have entered an invalid password </div>' ;
			}
		}
	}
?>
<section class="py-5"></section>
<div class="container-fluid">
	
	<div class="row">
		<!-- edit customer delivery details -->

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
		</div>
	</div>
		<!-- change user password -->
		<div class="col-md-6">
			<div class="card">
				<div class="text-center card-header py-5 alert alert-info">
					<h1><b>Change Password</b></h1>
				</div>
				<div class="card-body">
					<form class="form-group" method="post"> 
						<div class="">
							<!-- display error messages -->
							<?php echo $err;?>
							<label class="sr" for="old_password">Current Password</label>
							<input id="old_password" class="form-control" type="password" name="old_password">
						</div>
						<div class="text-right">
							<hr class="hr">
							<button id="submit_password_button" type="Submit" name="check_old_password" class="btn btn-primary btn-sm btn-small">
								Submit
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- change password ends here -->
	</div>
</div>
<?php 
// hide the submit button if the "change password" form is empty
?>
<script type="text/javascript">
	// hide the submit button by default
	document.getElementById("submit_password_button").style.display ="none";
	// create function to toggle between hiding and displaying the button
	document.getElementById('old_password').addEventListener("keyup",function(){
		if (document.getElementById("old_password").value.length ==0){
			// hide the submit button;
			document.getElementById("submit_password_button").style.display ="none";
		}else{
			// else display the password
			document.getElementById("submit_password_button").style.display ="inline";
		}
	})
</script>
<?php include("include/footer.php");?>


