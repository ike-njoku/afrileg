<?php session_start();?>
<?php include("connect.php");?>

<?php
// check if the person is a registered customer or a visitor

// get customer details
  $cusid = ""; $customer_id = "";
  if (isset($_SESSION['id'])) {
  		$customer_id = $_SESSION['id'];
  		$customer_type = "customer";
  		$customer_select = mysqli_query($config,"select * from customers where id='$customer_id'");

	}else{
		$customer_id = $_COOKIE['guest_id'];
		$customer_type= "guest";
  		$customer_select = mysqli_query($config,"select * from guests where id='$customer_id'");
	}
  $customer = mysqli_fetch_assoc($customer_select);

	
?>

<?php 
	if (isset($_GET['product_id'])) {
		$product_id = $_GET['product_id'];

		// check if the procuct is already in the saved_items database with the custotmer id
		// if it isn not, insert it. else, still tell us it has been added to saved items 

		$search_saved_items = mysqli_query($config,"select * from saved_items where customer_id ='$customer_id' and product_id = '$product_id' and customer_type='$customer_type' ");
		$rows = mysqli_fetch_assoc($search_saved_items);
		if ($rows>0) {
			echo " this product has already been added ";
		} else{
			$save_the_item =	mysqli_query($config,"insert into saved_items (customer_id, product_id,customer_type) values ('$customer_id','$product_id','$customer_type')" );
			if ($save_the_item) {
				echo "this product has been saved to view later";
			}else{echo "please try again in a short while. You seem to have lost connection";}
		}
	}
?>