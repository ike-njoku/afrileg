<?php include("include/header.php");?>
<?php 
// get the refering page: this page must only be accessable if the user was redirected from edit.php
if (isset($_SERVER['HTTP_REFERER'])) {
	$refering_url = $_SERVER['HTTP_REFERER'];
	// check the refering page, redirect as required
	if ($refering_url !=="https://afrileg.herokuapp.com/edit.php") {
		// redirect to the edit page
		header("location:edit.php");
	}
}else{header("location:index.php");}

?>

<?php 
// make sure that only registered customers are allowed to view this page
if (empty($customer_id)) {
	header("location:index.php");
}
?>
<?php
// define the error message
$error_message = "";
// update the new password
if (isset($_POST['change_password'])) {
	$password_1 = crc32(md5(md5($_POST['password_1'])));
	$password_2 = crc32(md5(md5($_POST['password_2'])));
	// ensure that the new password is not empty
	if($password_1==$password_2){
		if (!empty($password_2)) {
			
			// redirect the page on successful update
			if ($update_password = mysqli_query($config,"update customers set password= '$password_2' where id='$customer_id' ")) {
				header("location:success2.php?password_update=true");
			}
		}
	}else{$error_message = "<div class='small alert alert-warning mb-2'>Your Passwords do not match</div>";}
}

?>
<script type="text/javascript">
	// script to hide the change-password rules
	window.onload = function(){
		document.getElementById("change_password_form").style.display = "none";
	}
</script>

<section class="py-5"></section>
<div class="container-fluid">
	<!-- create an informative modal to display the rules for creating a password -->
	<div class="row" id="rules_container">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					Creating your password
				</div>
				<div class="card-body">
					please Observe the following rules to enable you create a strong password:
					<br>
					1. Make Sure Your Password Includes at least one digit Digit<br>
					2. Make sure Your Password is not less than 8 characters <br>
					3. Be Sure to have at least one capital letter
					<div class="mt-4">
						<button id="proceed_button" class="btn btn-info btn-small">Proceed</button>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- the rest of the page  -->
	<div class="row" id="change_password_form">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header py-5 alert alert-info">
					CHange your password
				</div>
				<div class="card-body">
					<?php echo $error_message;?>
					<div id="display_password_strength" class="row small sm">
						<div style="display: none;" id="eight_characters" class="col-sm-4"><i class="far fa-check-circle success"></i><span class="small sm">At least 8 characters</span> </div>
						<div style="display: none;"id="passwords_match" class="col-sm-4"><i class="far fa-check-circle success"></i><span class="small sm">Passwords Match</span> </div>
						<div style="display: none;" id="one_digit_check" class="col-sm-4 mb-2"><i class="far fa-check-circle success"></i><span class="small sm">At one Digit</span> </div>
					</div>
					<form class="form-group" method="post">
						<div class="mb-4">
							<label class="sr" for="password_1">New Password</label>
							<input id="password_1" class="form-control" type="password" name="password_1">
						</div>
						<div class="mb-2">
							<label class="sr" for="password_2">Re-Type New Password</label>
							<input id="password_2" class="form-control" type="password" name="password_2">
						</div>	
				</div>
				<div class="card-footer  text-right">
					<button id="change_password_button" name="change_password" class="btn btn-primary btn-sm btn-small">
						Change Password
					</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	// hide the submit button by default
	document.getElementById("change_password_button").style.display = "none";
	// create function to toggle between showing parts of the form
	document.getElementById("password_1").addEventListener("keyup",function(){
		var password_2 = document.getElementById("password_2").value;
		var password_1 = document.getElementById("password_1").value;
			// check if the password contains at least one digit
			if (password_1.includes(1)||password_1.includes(2)||password_1.includes(3)||password_1.includes(4)||password_1.includes(5)||password_1.includes(6)||password_1.includes(7)||password_1.includes(8)||password_1.includes(9)||password_1.includes(0)){document.getElementById("one_digit_check").style.display ="inline";}else {document.getElementById("one_digit_check").style.display="none";}
			// check the length of the password and make sure that it is at least 8 characters
			if (password_1.length <8) {document.getElementById("eight_characters").style.display="none";} else {document.getElementById("eight_characters").style.display="inline";}
				if(password_1.length>0)
				{
						if (password_1 === password_2) {
					document.getElementById("passwords_match").style.display ="inline"; 
					// display the submit button
					document.getElementById("change_password_button").style.display = "inline";
				}else{
					document.getElementById("passwords_match").style.display ="none";
					document.getElementById("change_password_button").style.display = "none";
					return false;
			}
				}
				
	})
	// if passwords match
	document.getElementById("password_2").addEventListener("keyup",function(){
		var password_1 = document.getElementById("password_1").value;
		var password_2 = document.getElementById("password_2").value; 
		if (password_2.length>0) {
			// make sure that password_2 is not empty
			if (password_1 === password_2) {
				document.getElementById("passwords_match").style.display ="inline"; 
				// display the submit button
				document.getElementById("change_password_button").style.display = "inline";
			}else{
				document.getElementById("passwords_match").style.display ="none";
				document.getElementById("change_password_button").style.display = "none";
				return false;
			}
		}
		
	})

</script>

<script type="text/javascript">
	// hide the rules and display the actual form
	document.getElementById("proceed_button").addEventListener("click",function(){
		document.getElementById("rules_container").style.display = "none";
		document.getElementById("change_password_form").style.display = "block";
	})
</script>

<?php include("include/footer.php");?>