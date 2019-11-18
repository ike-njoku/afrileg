<?php 
	// fetch the product details from the products database
	if (isset($_GET['product_id'])) {
		$product_id = $product_id;
		$pick_product = myslqi_query(config,"select * from products where id = '$product_id' ");
		$product = mysqli_fetch_assoc($pick_product);
	}
?>

<?php
	// this page process the request to view products details and is used in view_product.php
?>