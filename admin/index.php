<?php include("include/header.php");?>

<?php 
	// new messages
	$get_all_msgs = mysqli_query($config,"select * from message");
	$all_msgs = mysqli_num_rows($get_all_msgs);

	$get_new_msgs = mysqli_query($config,"select * from message where viewed ='1'");
	$new_msgs = mysqli_num_rows($get_new_msgs);

	$unread_msg = $all_msgs-$new_msgs;
?>

<?php 
	// customers
	$get_customers = mysqli_query($config,"select * from customers");
	$customers = mysqli_num_rows($get_customers);
?>

<div class="container-fluid">
	<div class="row">
		<div class="alert alert-info py-3 col-md-2">
			<div class="sticky-top">
				Statistics
				<hr>
				members
				<hr>
				messages
				<hr>
				view products
				<hr>
				create products
				<hr>
				Transactions
			</div>
		</div>

		<!-- main starts here -->
		<div class="col">
			<div class="row text-center">
			
			</div>	
		</div>
		<!-- main ends here -->
	</div>
</div>

<?php include("include/footer.php");?>
