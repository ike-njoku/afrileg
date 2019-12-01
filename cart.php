<?php include("include/header.php");?>
<section class="py-5"></section>

<div class="container-fluid">

	<?php include("include/category.php");?>
	<div class="text-center ">
		<div class="mt-4">
			<div id="display_products" class="container-fluid">
				<!-- table of products in cart -->
				<div class="container ">
					<table class="table  small">
						<form method="post">
							<thead>
								<th scope="col" >
									PRODUCT 
								</th>
								<th scope="col">
									UNIT PRICE
								</th>
								<th scope="col">
									QUANTITY
								</th>
								<th scope="col">
									TOTAL PRICE
								</th>
							</thead>
							<!-- table body -->
							<tbody class="">
								<?php 
									 $err =""; # error message for an empty cart
									 $cart_total = 0; #initialise the value of the cart total
									// select products from cart
									$select_product = mysqli_query($config,"select * from cart where customer_id = '$cusid' and purchased='0' " );
									if(mysqli_num_rows($select_product) and (!empty($_SESSION['id'])) )
									{
										while ($product = mysqli_fetch_array($select_product))
											{ 	$product_id = $product['product_id']; #get the product id of the product
												$quantity = $product['quantity'];
												$row_total = $product['product_price'] * $product['quantity'];
												// cart total
												
												$cart_total += $row_total ;

												// get the product's image from the products table
												$get_product = mysqli_query($config,"select * from products where id = '$product_id' " );
												$g_product = mysqli_fetch_array($get_product);
													echo
												'
									
									<tr id="product_'.$product_id.'_row" >
										<td class="text-center">
											<div class="">
												<div class="small">
													'.$g_product['name'].'
												</div>
											</div>
											<a href="view_product.php?product_id='.$g_product['id'].'">
												<img style="height:50px; width:50px;" src= "admin/'.$g_product['image1'].'">
											</a>
										</td>
										<td>
											NGN '.$product['product_price'].'
										</td>
										<td>
												<input id="'.$product['id'].'quantity" class= "w-25" value= "'.$product['quantity'].'">
												<a id="del_product'.$product['id'].'" href="#">
													<i class="fas fa-trash-alt"></i>
												</a>
										</td>
										<td>
											NGN 
											<span id="hello_'.$product_id.'">
												'.$row_total.'
											</span>
										</td>
									</tr>

		<script type="text/javascript">
			// delete from the cart
			var del_button = document.getElementById("del_product'.$product['id'].'");
			del_button.addEventListener("click",function(){
				var delete_item;
				if (window.XMLHttpRequest){delete_item = new XMLHttpRequest(); } else{delete_item =new ActiveXObject("Microsoft.XMLHTTP");}
				delete_item.open("GET","include/delete_from_cart.php?customer_id='.$customer_id.'&product_id='.$product_id.'&quantity='.$quantity.'",true);
				delete_item.readystatechange = function(){
					if(delete_item.readyState == 4 && xmlhttp.status == 200 ){window.alert(delete_item.responseText);}
				}
				delete_item.send();
			})
			// hide the save_and_continue button if cart is empty
			del_button.addEventListener("click",function(){
				var hide_save;
				if (window.XMLHttpRequest){hide_save = new XMLHttpRequest()}else{hide_save = new ActiveXObject("Microsoft.XMLHTTP");}
				hide_save.open("GET","include/hide_checkout_button.php",true);
				hide_save.onload = function(){document.getElementById("save_and_continue").innerHTML = hide_save.responseText;}
				hide_save.send();
				})
			// update the cart in the header
			del_button.addEventListener("click",function(){
				var update_header;
				if (window.XMLHttpRequest){update_header = new XMLHttpRequest(); } else{update_header =new ActiveXObject("Microsoft.XMLHTTP"); }
				update_header.open("GET","include/update_header.php",true);
				update_header.onload = function(){document.getElementById("cart_items").innerHTML = update_header.responseText;}
				update_header.send();
				})
			del_button.addEventListener("click",function hide_deleted(){
				document.getElementById("product_'.$product_id.'_row").style.display ="none";
				})
			del_button.addEventListener("click",function(){
				var update_cart_total;
				if(window.XMLHttpRequest){update_cart_total = new XMLHttpRequest();} else{ update_cart_total =new ActiveXObject("Microsoft.XMLHTTP"); }
				update_cart_total.open("GET","include/checkoutdetails.php?cart_total='.$cart_total.'",true);
				update_cart_total.onload = function(){document.getElementById("display_total").innerHTML = update_cart_total.responseText;}
				update_cart_total.send();
			})	

			//update the quantity of the product in the cart from the input 
			document.getElementById("'.$product['id'].'quantity").addEventListener("keyup",function(){

				var update_quantity_request;
				if(window.XMLHttpRequest){update_quantity_request = new XMLHttpRequest();}else{ update_quantity_request = new ActiveXObject("Microsoft.XMLHTTP");}
				update_quantity_request.open("GET","include/update_quantity_request.php?product_id='.$g_product['id'].'&qty="+document.getElementById("'.$product['id'].'quantity").value,true);
				update_quantity_request.send();

			})




			// update the cart total after editing the quantity per product

			document.getElementById("'.$product['id'].'quantity").addEventListener("keyup",function(){

				var reset_cart_total_request;
				if(window.XMLHttpRequest){reset_cart_total_request = new XMLHttpRequest();}else{ reset_cart_total_request = new ActiveXObject("Microsoft.XMLHTTP");}
				reset_cart_total_request.open("GET","include/checkoutdetails.php",true);
				reset_cart_total_request.onreadystatechange = function(){

					if(reset_cart_total_request.status==200 && reset_cart_total_request.readyState==4){
						document.getElementById("display_total").innerHTML = reset_cart_total_request.responseText;
					}
				}
				reset_cart_total_request.send();

			})

			
		 // update the row_total after increasing or decreasing the quantity of products needed
		 document.getElementById("'.$product['id'].'quantity").addEventListener("keyup",function(){
		 	var update_row_total_request;
		 	var display_place = document.getElementById("hello_'.$product_id.'");
		 	if(window.XMLHttpRequest){update_row_total_request = new XMLHttpRequest(); }else{update_row_total_request= new ActiveXObject("Microsoft.HTTP");}
		 	update_row_total_request.open("GET","include/cart_calculate_row_total.php");
		 	update_row_total_request.onreadystatechange = function(){
		 		if(update_row_total_request.readyState==4 && update_row_total_request.status==200)
		 		{
		 			document.getElementById("hello_'.$product_id.'").innerHTML = update_row_total_request.responseText;
		 		}
		 	}
		 	update_row_total_request.send();
				
		 })






		</script>

		
										'										
									;}

								}else {$err = '<div class="mt-4 w-100 alert alert-info py-5"><section class="py-5"> <h3 class="lead">You do not have any items in your cart</h3></section> <a href="shop.php"class=" btn btn-small btn-outline-secondary m-1"><i class="far fa-arrow-alt-circle-left"></i>   shop</a> </section></div> ';}


								?>
							
							</tbody>
							<td>
								<b>Cart Total</b>
								</td>
								<td>
								</td>
								<td>
								</td>
								<td>
									<b>NGN</b>
									<b  id="display_total">
									<?php echo $cart_total;?>
									</b>
							</td>		
						</table>
						<!-- continue to shopping or check out -->
					<?php 
						$search_cart = mysqli_query($config,"select * from cart where customer_id = '$cusid' and purchased='0' " );
						if (mysqli_num_rows($search_cart)>0) {
							echo '
					<div id="save_and_continue">
						<div class="d-flex justify-content-between mb-3">
							<a href="shop.php"class=" btn btn-sm btn-outline-secondary m-1"><i class="far fa-arrow-alt-circle-left"></i>   shop</a>
							<div class="btn-group">
								<a type="submit" name="update" href="cart.php" class=" btn btn-sm btn-outline-secondary m-1"><span class="fas fa-sync"></span> update cart</a>
								<a id="save_button" href="checkout.php"class="btn btn-sm btn-outline-info m-1">Save and Continue </a>
							</div>
						</div>
					</div>

							';
						
						}
							
					?>
				</form>
						<?php echo $err ;?>
				</div>
			</div>
		</div>
	</div>
	<?php include("include/end_category.php");?>
</div>


<?php include("include/footer.php");?>
						

