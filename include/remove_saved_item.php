<?php session_start(); include("connect.php");?>
<?php 

	// get customer_details
 	$cusid = ""; $customer_id = "";
  	if (isset($_SESSION['id'])) {
	  	$cusid = $_SESSION['id'];
	  	$customer_select = mysqli_query($config,"select * from customers where id='$cusid'");
	  	$customer = mysqli_fetch_assoc($customer_select);
	  	$customer_id = $customer['id'];
	  	$customer_type = "customer";
  	}else{
  		$customer_id = $_COOKIE['guest_id'];
  		$customer_type = 'guest';
  	}

?>

<?php 
	 include("connect.php");
	// get procuct customer_details
	if (isset($_GET['product_id'])) {
		$product_id = $_GET['product_id'];
	}
?>

<?php
	// delete the poroduct from the saved_items_table
	
	$select_product = mysqli_query($config,"select * from saved_items where customer_id ='$customer_id' and customer_type='$customer_type' ");
	if (mysqli_num_rows($select_product)<2) {
		echo'<div class="mt-4 w-100 alert alert-info py-5 text-center"><section class="py-5"><b>YOU DO NOT HAVE ANY SAVED ITEMS</b></section></div> ';
	}
	$delete_saved_item = mysqli_query($config,"delete from saved_items where customer_id='$customer_id' and product_id='$product_id' and customer_type ='$customer_type' ");
?>

<?php
//this page deletes items from the saved items list
?>