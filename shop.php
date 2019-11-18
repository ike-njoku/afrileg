<?php include("include/header.php");?>

<section class="py-5"></section>
<!-- left nav -->
<div class=" container-fluid">
	
		
			<?php include("include/category.php") ;?>
		



<!------------------ products container------------------------ -->

 
<?php $get_all_products = mysqli_query($config,"select * from products"); if(mysqli_num_rows($get_all_products)<1):?>
<div class="py-5 text-center alert alert-info">
	<section class="py-5">
		<h3><b>NEW PRODUCTS COMING SOON...</b></h3>
	</section>
</div>
<?php endif;?>

	
		<!-- display products by category -->
		<div id="display_products" class="row m-2 py-5">
		<?php
			if (isset($_GET['sscat_id'])) {
				$sscat_id = $_GET['sscat_id'];

				// get the products under the chosen sscat
				$get_products=mysqli_query($config,"select * from products where sub_sub_category_id = '$sscat_id' " ); 
				if(mysqli_num_rows($get_products)<1)
				{
					echo'<div class="mt-4 w-100 alert alert-info py-5 text-center"><section class="py-5"><b>NEW PRODUCTS COMING SOON...</b> </section></div> ';

				}else
		{while ($product=mysqli_fetch_array($get_products)) {
			include("include/shop_products_template.php");}

		}
	}
else{
		// display all the products in the database
		$get_products=mysqli_query($config,"select * from products" );

		while ($product=mysqli_fetch_array($get_products)) {
			$product_id=$product['id'];
			$product_name=$product['name'];
			$product_price=$product['price'];
	  // display which products are in your cart by tick
      // /// display which products are in your cart by tick
    	$tick = "";  
    	$tick_products = mysqli_query($config,"select * from cart where customer_id = '$cusid' and product_id = '$product_id' and purchased='0'"); 
    if (mysqli_num_rows($tick_products)) {
      $tick = '<span class="far fa-check-circle success"></span>';
    }
    // tick ends
			include("include/shop_products_template.php");
			
		}
	}

?>

		

<!-- -------------------------------product end--------------------------- -->
			
		</div>
		<!-- main row ends -->
		<?php include("include/end_category.php");?>
	</div>

</div>

<!-- content ends here -->



<?php include("include/footer.php");?>