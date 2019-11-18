<?php include("include/header.php");?>

	<div class="container-fluid">
		<?php include("include/menulist.php");?>
			
<?php include("include/search_bar_for_tracking_id.php");?>
				<div class="alert alert-info py-3 row">
					Orders Awaiting Shipping
					<p class="sm">These orders have been sorted and packaged but not shipped</p>
				</div>
			<!-- get all unshipped orders -->
			<!-- get all un shipped orders -->
			<!-- processed orders (orders processed orders but not shipped) -->
				<div class="row">
					<?php $get_new_order =mysqli_query($config,"select * from orders where processing='1' and shipped='0' "); ?>
					<?php if(mysqli_num_rows($get_new_order)): ?>
					<?php while($order=mysqli_fetch_array($get_new_order)):?>
					<div id="close_order<?php echo $order['id']; ?>" class="col-md-12 col-lg-6 mb-4">
						<div class="card">
							<div class="card-header d-flex justify-content-between"> 
								<div>Date: <?php echo $order['regdate'];?> </div>
								<?php if(empty($order['tracking_id'])){$date_= $order['regdate'] ; $user=$order['customer_id'];$track =crc32($order['id']); $update_tracking_id = mysqli_query($config,"update orders set tracking_id ='$track' where customer_id ='$user' and regdate ='$date_' ");} ?> 
							</div>
							<div class="card-body">
								<div><b>Tracking_id :</b> <?php echo $order['tracking_id'];?> </div><hr>
								<button id="display_order_details<?php echo $order['id'] ?>" style="float: right;" class="btn btn-sm btn-primary">view</button>
								
								<?php $user=$order['customer_id']; ?>
								<?php $tracking_id = $order['tracking_id'];?>
								<div style="display: none;" id="order_details<?php echo $order['id'];?>">
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
							<div id="options<?php echo $order['id'];?>" style="display: none;" class="card-footer">
								<button id="ship_order<?php echo $order['id'] ;?>" class="btn btn-primary btn-sm"> mark as Shipped</button>
								<button id="hide_order_details<?php echo $order['id'] ?>" class="btn btn-secondary btn-sm"> collapse</button>																
							</div>
						</div>
					</div>

			<script type="text/javascript">
				// display order details
				document.getElementById("display_order_details<?php echo $order['id'] ?>").addEventListener("click",function(){
					document.getElementById("order_details<?php echo $order['id'];?>").style.display="block";
					document.getElementById("display_order_details<?php echo $order['id'] ?>").style.display="none";
					document.getElementById("options<?php echo $order['id'];?>").style.display="block";
				})

				// hide order details
				document.getElementById("hide_order_details<?php echo $order['id'] ?>").addEventListener("click",function(){
					document.getElementById("order_details<?php echo $order['id'];?>").style.display="none";
					document.getElementById("display_order_details<?php echo $order['id'] ?>").style.display="inline";
					document.getElementById("options<?php echo $order['id'];?>").style.display="none";
				})

				// mark order as sorted (processing)
				document.getElementById("ship_order<?php echo $order['id'] ;?>").addEventListener("click",function(){
					var ship_request;
					if (window.XMLHttpRequest) {ship_request = new XMLHttpRequest();} else{ship_request = new ActiveXObject("Microsoft.XMLHTTP");}
					ship_request.open("GET","include/shipped_orders.php?order_id=<?php echo $order['id'];?>",true);
					ship_request.onreadystatechange=function(){
						if(ship_request.readyState==4 && ship_request.status==200){ window.alert(ship_request.responseText);}
					}
					ship_request.send();

					document.getElementById("close_order<?php echo $order['id']; ?>").style.display="none";
				})
			</script>		
					<?php endwhile;?>
					<?php else:?>
					<div class="alert alert-info py-5 text-center w-100">
						There are no new orders
					</div>
					<?php endif;?>
				</div>
			</div>
			</div>
		<?php include("include/end_menulist.php");?>
	</div>
<?php include("include/footer.php");?>