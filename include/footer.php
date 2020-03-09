<?php $check_if_clicked_cookie_pop_up = mysqli_query($config,"select * from guests where guest_id ='$customer_id' and hide_cookie_pop_up='1' "); 
   if(mysqli_num_rows($check_if_clicked_cookie_pop_up)<1):
?>
<?php
// only show this if the person has not clicked it before
?>
<div  class="container-fluid " id="cookie_pop_up">
  <div class="row fixed-bottom">
    <div class="col-md-5 col-md-pull-6 ">
      <div class="card">
        <div class="card-body alert alert-warning">
          <div class="text-right">
            <span id="hide_cookie_pop_up">
              &times
            </span>
          </div>
          Welcome. Afrileg uses cookies to customise your shopping experience and offer you the best possible service.
          <br>
          <a href="#">Learn More</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
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
    
  </body>

</html>


