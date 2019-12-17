<?php include("include/header.php");?>
<section class="py-5"></section>
<?php $get_customer = mysqli_query($config,"select * from customers where id = $customer_id ");
 $customer= mysqli_fetch_assoc($get_customer);
?>

<div class="container-fluid justify-content-center">
	<div class=" text-center">		
		<div class="card">
			<div class="card-header py-5 alert-info">
			    Refer someone and get 5% of their first order added to your wallet instantly><br>
				<b>REFERAL CODE:</b><br>
			</div>
			<div class="card-body">
				<!-- referal code -->
				<a href="signup.php?ref=<?php echo $customer['referal_code']; ?>">
					https://afrileg.com/signup.php?ref=<?php echo $customer['referal_code']; ?>
				</a>
			</div>
			<div class="card-footer">
			</div>
		</div>
	</div>	
</div>	

<!-- end of main section, begining of footer -->
<div class="fixed-bottom">
	<?php include("include/footer.php");?>
</div>