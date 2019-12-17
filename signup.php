<?php include("include/header.php");?>
<?php include("include/connect.php"); ?>

<?php

	
?>

<?php $err=""; 
	if (isset($_POST['signup'])) {
		$email=$_POST['email'];
		$username=$_POST['username'];
		$password=crc32(md5(md5($_POST['password'])));
		$hash = md5(rand(1,400000));
		// create referal code
		$referal_code = crc32($email);

	// get the referer
	
	if (isset($_GET['ref'])) {
		$referal_code  = $_GET['ref'];
		$referal_bonus = 100;

		// get the referer_id

		$get_referer = mysqli_query($config,"select * from customers where referal_code='$referal_code' ");
		$referer = mysqli_fetch_assoc($get_referer);
		$referer_id = $referer['id'];


	}

		// insert into database
		$qry= mysqli_query($config, "insert into customers (email, username, password, active, regdate, referal_code,referer_id) values('$email', '$username', '$password', '$hash', NOW(), '$referal_code', '$referer_id' )" );
		if (mysqli_affected_rows($config)>0) {
			
			// send mail
			$to=$email;
			$subject="Account Creation";
			$headers="From:Afrileg.com"."\r\n";
			$headers .="MIME-VERSION:1.0"."\r\n";
			$headers .='Content-type:text/html; charset=ISO-8859-1' . "\r\n";
			$message='
				<html>
					<head>
						<style>
							#msg_container{text-align:center}
						</style>
					</head>
					<body>
						<div id=msg_container>
							welcome, '.$username.' your account has been created successfully. <br>
							Please click <a href="http://localhost/afrileg.com/activate.php?email='.$email.'&hash='.$hash.'"> here </a> to activate your account
						</div>
					</body>
				</html>
			';


			if (mail($to, $subject, $message, $headers)) {
				$err='<div class="alert alert-success p-1 mb-2 text-center"> Your account has been created successfully. <p class="small"> An activation link has been sent to your email. please click the link to activate your account  </p> </div>';
			} else{$err='<div class="alert alert-warning p-1 mb-2 text-center"> Email could not be sent. please try again </div>'; 
			// delete the entry  from the database so that the user can try again:
			$delete_qry =mysqli_query($config,"delete from customers where email ='$email'");
			if ($delete_qry) {
				'<div class="alert alert-warning p-1 mb-2 text-center"> Email could not be sent. please try again </div>'; 
			}else{$delete_qry;}

			}
		} else{$err='<div class="alert alert-warning p-1 mb-2 text-center"> This email is in use by another customer </div>';}
	}
?> 


  <section class="container mt-5 py-5">
	<div class="container mt-5 col-md-8 col-lg-5">
		<div class="card ">
          <div class=" text-center card-header alert alert-info py-4">
            <h4>
              <hr>
              <b>Welcome to a world of unlimited African Print Options</b><br>
              <hr>
            </h4>
          </div>
        <div class="card-body">
        	<?php echo $err;?>
        <form method="post" class="form-group p-3">
              <label for="username" class="sr-only"required> First Name </label>
              <input placeholder="User Name" class="form-control m-1" type="text" name="username">
              <label for="email" class="sr-only"> Email </label>
              <input placeholder="Email" class="form-control m-1 " type="text" name="email" required>
              <label for="password" class="sr-only"> Password </label>
              <input placeholder="password" class="form-control m-1 " type="password" name="password" required>
              <div class="mt-4"><hr>
              	<button name="signup" class="btn btn-sm btn-outline-secondary form-control "> signup</button> 
          	</div>
          	<hr>
          	<div class="sm text-right">
            	<span class="sm"><b class="sm">... Slay the African Way</b></span>
          	</div>
          </div>
          </form>
        </div>
    </div>
	</div>
</section>
<div class="fixed-bottom">
	<?php include("include/footer.php");?>
</div>

