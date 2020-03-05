<?php session_start() ?>
<?php include("connect.php");?>

<?php $cusid = ""; $customer_id = "";
if (isset($_SESSION['id']))
  	{
	    $cusid = $_SESSION['id'];
	    $customer_select = mysqli_query($config,"select * from customers where id='$cusid'");
	    $customer = mysqli_fetch_assoc($customer_select);
	    $customer_id = $customer['id'];
	}
?>

<?php 
if (isset($_GET['key'])) {
	$amount_to_fund = $_GET['key'];
	
	// check the database for where the person has an amount but has not yet been marked as paid
	// if there is such a place, update that particular entry with "$amount_to_pay"
	// if there is no such place, then create an entry

	// check the database
	$check = mysqli_query($config,"select * from fund_wallet where customer_id='$customer_id' ");
	if (mysqli_num_rows($check)>0) {
		// update the value of the amount the person is trying to pay
		$update = mysqli_query($config,"update fund_wallet set amount='$amount_to_fund' where customer_id='$customer_id' and paid ='0' ");
		if (mysqli_affected_rows($config)>0) {
			"";
		}else{ $update = mysqli_query($config,"update fund_wallet set amount='$amount_to_fund' where customer_id='$customer_id' and paid ='0' ");}
	}else{
		// if there is no such entry, then create an entry
		
		$insert_data = mysqli_query($config,"insert into fund_wallet(customer_id,amount) values($customer_id,$amount_to_fund) ");
		if (mysqli_affected_rows($config)>0) {
			echo "this was successful";
		}else{
			$insert_data = mysqli_query($config,"insert into fund_wallet(customer_id,amount) values($customer_id,$amount_to_fund) ");
		}
	}

}
?>

