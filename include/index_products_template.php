 <?php echo'
 <!-- product -->
      <div class="col-6 col-sm-6 col-lg-3 mb-4">
        <div class="card mb-2">
          <div class="card-body text-center">
            '.$product['name'].'
            <hr>
          
              <a href="view_product.php?product_id='.$product['id'].'"><img style=" max-width:100%;  max-height:150px" class="img-fluid" alt="'.$product['name'].' " src="admin/'.$product['image1'].'" ></a>
          
          <hr>
            <div class="sm p-1">
              NGN '.$product['price'].' 
            </div>
            <div class="sm" >
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
      request_.onreadystatechange = function()
      {
        if(request_.readyState==4 &&request_.status ==200)
        {document.getElementById("added_'.$product['id'].'").innerHTML = request_.responseText;}
      }
      request_.send();

    })


  // update cart in header=======update cart in header

  var add_button = document.getElementById("product_'.$product['id'].'");
  add_button.addEventListener("click",function(update_header){

    var update_request;
    if(window.XMLHttpRequest){update_request = new XMLHttpRequest(); }else{update_request = new ActiveXObject("Microsoft.XMLHTTP");}

    update_request.open("GET","include/update_header.php?product_id='.$product_id.'",true)
    update_request.onreadystatechange = function()
    {
      if(update_request.readyState==4 && update_request.status==200)
      {document.getElementById("cart_items").innerHTML = update_request.responseText ;} else{
        // window.location.assign("index.php");
      }

    }
    update_request.send();
  })
</script> 
'
;?>