<?php
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
		      	<div class=" col-12 col-sm-6 col-lg-4 mb-4">
		        	<div class="card text-center mb-2">
		          		<div class="card-header text-center">
		            	'.$product['name'].'
		          	</div>
	          		<div class="card-body bg-white">
		           	 	<a href="view_product.php?product_id='.$product['id'].'"><img style="min-height:150px; max-width:100%;  max-height:150px" 	class="card-image" alt="'.$product['name'].' " src="admin/'.$product['image1'].'" ></a>
		          	</div>
		          	<div class="card-footer p-1">
		            	<div class=" p-1">
		              		NGN '.$product['price'].' 
		              	</div>
		              	<div>
		                	<i class="ti-star "></i>
			                <i class="ti-star "></i>
			                <i class="ti-star "></i>
			                <i class="ti-star "></i>
			                <i class="ti-star "></i>
		            	</div>
		            	<div class="text-center btn-group ">
              <a href="view_product.php?product_id='.$product['id'].'"   class="btn btn-sm btn-outline-secondary">view detail</a>';

		              if($product['inventory']>0){ echo '
		              <button id="product_'.$product['id'].'" class="btn btn-sm btn-info">add to <i class="ti-shopping-cart"></i> </button>
		              <i class="ml-1" id="added_'.$product['id'].'" >
		                '.$tick.'
		              </i>
		              ';} else{echo '<button class="btn btn-sm btn-info disabled btn-disabled">out of stock</button>';}
		echo'       </div>
		            

		          </div>
		        </div>
		      </div>

<script type="text/javascript">

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
    update_request.onreadystatechange = function(){
    	if(update_request.readyState==4 && update_request.status==200) {
    		document.getElementById("cart_items").innerHTML = update_request.responseText ;
    	}
    }
    update_request.send();
  })
</script>
  '
  ;?>

