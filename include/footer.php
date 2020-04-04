<?php $check_if_clicked_cookie_pop_up = mysqli_query($config,"select * from guests where guest_id ='$customer_id' and hide_cookie_pop_up='1' "); 
   if(mysqli_num_rows($check_if_clicked_cookie_pop_up)<1):
?>
<?php
// only show this if the person has not clicked it before
?>
<section class="container-fluid " id="cookie_pop_up">
  <section class="row fixed-bottom">
    <section class="col-md-5 col-md-pull-6 ">
      <section class="card">
        <section class="card-body alert alert-warning">
          <section class="text-right">
            <span id="hide_cookie_pop_up">
              &times
            </span>
          </section>
          Welcome. Afrileg uses cookies to customise your shopping experience and offer you the best possible service.
          <br>
          <a href="#">Learn More</a>
        </section>
      </section>
    </section>
  </section>
</section>
<?php endif; ?>
<script type="text/javascript">
  // this script hides the cookie pop up
  document.getElementById("hide_cookie_pop_up").addEventListener("click",function(){
    // first, hide the botton, then update the database to show that this particular or user has dismissed the pop up

    // hide the pop_up
    document.getElementById("cookie_pop_up").style.display = "none";

    // ajax call to make the update in the database
    var close_pop_up_request;
    if (window.XMLHttpRequest) {close_pop_up_request = new XMLHttpRequest();}else{close_pop_up_request = new ActiveXObject("Microsoft.XMLHTTP");}
    // open the request
    close_pop_up_request.open("GET","include/close_pop_up_request_processor.php",true);

    // send the request
    close_pop_up_request.send();
  })
</script>
<!-- Footer -->
	<div class="container-fluid">
		<div class="col-sm-12 text-right mt-4">
			<i><b>#slay_the_african_way</b></i>
		</div>
	</div>
    <footer class="p-4 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy;  Afirleg.com <?php echo date("Y");?></p>
      </div>
      <!-- /.container -->
    </footer>

<!-- Bootstrap core JavaScript -->
  

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> 


<script type="text/javascript">
   // make the landing image to span the full height of the screen;
  // get the window_height
  var window_height = window.innerHeight;
  var px = "px";

  document.getElementById("landing_div").style.height = window_height+px;

</script>
    
  </body>

</html>


