<?php session_start();?>
<?php include("connect.php");?>
<?php $cusid = ""; $customer_id = "";
  if (isset($_SESSION['id'])) {
  $cusid = $_SESSION['id'];
  $customer_select = mysqli_query($config,"select * from customers where id='$cusid'");
  $customer = mysqli_fetch_assoc($customer_select);
  $customer_id = $customer['id'];}
?>



<?php 

	if (isset($_POST['email'])and isset($_POST['password'])) {
		$email = $_POST['email'];
		echo $email;
	}

?>