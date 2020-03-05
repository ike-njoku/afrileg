<?php session_start();
	include("connect.php");

	if(isset($_SESSION['id'])){
		// get customer_details
	 	$cusid = ""; $customer_id = "";
	  	if (isset($_SESSION['id'])) {
	  	$customer_id = $_SESSION['id'];
	  	$customer_select = mysqli_query($config,"select * from customers where id='$cusid'");
	  	$customer = mysqli_fetch_assoc($customer_select);
	  	$customer_id = $customer['id'];}
	  	$customer_type = 'customer';
	}else{
		$customer_id = $_COOKIE['guest_id'];
		$customer_type = "guest";

	}

?>
 
<?php 
	$search_cart = mysqli_query($config,"select * from cart where customer_id = '$customer_id' and purchased='0' and customer_type ='$customer_type'; ");
	if (mysqli_num_rows($search_cart)<1)
		{echo'
			<div class="mt-4 w-100 alert alert-info py-5">
				<section class="py-5"> 
					You do not have any items in your cart</section> <a href="shop.php"class=" btn btn-small btn-outline-secondary m-1"><i class="far fa-arrow-alt-circle-left"></i>   shop</a> 
				</section>
			</div>


			'
		 ;}
else{

		 	echo '
		 			<div class="d-flex justify-content-between mb-3">
						<a href="shop.php"class=" btn btn-small btn-outline-secondary m-1"><i class="far fa-arrow-alt-circle-left"></i>   shop</a>
						<div class="btn-group">
							<a type="submit" name="update" href="cart.php" class=" btn btn-small btn-outline-secondary m-1"><span class="fas fa-sync"></span> update cart</a>
							<a id="save_button" href="checkout.php"class="btn btn-small btn-outline-info m-1">Save and Continue </a>
						</div>
					</div>

		 		'
		 ;}
?>

<?php
	// this page hides the save_and_continue button to prevent clients from proceeding
	// the delivery page when the cart is empty
	// it is used in the cart.php page
	// results are displayed where id="save_and_continue"
?>