<?php include("include/header.php"); $err=""; ?>
<section class="py-5"></section>

	<div class="container-fluid">
		<div class="text-center p-3">
			<h2> Saved Items</h2>
		</div><hr>
		
		<?php include("include/category.php");?>
			<!-- categories list ends here -->

				<div id="display_err"></div>
				<div class="row">
					<!-- display saved items -->
					<?php $saved_items = mysqli_query($config,"select * from saved_items where customer_id = '$customer_id' and customer_type='$customer_type' ");
						if (mysqli_num_rows($saved_items)<1) {
							echo  '<div class="text-center alert alert-info py-5 w-100 m-2"><section class="py-5">YOU HAVE NO SAVED ITEMS</section></div>';
							
						} else{
						while ($product = mysqli_fetch_array($saved_items)) {

							 $get_product_id = $product['product_id']   ; #let the product_id refer to a variable that we will use to fetch the product id from the products table
							 $product_in_product_table = mysqli_query($config, "select * from products where id = '$get_product_id' ");
							 foreach ($product_in_product_table as  $product) {
							 	$product_id= $product['id'] ;
								$product_price = $product['price'];
								$product_name =$product['name'];

								// display which products are in your cart by tick
      							// /// display which products are in your cart by tick
								$tick = "";

							    // check if the person is a registered customer or a guest
							    if (isset($_SESSION['id'])) {
							      $customer_id = $_SESSION['id'];
							      $customer_type ="customer";
							    }else{
							      $customer_id = $_COOKIE['guest_id'];
							      $customer_type ='guest';
							    }

							    $tick_products = mysqli_query($config,"select * from cart where customer_id = '$customer_id' and product_id = '$product_id' and purchased='0' and customer_type='$customer_type' "); 
							    if (mysqli_num_rows($tick_products)) {
							      $tick = '<span class="far fa-check-circle success"></span>';
							    }
							    // tick ends

							 	echo'
							    
							 	<!--------- product  starts-------->
							      	<div id="hide_product_'.$product_id.'" class="col-xs-6 col-sm-6 col-lg-4 mb-4">
							        	<div class="card text-center mb-2">
							          		<div class="card-header text-center">
							          		<div class="text-right"><button id="remove_product_'.$product_id.'" class="btn btn-sm fas fa-times-circle"></button></div>
							            	'.$product['name'].'  
							          	</div>
						          		<div class="card-body bg-white">
							           	 	<a href="view_product.php?product_id='.$product['id'].'"><img style="min-height:200px; max-width:100%;  max-height:200px" 	class="card-image" alt="'.$product['name'].' " src="admin/'.$product['image1'].'" ></a>
							          	</div>
							          	<div class="card-footer p-1">
							            	<div class=" p-1">
							              		$ '.$product['price'].' 
							              	</div>
							              	<div>
							                	<i class="ti-star "></i>
								                <i class="ti-star "></i>
								                <i class="ti-star "></i>
								                <i class="ti-star "></i>
								                <i class="ti-star "></i>
							            	</div>
							            	<div class="btn-group text-center p-1">
							              		<a href="view_product.php?product_id='.$product['id'].'"   class="btn btn-sm btn-outline-secondary">view detail</a>
						              			<button id="product_'.$product['id'].'" name="add"  class="btn btn-sm btn-info">add to <i class="ti-shopping-cart"></i> 
						              			</button>
						              			<i class="ml-1" id="added_'.$product['id'].'" >
						              				'.$tick.'
						              			</i>
							            	</div>
							          	</div>
							        </div>
						      	</div>


<script type="text/javascript">

	//hide the removed item saved_list
	var remove_button = document.getElementById("remove_product_'.$product_id.'");
	remove_button.addEventListener("click",function(){
		document.getElementById("hide_product_'.$product_id.'").style.display="none";
		})

	//remove the clicked product fom the saved_list
	remove_button.addEventListener("click",function(){
	var remove_saved_item;
	if(window.XMLHttpRequest){remove_saved_item = new XMLHttpRequest();}else{remove_saved_item = new ActiveXObject("Microsoft.XMLHTTP");}
	remove_saved_item.open("GET","include/remove_saved_item.php?product_id='.$product['id'].'",true);
	remove_saved_item.onload = function(){document.getElementById("display_err").innerHTML = remove_saved_item.responseText;}
	remove_saved_item.send();

	})

  // add to cart ======================add to cart
    var add_button = document.getElementById("product_'.$product['id'].'");
    add_button.addEventListener("click",function(add_to_cart){

    var request_ ;
    // cross browser compartibility
    if(window.XMLHttpRequest){request_ = new XMLHttpRequest(); }
    else{request_ = new ActiveXObject("Microsoft.XMLHTTP");}

      request_.open("GET","include/add_to_cart.php?product_id='.$product_id.'&product_name='.$product_name.'&product_price='.$product_price.' ");
      request_.onload = function(){document.getElementById("added_'.$product['id'].'").innerHTML = request_.responseText;}
      request_.send();
    })


  // update cart in header=======update cart in header

  var add_button = document.getElementById("product_'.$product['id'].'");
  add_button.addEventListener("click",function(update_header){

    var update_request;
    if(window.XMLHttpRequest){update_request = new XMLHttpRequest(); }else{update_request = new ActiveXObject("Microsoft.XMLHTTP");}

    update_request.open("GET","include/update_header.php?product_id='.$product_id.'",true)
    update_request.onload = function(){document.getElementById("cart_items").innerHTML = update_request.responseText ;}
    update_request.send();
  })
</script>

							 	'
							 ;}
						}
					}
					?>
				</div>
			
		<?php include("include/end_category.php");?>
	</div>

<?php include("include/footer.php");?>