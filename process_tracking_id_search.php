<?php session_start();?>
<?php include("connect.php");?>


<?php 
	// get the customer_id
	if (isset($_SESSION['id'])) {
		$customer_id = $_SESSION['id'];
	}else{echo "no";}
?>

<?php 
	if (isset($_GET['key_'])) {
		$key_ = $_GET['key_'];

		if ($key_=="") {
			return;
		}
	}else{return;}
?>

<?php 
	// get the order from the orders table

	$get_orders = mysqli_query($config,"select * from orders where customer_id='$customer_id' and tracking_id  like '$key_%' ") ;
	if (mysqli_num_rows($get_orders)) :
?>

<?php while($order=mysqli_fetch_array($get_orders)):?>
								<div class="col-md-6 mb-4">
									<div class="card">
										<div class="card-header">
											Date: <?php echo $order['regdate'];?>
										</div>
										<div class="card-body">
											Tracking Id: <?php if(empty($order['tracking_id'])){$date= $order['regdate'] ; $get_tracking_id = mysqli_query($config,"select * from orders where customer_id = '$customer_id' and regdate='$date' ");
											$order = mysqli_fetch_assoc($get_tracking_id); $tracking_id = crc32($order['id']); $update_tracking_id = mysqli_query($config,"update orders set tracking_id = '$tracking_id' where customer_id='$customer_id' and regdate ='$date' "); echo $tracking_id;
											} else{echo $order['tracking_id'];}?>
											

											<div id="order_<?php echo $order['id'];?>_container">
												<table class="table">
													<thead>
														<th>Product</th>
														<th>Quantity </th>
														<th>Variations</th>
													</thead>
													<tbody>
														<?php $tracking_id= $order['tracking_id'];?>
														<?php $get_cart = mysqli_query($config,"select * from cart where customer_id ='$customer_id' and purchased='1' and tracking_id='$tracking_id'") ;?>
														<?php while($cart=mysqli_fetch_array($get_cart)): $product_id = $cart['product_id'];?>
														<tr>
															<td>
																<?php $get_product = mysqli_query($config,"select * from products where id ='$product_id' "); $product = mysqli_fetch_assoc($get_product);?>
																<a href="view_product.php?product_id=<?php echo $product['id'];?>">
																<img height="50" width="50" src="admin/<?php echo $product['image1'];?>"><br>
																<?php echo $product['name'];?>	
																</a>
															</td>
															<td><?php echo $cart['quantity'] ;?></td>
															<td>variations</td>
														</tr>
														<?php endwhile;?>
													</tbody>
												</table>
											</div>

										</div>
										<div class="card-footer text-right">
											<div class="progress">
												<div style="width: 25%;" class="progress-bar bg-secondary">Received</div>
												<?php if($order['processing']>0):?>
												<div style="width:25%;" class=" progress-bar bg-warning">Sorted</div>
												<?php if($order['shipped']>0):?>
												<div style="width:25%;" class=" progress-bar bg-info">Shipped</div>
												<?php if($order['fulfilled']>0):?>
												<div style="width:25%;" class=" progress-bar bg-success">Fulfilled</div>
												<?php endif?>
												<?php endif?>
												<?php endif;?>
											</div>
											
												
											
										</div>
									</div>
								</div>

							<?php endwhile;?>

<?php else:?>
	None of your orders matches this search.
<?php endif;?>