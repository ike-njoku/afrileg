<?php session_start();?>
<?php include("connect.php");?>
<?php
	if (isset($_SESSION['email'])) {
		$admin_email = $_SESSION['email'];
		$select_admiin = mysqli_query($config,"select * from admin where email = '$admin_email' ");
		$admin = mysqli_fetch_assoc($select_admiin);
	}else{header("location:login.php?_YOURE_NOT_AN_ADMIN");}
?>

<?php 
	// new messages
	$get_all_msgs = mysqli_query($config,"select * from message");
	$all_msgs = mysqli_num_rows($get_all_msgs);

	$get_new_msgs = mysqli_query($config,"select * from message where viewed ='1'");
	$new_msgs = mysqli_num_rows($get_new_msgs);

	$unread_msg = $all_msgs-$new_msgs;
?>


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


<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top mb-2">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><img class="img-fluid" height="50" width="50" src="../images/favicon2.png"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      	<ul class="navbar-nav ml-auto">
      		<li class="nav-item active">
	          <a class="nav-link" href="customers.php">Customers
	            <span class="sr-only">(current)</span>
	          </a>
	        </li>
	        <li class="nav-item active">
	          <a class="nav-link" href="messages.php">Messages 
	          	<?php if($unread_msg > 0):?>
	          		<span id="msg_count" class="badge badge-info "><?php echo $unread_msg;?> </span>
	          	<?php endif;?>
	            <span class="sr-only">(current)</span>
	          </a>
	        </li>
	        <li class="nav-item active">
	          <a class="nav-link" href="#">Transastions
	            <span class="sr-only">(current)</span>
	          </a>
	        </li>
	        <li class="nav-item active">
	          <a class="nav-link" href="new_orders.php">Orders
	            <span class="sr-only">(current)</span>
	            <?php $get_new_orders = mysqli_query($config,"select * from orders where processing ='0'"); $new_orders = mysqli_num_rows($get_new_orders);?>
	            <?php if($new_orders>0):?>
	            	<span  id="new_orders" class="badge badge-info">
	            		<?php echo $new_orders;?>
	            	</span>
	            <?php endif;?>
	          </a>
	        </li>
    	</ul>
    </div>
</nav>
<section class="py-5"></section>
