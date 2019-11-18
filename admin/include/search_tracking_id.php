<?php include("connect.php"); ?>

<?php
	// get the key
	if (isset($_GET['search_for'])) {
		$key_ = $_GET['search_for'];
		if ($key_ =='') {
			return;
		}
	}
?>

<?php 
	// get all the orders and their status
	$get_all_orders = mysqli_query($config,"select * from orders where tracking_id like '$key_%' ");
	if(mysqli_num_rows($get_all_orders)):
?>
<?php while($order = mysqli_fetch_array($get_all_orders)): ?>
<div class="col-lg-6">
	<div class="card">
		<div class="card-header">
			<div>
				Date: <?php echo $order['regdate'];?>
			</div>
		</div>
		<div class="card-body">
			Tracking Id: <?php echo $order['tracking_id'];?><hr>
			<div>
				<b>Sorted and Packaged:</b> <?php if ($order['processing']>0){echo 'yes';} else{echo "no";} ;?><br>
				<b>Shipped:</b> <?php if ($order['shipped']>0){echo 'yes';} else{echo "no";} ;?><br>
				<b>Fulfilled:</b> <?php if ($order['fulfilled']>0){echo 'yes';} else{echo "no";} ;?><br>			
			</div>



			<?php $user=$order['customer_id']; ?>
			<?php $tracking_id = $order['tracking_id'];?>
			<div style="display: block" id="order_details<?php echo $order['id'];?>">
				<table class="table">
					<thead>
						<th>Item</th>
						<th>Quantity</th>
						<th>Variations</th>
					</thead>
					<!-- table head ends -->
					<tbody>
						<?php $get_cart_products= mysqli_query($config,"select * from cart where customer_id ='$user' and tracking_id='$tracking_id' ");?>
						<?php while($cart = mysqli_fetch_array($get_cart_products)): $product_id=$cart['product_id'];?>
							<tr>
								<td> 
									<?php $get_product = mysqli_query($config,"select * from products where id = '$product_id' ");
									$product=mysqli_fetch_assoc($get_product);
									?>

									<a target="_blank" href="../view_product.php?product_id=<?php echo $product['id'];?>">
										<img height="40"width="40" src="<?php echo $product['image1'];?>"><br>
										<?php echo $product['name'];?>
									</a>
								</td>
								<td><?php echo $cart['quantity'];?></td>
								<td> variations</td>	
							</tr>
						<?php endwhile;?>
					</tbody>
				</table>	

				<div>
					<?php $get_customer_delivery_details= mysqli_query($config,"select * from delivery_details where customer_id ='$user' "); ?>
					<?php $customer_delivery=mysqli_fetch_assoc($get_customer_delivery_details);?>
					<hr><b>Delivery Details</b><hr>
					Last Name: <?php echo $customer_delivery['lastname'];?>,<br>
					First Name: <?php echo $customer_delivery['firstname'];?>,<br>
					First Name: <?php echo $customer_delivery['email'];?>,<br>
					First Name: <?php echo $customer_delivery['mobile'];?>,<br>



					<?php echo $customer_delivery['address'];?>,<br>
					<?php echo $customer_delivery['city'];?> <br>
					 ZIP: <?php echo $customer_delivery['zip'];?>,<br>

					<?php echo $customer_delivery['state'];?>,<br>
					<?php echo $customer_delivery['country'];?>,<br>

				</div>
			</div>
		</div>
		
	</div>
</div>

<?php endwhile;?>

<?php else:?>
	no results match your search
<?php endif;?>