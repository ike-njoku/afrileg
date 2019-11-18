<?php include("include/header.php");?>
	<div class="container-fluid"><section class="py-5"></section>
		<div class="row p-3">
			<h3>Your Orders</h3>
		</div>
		<div class="row p-3 justify-content-center">
			<div class="col-md-10">
				<div>
					<input class="form-control" type="search" id="search_bar" placeholder="search orders by tracking id">
				</div>
				<div class="row" id="display_search_result"></div>
<script type="text/javascript">
	var search_bar = document.getElementById("search_bar");
	search_bar.addEventListener("keyup",function(){
		var search_request;

		if (window.XMLHttpRequest) {search_request = new XMLHttpRequest();} else { search_request = new ActiveXObject("Microsoft.XMLHttp");}
		search_request.open("GET","include/process_tracking_id_search.php?key_="+search_bar.value,true);
		search_request.onreadystatechange = function(){
			if(search_request.readyState==4 && search_request.status ==200) {
				document.getElementById("display_search_result").innerHTML = search_request.responseText;
			}
		}
		search_request.send();
	})
</script>

				<div class="mt-4">
					<div class="row">
						<?php $get_orders = mysqli_query($config,"select * from orders where customer_id = '$customer_id' ") ;?>
						<?php if(mysqli_num_rows($get_orders)):?>
							<?php while($order=mysqli_fetch_array($get_orders)):?>
								<div class="col-md-6 mb-4">
									<div class="card">
										<div class="card-header py-5 alert alert-info">
											Date: <?php echo $order['regdate'];?>
										</div>
										<div class="card-body">
											Tracking Id: <?php if(empty($order['tracking_id'])){$date= $order['regdate'] ; $get_tracking_id = mysqli_query($config,"select * from orders where customer_id = '$customer_id' and regdate='$date' ");
											$order = mysqli_fetch_assoc($get_tracking_id); $tracking_id = crc32($order['id']); $update_tracking_id = mysqli_query($config,"update orders set tracking_id = '$tracking_id' where customer_id='$customer_id' and regdate ='$date' "); echo $tracking_id;
											} else{echo $order['tracking_id'];}?>
											<button id="display_order<?php echo $order['id'];?>" style="float:right;" class="btn btn-info btn-sm"> view</button>

											<div style="display: none;" id="order_<?php echo $order['id'];?>_container">
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
												<div style="width: 25%;" class="progress-bar bg-info">Received</div>
												<?php if($order['processing']>0):?>
												<div style="width:25%;" class=" progress-bar bg-info">Sorted</div>
												<?php if($order['shipped']>0):?>
												<div style="width:25%;" class=" progress-bar bg-info">Shipped</div>
												<?php if($order['fulfilled']>0):?>
												<div style="width:25%;" class=" progress-bar bg-success">Fulfilled</div>
												<?php endif?>
												<?php endif?>
												<?php endif;?>
											</div>
											
												<button style="display: none;" id="collapse_order<?php echo $order['id'];?>" class="btn btn-sm btn-info m-2">collapse</button>
											
										</div>
									</div>
								</div>
<script type="text/javascript">
	document.getElementById("display_order<?php echo $order['id'];?>").addEventListener("click",function(){
		document.getElementById("order_<?php echo $order['id'];?>_container").style.display = "block";
		document.getElementById("display_order<?php echo $order['id'];?>").style.display = "none";
		document.getElementById("collapse_order<?php echo$order['id'];?>").style.display="inline";
	})

	document.getElementById("collapse_order<?php echo$order['id'];?>").addEventListener("click",function(){
		document.getElementById("order_<?php echo $order['id'];?>_container").style.display = "none";
		document.getElementById("display_order<?php echo $order['id'];?>").style.display = "inline";
		document.getElementById("collapse_order<?php echo$order['id'];?>").style.display="none";	
	})
</script>
							<?php endwhile;?>
							<?php else:?>
								<div class="alert alert-info py-5 text-center">
									<section class="py-5">
										You have not placed any orders. When you do, they will appear here.<br>
										click <a href="shop.php">here</a> to start placing orders.
									</section>
								</div>
						<?php endif;?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include("include/footer.php");?>