<?php
	include("connect.php");
	if (isset($_GET['order_id'])) {
		$order_id = $_GET['order_id'];

		$update_order_status = mysqli_query($config,"update orders set shipped = '1' where id='$order_id' ");
		if ($update_order_status) {
			echo "this order has been marked as shipped";
		} else {echo "please refresh the page and try again";}
	}
?>

<?php 
	// this page updates the 'shipped' column in the orders table 
?>