<?php include("include/header.php");?>
<?php 
	// fetch the product details from the products database
	if (isset($_GET['product_id'])) {
		$product_id = $_GET['product_id'];
		$pick_product = mysqli_query($config,"select * from products where id = '$product_id' ");
		$product = mysqli_fetch_assoc($pick_product);
		$product_sscat_id =  $product['sub_sub_category_id'];
		

		//tick purchased products 
		$tick = "";  
    	$tick_products = mysqli_query($config,"select * from cart where customer_id = '$cusid' and product_id = '$product_id' and purchased='0'"); 
    if (mysqli_num_rows($tick_products)) {
      $tick = '<span class="far fa-check-circle success"></span>';
    }
	}else{header("location:index.php");}
?>


<section class="py-5"></section>
<div class="container-fluid">
	
	
	
			<?php include("include/category.php");?>
			<!-- product view starts here -->

			
				<div class="row text-center">
					<div class="col-md-7">
						<div id="product_image_slide" class="carousel slide" data-ride = "carousel">
							<!-- carousel_indicators -->
							<ol class="carousel-indicators" >
								<li class="active"data-target="#product_image_slide" data-slide-to="0" ></li>	
								<li data-target="#product_image_slide" data-slide-to="1" ></li>				
								<li data-target="#product_image_slide" data-slide-to="2" ></li>		
							</ol>
							<!-- carousel_indicators ends -->
							<div class="carousel-inner">
								<div class="carousel-item active">
									<img class="img-fluid" src="admin/<?php echo $product['image1'];?>">
								</div>
								<!-- image one ends -->
								<div class="carousel-item ">
									<img class="img-fluid" src="admin/<?php echo $product['image2'];?>">
								</div>
								<!-- image two ends --->
								<div class="carousel-item ">
									<img class="img-fluid" src="admin/<?php echo $product['image3'];?>">
								</div>
								<!-- image three ends -->
							</div>
						</div>
						<!-- end of product image slide shows -->
					</div>
					<!-- end of carousel-container -->

					<!-- add to cart starts here -->
					<div class="col-md-5">
						<div class="card">
							<div class="card-body">
								<h3>
									<?php echo $product['name'];?>
								</h3>
								<div class="">
									<!-- display product price -->
									$<?php echo $product['price'];?>
								</div>
							</div>
							<div class="card-footer">
								<div class="text-center btn-group ">
					              <a id="save_item" href="#" class="btn btn-sm btn-outline-secondary">Save <span class="ti-heart"></span> </a>
					              <button id="add_to_cart" class="btn btn-sm btn-info">add to <i class="ti-shopping-cart"></i> </button>
					              <i class="ml-1" id="added_'.$product['id'].'" >
					              </i><?php echo $tick;?>
					            </div>
					            <script type="text/javascript">
					            	// save item for later view
					            	var save_item_button = document.getElementById("save_item");
					            	save_item.addEventListener("click",function(){
					            		var add_to_saved_item;
					            		if (window.XMLHttpRequest) {add_to_saved_item = new XMLHttpRequest();}else{add_to_saved_item= new ActiveXObject("Microsoft.XMLHTTP");}
					            		add_to_saved_item.open("GET","include/add_to_saved_items.php?product_id=<?php echo $product['id'];?>",true);
					            		add_to_saved_item.onload = function(){window.alert(add_to_saved_item.responseText);}
					            		add_to_saved_item.send();
					            	})
					            </script>
							</div>
						</div>
						<!-- add to cart ends -->
						<!-- slide external controls -->
						<div class="mt-4">
							<div class="card-body p-1">
								<div class="btn-group" data-slider-id="product_image_slide">									
				                    <li data-target="#product_image_slide" data-slide-to="0" class="navbar-nav"> <a href="#" class="m-1"><img style="max-height:70px; " class="img-fluid" alt="" src="admin/<?php echo $product['image1'];?> "></a></li>
				                    <li data-target="#product_image_slide" data-slide-to="1" class="navbar-nav"> <a href="#" class="m-1"><img style="max-height:70px; " class="img-fluid" alt="" src="admin/<?php echo $product['image2'];?>"></a></li>
				                    <li data-target="#product_image_slide" data-slide-to="2" class="navbar-nav"> <a href="#" class="m-1"><img style="max-height:70px; " class="img-fluid" alt="" src="admin/<?php echo $product['image3'];?>"></a></li>
				                	
                  				</div>
							</div>
						</div>
						<!-- slide external controls ends here -->
					</div>
					
				</div>
				<!-- product description starts  -->
		<div class="row mt-4">
			<div class="col-md-8">
				<div class="card bg-light">
					<div class="m-4">
						<h4>
							<?php echo $product['name'];?>
							<hr>
						</h4>
						<div>
							<div class="text-center">
						<!-- ratings -->
						<?php 
							$i=0;
							$rating = $product['rating'];
							while ($i < $rating) :
								$rating -= 1;
						?>
						<i class="fas fa-star"></i>	
						<?php endwhile;?>
							</div>
						</div>
					</div>
					<div class="m-2 py-5 text-center">
						<?php echo $product['description'];?>
					</div>
				</div>
			</div>
		<!-- product discription ends -->
		</div>
		<?php include("include/end_category.php");?>
		</div>
	
</div>


<script type="text/javascript">

  // add to cart ======================add to cart
    var add_button = document.getElementById("add_to_cart");
    add_button.addEventListener("click",function(add_to_cart){

    var request_ ;
    // cross browser compartibility
    if(window.XMLHttpRequest){request_ = new XMLHttpRequest(); }
    else{request_ = new ActiveXObject("Microsoft.XMLHTTP");}

      request_.open("GET","include/add_to_cart.php?product_id=<?php echo$product_id;?>");
      request_.onload = function(){document.getElementById("added_'.$product['id'].'").innerHTML = request_.responseText;}
      request_.send();
    })


  // update cart in header=======update  cart in header

  var add_button = document.getElementById("add_to_cart");
  add_button.addEventListener("click",function(update_header){

    var update_request;
    if(window.XMLHttpRequest){update_request = new XMLHttpRequest(); }else{update_request = new ActiveXObject("Microsoft.XMLHTTP");}

    update_request.open("GET","include/update_header.php?product_id=<?php echo$product_id;?>",true)
    update_request.onload = function(){document.getElementById("cart_items").innerHTML = update_request.responseText ;}
    update_request.send();
  })
</script>
  
<?php include("include/footer.php");?>