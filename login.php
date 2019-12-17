<?php include("include/header.php");?>
<?php 
  $err="";
  if (isset($_POST['login'])) {
    $email=$_POST['email'];
    $password= crc32(md5(md5($_POST['password'])));

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
<section class="py-5"></section>
<div class="container">
  <div class="row">
    <div class="col-md-4">
    </div>

    <div class="col-md-4">
      <div class="py-5">
        <div class="card ">
          <div class=" text-center card-header alert alert-info py-4">
            <h4>
              <hr>
              <b>Welcome to a world of unlimited African Print Options</b><br>
              <hr>
            </h4>
          </div>
        <div class="card-body">
          
        <form method="post" class="form-group p-3">
          <?php echo $err;?>
              <label for="email" class="sr-only"> Email </label>
              <input placeholder="Email" class="form-control mb-2 " type="text" name="email" required>
              <label for="password" class="sr-only"> Password </label>
              <input placeholder="password" class="form-control mb-2 " type="password" name="password" required>
              <div class="mt-4 mb-4">
                <button name="login" class="btn btn-sm btn-outline-secondary form-control "> login</button> 
              </div>
              
              <div class="sm text-right mt-4">
                <hr>
                <span class="sm"><b class="sm">... Slay the African Way</b></span>
              </div>
        </div>
          </form>
      </div>
    </div>
  </div>
    <div class="col-md-4">
    </div>
  </div>
</div>
  

<?php include("include/footer.php");?>