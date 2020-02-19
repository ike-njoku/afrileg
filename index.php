<?php include("include/header.php");?>

<?php 

// contact us
    $err="";
  if (isset($_POST['sendmsg'])) {
    $firstname=$_POST['firstname'];
    $email=$_POST['email'];
    $subject=$_POST['subject'];
    $message=$_POST['message'];
    // insert the info into the database
    $qry=mysqli_query($config, "insert into message(firstname,email,subject,message,regdate) values('$firstname','$email','$subject','$message',NOW() ) ");
    if (mysqli_affected_rows($config)>0) {
      $err='<div class="alert alert-success text-center p-2 mb-2 mt-1"> Your message has been sent  </div>';
    }else{$err='<div class="alert alert-danger text-center p-2 mb-2 mt-1"> Unable to send message at this time </div>';}
  }

;?>

<section class="bg-image-full">
    <div class="py-5" style="height: 30%;">
      	<img style="max-width:100%;min-width:100%;max-height:25%;" src="images/slider1.jpg">
    </div>
</section>

    <div class="container-fluid">
      <div class="row slideup p-2 bg-white">
        <div class="col-md-4 text-center">
          <div class="icon">
            <h1 class="ti-gift"></h1>
          </div>
          <h4>giftcards</h4>
          <p class="lead">
            your smiles keep us going. therefore, we constantly work round the clock to ensure you are satisfied with our services. get coupons codes to keep you smiling 
          </p>
        </div>
        <div class="col-md-4 text-center animated">
          <div class="icon">
            <h1 class=" ti-truck "></h1>
          </div>
          <h4>free Delivery</h4>
          <p class="lead">
            Enjoy free delivery within Nigeria and various other selected locations and highly discounted delivery rates to locations around the world.
          </p>
        </div>
        <div class="col-md-4 text-center"> 
          <div class="icon">
            <h1 class=" ti-lock "></h1>
          </div>
          <h4>Secure Payments </h4>
          <p class="lead">
            We Leave the Security to the professionals. All your payments are secured by Rave by Flutterwave. Welcome to a secure payment option.
          </p>
        </div>
      </div>
    </div>

<!-- new arrivals -->
<section id="newarrivals" class="py-5">
  <div class="container-fluid bg-light py-5 text-center">
    <h1 class="m-3" > New Arrivals </h1>
    <hr>
    <div class="row">
    <?php 
    // display new arrivals
    $arqry=mysqli_query($config,"select * from products order by id DESC LIMIT 8 ");
    while($product= mysqli_fetch_array($arqry))
    {$product_name = $product['name'];
      $product_id = $product['id'];
      $product_price = $product['price'];

      // display which products are in your cart by tick
      // /// display which products are in your cart by tick
    $tick = "";  
    $tick_products = mysqli_query($config,"select * from cart where customer_id = '$customer_id' and product_id = '$product_id' and purchased='0' "); 
    if (mysqli_num_rows($tick_products)) {
      $tick = '<span class="far fa-check-circle success"></span>';
    }
    // tick ends
      
      include("include/index_products_template.php");
      }
    ?>
    </div>


    </div>
    <!-- product row stops -->
  </div>
</section>

<!-- home page carousel -->
<div class="container-fluid">
  <div class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="img-responsive img-fluid" src="images/slider3.jpg"> 
      </div>
      <div class="carousel-item">
        <img class="img-responsive img-fluid" src="images/slider2.png"> 
      </div>
    </div>
  </div>
</div>
<hr id="contactus">

<!-- contact us -->
<section class="container-fluid py-5">
  <div class="header">
    <h1>Contact Us</h1>
    <hr>
  </div>
  <div class="container-fluid">
    <div class="py-5">
      <div class="row d-flex justify-content-between mb-4">
        <div class="col-md-6 mb-4 mt-4 pr-4 pl-4">
          
          <h2 class="lead" ><span class="ti-location-pin "></span> Where to find us?</h2><hr>
          <div class="text-left">
            <h4 class="lead">Suit 16,<br>
            Little Africa Lodge, Umuchima<br>
            By Legacy Hotel,<br>
            Off F.U.T.O rd,<br>
            Ihiagwa, Owerri West L.G.A <br>
            Imo State, Nigeria.</h4><hr>
            <div class="justify-content-between">
              <span class=" fas fa-phone"><span class="lead"> +2348038686694</span> </span><br>
              <!-- social -->
              <p class="text-right mt-3">
                <a href="https://fb.me/afrileg" class="btn btn-sm"><b><span class="fab fa-facebook-f"></span></b></a>
                <a href="#" class="btn btn-sm"><b><span class="fab fa-twitter"></span></b></a>
                <a href="#" class="btn btn-sm"><b><span class="fab fa-instagram"></span></b></a>
              </p>
            </div>
          </div>

        </div>
        <div class="col-md-6 mb-4 mt-4">
          <div class="card">
            <div class="card-header badge-info py-5 text-center">
              <h1 class="">Leave a Message </h1>
            </div>
            <div class="card-body p-3">
            <form method="post" class="form-group p-3">
              <?php echo $err;?>
              <label for="firstname" class="sr-only"> First Name </label>
              <input class="form-control mt-4 mb-2 " type="text" name="firstname" placeholder="First Name" required >
              <label for="email" class="sr-only" > Email </label>
              <input class="form-control mb-2 " type="email" name="email" placeholder="Email" required>
              <label for="subject" class="sr-only"> Subject </label>
              <input class="form-control mb-2 " type="text" name="subject" placeholder="Subject" required>
              <label for="message" class="sr-only"> Message </label>
              <textarea  class="form-control mb-2 " type="text" name="message" placeholder="Message" required ></textarea>
          </div>
          <div class="card-footer py-5 ">
              <button name="sendmsg" class="btn btn-sm btn-outline-secondary form-control "> 
                send 
              </button> 
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>  




<?php include("include/footer.php");?>