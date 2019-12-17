<?php include("include/header.php");?>
<?php if (empty($_SESSION['id'])) {
	header("location:index.php");
} ?>
<?php
	// get the delivery details
	$delivery_details = mysqli_query($config,"select * from delivery_details where customer_id ='$customer_id' ");
	if ($delivery_details){
		$delivery = mysqli_fetch_assoc($delivery_details);
	}else{$delivery = "nill";}
?>
<?php 
	// move the file to the profile folder
	if (isset($_FILES['avatar']['name'])) {
		$avatar_name = $_FILES['avatar']['name'];
		$target ='images/profile/'.$avatar_name;
		move_uploaded_file($_FILES['avatar']['tmp_name'], $target);	
	}
?>
<?php
	if (isset($_POST['upload'])) {

		$updating = mysqli_query($config,"update customers set avatar ='$target' where id='$customer_id' ");
		if ($updating) {
			echo "successful";
		}else{echo "unable to complete this process";}
	}
?>
<?php
	// get the customer details from the delivery cart
	$delivery_details = mysqli_query($config, "select * from delivery_details where customer_id = '$customer_id' ");
	$delivery = mysqli_fetch_assoc($delivery_details);
?>

<?php 
	// get the amount of money that the registered customer has in their wallet
	$get_wallet_balance = mysqli_query($config,"select * from wallet where customer_id='$customer_id' ");
	$wallet_balance= mysqli_fetch_assoc($get_wallet_balance);
	if ($wallet_balance < 0) {
		$wallet_balance = 0.00;
	}
?>


<section class="py-5"></section>
<div class="container-fluid">
	<div class="p-2 d-flex justify-content-between">
		<div><h3> Welcome, <?php echo $customer['username'];?></h3> </div>
		<div class="lead"><b>wallet balance:<i class="ti-wallet"></i> <?php echo $wallet_balance['amount'];?></b></div>
	</div>
	<div class="row text-center mb-4 py-2">
		<div class="col-md-4 py-5">
			<div class="card">
				<div class="p-4 card-header alert-info alert">
					<h1>Operations</h1>
				</div>
				<div class="card-body">
					<a href="orders.php">
						Orders   <span class="ti-package "></span>
					</a>
					<hr>
					<a href="cart.php">
						Cart   <span class="ti-shopping-cart "></span>
					</a>
					<hr>
					<a href="saved_items.php">
						Saved Items   <span class="ti-heart"></span>
					</a>
					<hr>
					<a href="index.php#newarrivals">
						New Arrivals   <span class="ti-wand"></span>
					</a>
				</div>
			</div>
		</div>
		<!-- orders ends -->
		<!-- details -->
		<div class="col-md-4">
			<div class="card">
				<div class="p-4 card-header alert alert-info">
					<h1>Customer Details</h1>
				</div>
				<div class="card-body">
					<img class="rounded-circle" height="70" width="70" src="<?php if(empty($customer['avatar'])){echo'images/avatar.png';}else{echo $customer['avatar'];} ?>">
					<hr>
					<div class="">
						customer ID: <?php echo $customer_id;?>
						<br>
						Email: <?php echo $customer['email'];?>
					</div>
					<hr>
					<!-- delivery details -->
					<div class="text-center">
						DELIVERY DETAILS <span class="fas fa-map-marker-alt"></span>
						<hr>	
						<div class="small p-2 row text-left">							
							<?php if(empty($delivery['address'])){echo 'None Specified';}else { echo $delivery['address'].'<span class="fas fa-ellipsis-h"></span>';}?>			
						</div>
						<hr>
						<div class="text-right">
							<a href="edit.php"class="ti-pencil-alt">Edit</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- details ends -->

		<!-- cards starts -->
		<div class="col-md-4 py-5">
			<div class="card">
				<div class="p-4 card-header alert alert-info">
					<h1>Gifts and Cards</h1>
				</div>
				<div class="card-body">
					<a href="coupons.php">my coupons </a>
					<hr>
					<a href="#">Buy Gift Card</a>
					<hr>
					<a href="referal.php">Referals</a>
					<hr>
					<a href="#">Become an Ambassador</a>
				</div>
			</div>
		</div>
		<!-- cards ends -->
	</div>
</div>











<div>
	<form method="post" enctype="multipart/form-data">
		<input type="file" name="avatar">
		<button name="upload" type="submit">upload image</button>
	</form>
</div>
<?php include("include/footer.php");?>