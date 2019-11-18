<?php include("include/header.php");?>
<section class="py-5"></section>

<?php $get_coupons = mysqli_query($config, "select * from  coupons where customer_id='$customer_id' and used='0' ") ;?>
<div class="container-fluid">
	<?php if(mysqli_num_rows($get_coupons)): ?>
	<div class="row justify-content-center">
		<?php while($coupon = mysqli_fetch_array($get_coupons)):?>
		<div class="col-lg-6 mb-4">
			<div class="card">
				<div class="card-header alert alert-info">
					
				</div>
				<div class="card-body">
					This coupon
					<?php if($coupon['event']=='purchase'):?>
						was issued on event of your recent order and
					<?php endif;?>
					 is<b> not transfarable </b> across customers<br>					
				</div>
				<div class="card-footer justify-content-between">
					<div>
						coupon code: 
					<b><?php echo $coupon['code'];?></b>
					</div>
					<div>
						coupon value:
					<b>N<?php echo $coupon['value'];?></b>
					</div>
				</div>
			</div>
		</div>
		<?php endwhile;?>
	</div>
		<?php  else:?>
	<div class="alert alert-info py-5 text-center">
		<section class="py-5">
			you have no coupons. when you do , they will appear here<br>
			click <a href="#">here</a> to return to your dashboard
		</section>
	</div>
	<?php endif;?>

</div>
<div class="fixed-bottom">
	<?php include("include/footer.php");?>
</div>