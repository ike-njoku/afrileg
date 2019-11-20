<?php session_start() ;?>

<?php include("include/connect.php") ;?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Afrileg.com</title>
	<link rel="icon" href="images/favicon.png">
	<meta charset="utf8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!---local bootstrap files--->
	<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">

  <!-- fonts -->
  <link rel="stylesheet" href="fonts/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="fonts/fontawesome/css/fontawesome-all.css">
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="vendor/bootstrap/css/style.css">
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50" >

<?php $cusid = ""; $customer_id = "";
  if (isset($_SESSION['id'])):
    $cusid = $_SESSION['id'];
    $customer_select = mysqli_query($config,"select * from customers where id='$cusid'");
    $customer = mysqli_fetch_assoc($customer_select);
    $customer_id = $customer['id'];
?>
   
<?php 
 // get customer's cart details
    $cart_select = mysqli_query($config,"select * from cart where customer_id='$customer_id' and purchased='0' " );
    $cart_items = mysqli_num_rows($cart_select);
    if ($cart_items>0) {
      $cart_items = $cart_items;
    }else{$cart_items=""; }
?>
	
	
<!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top mb-2">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img class="img-fluid" height="50" width="50" src="images/favicon2.png"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php#newarrivals">New Arrivals
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="shop.php">shop</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cart.php#">cart
                
                <span <?php if($cart_items>0): ?> class="badge badge-info"<?php endif;?> id="cart_items">
                  <?php echo $cart_items;?>
                </span>
                
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php#contactus">Contact Us</a>
            </li>
            <div class="dropdown">
            	<a class="dropdown-toggle btn btn-sm bg-dark"data-toggle="dropdown">
            		<img class="rounded-circle" height =35 width = 35 src="

                <?php if (empty($customer['avatar'])) {
                  echo "images/avatar.png";
                } else{echo $customer['avatar'];}?>">
             
               
            	</a>

              <ul class="bg-light dropdown-menu dropdown-menu-right text-center p-2">

                <a class="" href="dashboard.php">
                  <div class=""> Dashborad </div>
                </a>
                <a class="nav-item" href="saved_items.php">
                  <div class=""> Saved Items </div>
                </a>
                <a class="nav-item" href="cart.php">
                  <div class=""> Cart </div>
                </a>
                <a href="logout.php">
                  log out
                </a>
              </ul>
            </div>
          </ul>
        </div>
      </div>
    </nav>

	<?php else: ?>
	
<!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top mb-2">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img class="img-responsive" height="50" width="50" src="images/favicon2.png"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php#newarrivals">New Arrivals
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="shop.php">shop</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cart.php">cart</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php#contactus">Contact Us</a>
            </li>
            <div class="btn-group">
            	<a href="signup.php" class="btn btn-small btn-sm btn-outline-secondary">sign up</a>
            	<a data-toggle="modal" data-target="#login_modal" href="#" class="btn btn-small btn-sm btn-outline-secondary">log in</a>
            </div>
          </ul>
        </div>
      </div>
    </nav><div id="login_modal" class="modal fade">
  <div class="modal-dialog col-md-4">
    <div class="modal-content">
      <div class="card">
        <div class=" text-center card-header alert alert-info py-4">
          <h4>
            <hr>
            <b>Welcome to a world of unlimited African Print Options</b><br>
            <hr>
          </h4>
        </div>
        <div class="dialog-body">
          <div class="mt-2">
          <form method="post" class="form-group p-2 ">
                <label for="email" class="sr-only"> Email </label>
                <input id="login_email" placeholder="Email" class="form-control" type="text" name="email" required>
                <label id="login_password" for="password" class="sr-only"> Password </label>
                <input placeholder="password" class="form-control mt-2 " type="password" name="password" required>
          </div>   
        </div>
        <div class="dialog-footer p-4 ">
          <div class="m-1">
                <button name="login" class="btn btn-sm btn-outline-secondary form-control "> login</button> 
          </div>
            </form>
            <hr>
              <div class="sm text-right">
                <span class="sm"><b class="sm">... Slay the African Way</b></span>
              </div>
        </div>
        <!-- end of footer -->
      </div>
      <!-- end of card -->
    </div>  
  </div>
</div>

<?php 
  $err="";
  if (isset($_POST['login'])) {
    $email=$_POST['email'];
  $password=md5(md5($_POST['password']));

  // search for a match in the database
  $qry=mysqli_query($config,"select * from customers where email='$email' " );
  if ($qry) {
    $customer=mysqli_fetch_assoc($qry);
    if ($password==$customer['password']) {
      if ($customer['active']==1  or $customer['active']==2 ) {
        $_SESSION['id']=$customer['id'];
        header("location:index.php");
      }else{$err= '<div class="alert alert-warning p-2 mb-2 text-center">Your account is inactive <p class="small"> activate your account by clicking the link that was sent to your email </p> </div>';}
      
    }else{$err='<div class="alert alert-warning p-2 mb-2 text-center">invalid log in details</div>';}

  }else{$err='<div class="alert alert-warning p-2 mb-2 text-center">Account not found</div>';}
  }
 
?>
<?php endif;?>

