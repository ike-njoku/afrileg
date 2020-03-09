<?php session_start();?>
<?php include("connect.php");?>

<?php 
	// decide if the client is guest or visitor
	if (isset($_SESSION['id'])) {
		$customer_id = $_SESSION['id'];
		$customer_type = 'customer';
	}else{
		$customer_id = $_COOKIE['guest_id'];
		$customer_type ='guest';
	}

	// mysqli_code to update the  database to reflect that the person has dismissed the pop up so that it does not continue to display on each new page within the website

	$update_table = mysqli_query($config,"update guests set hide_cookie_pop_up ='1' where guest_id ='$customer_id' ");


?>