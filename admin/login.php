<?php session_start(); include("include/connect.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Afrileg.com</title>
	<link rel="icon" href="../images/favicon.png">
	<meta charset="utf8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!---local bootstrap files--->
	<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">

  <!-- fonts -->
  <link rel="stylesheet" href="fonts/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="fonts/fontawesome/css/fontawesome-all.css">
  
  <link rel="stylesheet" href="vendor/bootstrap/css/style.css">
</head>

<body>
	<nav class="navbar bg-dark fixe-top">
		<a href="index.php"><img height="50" width="50" src="../images/favicon.png"></a>
	</nav>
	<section class="py-5"></section>

	
<?php 
	$err="";
	if (isset($_POST['login'])) {
		$email = $_POST['email'];
		$password = $_POST['password'];

		// select match:
		$admin_select = mysqli_query($config,"select * from admin where email = '$email' and password = '$password'");
		if (mysqli_num_rows($admin_select)) {
			$admin = mysqli_fetch_assoc($admin_select);
			$_SESSION['email'] = $admin['email'] ;
			header("location:index.php");			
		}else{$err = '<div class=" p-3 text-center alert alert-warning">You are not an Admin</div>';}
	}
?>

<div class="container">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body p-4">
					<div class="p-2 text-center">
						<img height="150" width="150" src="../images/favicon.png">
					</div>
					<?php echo $err;?>
					<form class="form-group" method="post">
						<input class="form-control mb-2" type="email" name="email" placeholder="email" required>
						<input class="form-control mb-2" type="password" name="password" placeholder="password" required>
						<div class="p-1 mt-3 text-right">
							<button name="login" class="btn btn-sm btn-outlint-info mb-2" type="submit">login</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-4"></div>
	</div>
</div>
<?php include("include/footer.php");?>