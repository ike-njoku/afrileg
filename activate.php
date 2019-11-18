<?php include("include/header.php");?>
<?php
	$err="";
	if ( isset($_GET['email']) and isset($_GET['hash']) and !empty($_GET['email']) and !empty($_GET['hash']) ) {
	 	
	 	// compare with information from database
	 	$email=$_GET['email'];
	 	$hash=$_GET['hash'];
	 	$qry= mysqli_query($config, "select * from customers where email='$email' and active='$hash' ");
	 	$customer=mysqli_fetch_assoc($qry);
	 	if ($customer['active']==$hash) {
	 		mysqli_query($config,"update customers set active='1' where email='$email' " );
	 		$err='<section class="py-5"><div class="alert alert-success p-2 m-2 py-5 text-center">'.$customer['username'].', YOUR ACCOUNT ACTIVATION WAS SUCCESSFUL</div>
	 		<a href="login.php"> click here to login</a>
	 		</section> ';
	 	}else{header("location:index.php");}
	}else{header("location:index.php");} 
;?>

<div class="container-fluid">
	<section class="py-5">
		<div class="py-5">
			<div class="py-5">
				<div class="py-5">
					<?php echo $err;?>	
				</div>
			</div>
		</div>
	</section>
</div>
<div class="fixed-bottom">
	<?php include("include/footer.php");?>
</div>
<!--  -->
