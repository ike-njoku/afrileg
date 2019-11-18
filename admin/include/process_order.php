<?php
	include("connect.php");
	if (isset($_GET['order_id'])) {
		$order_id = $_GET['order_id'];

		$update_order_status = mysqli_query($config,"update orders set processing = '1' where id='$order_id' ");
		if ($update_order_status) {
			$count_unprocessed_orders = mysqli_query($config,"select * from orders where processing = '0'");
			$count = mysqli_num_rows($count_unprocessed_orders);
			echo $count;
		}
	}
?>

<?php
 //this page updates the orders table to set  "processing" to the value of "1" where the conditions are met.
	// output is in include/header.php where id = 'new_orders'
  //it cetifies that the order has been confirmed, paid for and sorted out and that all thats left is to ship the order. 
?>