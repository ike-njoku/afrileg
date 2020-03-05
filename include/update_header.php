<?php 
	session_start();
	include("connect.php");
	if (isset($_SESSION['id'])) {
		$customer_type ='customer';
		$cusid = $_SESSION['id'];
		$customer_select = mysqli_query($config,"select * from customers where id ='$cusid' " );
		$customer = mysqli_fetch_assoc($customer_select);
		$customer_id = $customer['id'];
	}else{
		// if the person is not a registered customer:
		$customer_type = 'guest';
		$guest_id = $_COOKIE['guest_id'];
		$cusid = $guest_id;
		$customer_id = $guest_id;
	}
	
	// all we want to do here is echo the number of rows the customer has in the cart
	// the number of rows that each customer has in the cart
	$qry = mysqli_query($config,"select * from cart where customer_id='$customer_id' and purchased='0' and customer_type ='$customer_type' ");
	$counter = mysqli_num_rows($qry);
	// output result
	if ($counter >0) {
		echo'<span class="badge badge-info" >
				'.$counter.'
			 </span> 
		 	';
	}else{echo $counter;}
?>
<?php 
	// this page outputs the results of how many rows a client occupies in the cart table to depict howmany distinct products the customer is purchasing
	// it is called to function when the delete button is clicked in the cart page
	// the result is displayed in the header where the id = "cart_items"
?>