<div class="row">
		<div class="py-3 col-md-3 mb-3">
			<div class="sticky-top">

				<div class="mb-4">
					<input id="search_bar" type="search" class="form-control mb-1" placeholder="search all products">
				<div class="p-1 mb-2" id="display_search_results"></div>
				<!-- search ends -->
				<!-- categories -->
						
					<div class="card">
						<div class="jombotron card-header badge-info py-5 ">
							<h4>Categories</h4>
							<hr>
						</div>
						<div class="card-body" >
							<!-- pannel ----------->

							<?php 
							// get the categories
							$getcat= mysqli_query($config,"select * from category");
							
							while ($cat=mysqli_fetch_array($getcat))
								{	
									$cat_id = $cat['id'];
									echo'
										<div class="bg-light p-1">
											'.$cat['name'].'
										</div>
									'."<hr>" ; 

									// get the sub categories
									$getscat=mysqli_query($config,"select * from sub_category where category_id = $cat_id");
									foreach ($getscat as  $value) {
										$scat= $value;
										echo '
											<div class="nav-list" >
												'.$scat['name'].'
											</div>
										';
										$scat_id=$scat['id'];

										$getsscat=mysqli_query($config,"select * from sub_sub_category where subcategory_id='$scat_id' ");
										
										foreach ($getsscat as $value) {
											$sscat=$value;
											$sscat_id = $sscat['id'];
											// count products in each sub_sub_category
											$product_count = mysqli_query($config,"select * from products where sub_sub_category_id = $sscat_id " );
											echo '
												<a id="view'.$sscat_id.'" href="shop.php?sscat_id='.$sscat_id.'">
													<div class="small">
														 <h class="small">	-'.$sscat['name'].'</h> 
														<span style="float:right;" class="badge badge-secondary right ">
															'.mysqli_num_rows($product_count).'
														</span>
													</div>
												</a>
											';
										}
									} echo '<br>';


								}
							?>

							<!-------------- end of pannel -->
						</div>
					</div>
			</div>
		</div>
	</div>

<?php
	// this page displays all the categories and sub categories and sub-sub-categories
	// it is displayed in the cart.php page and the shop.php page

?>

<script type="text/javascript">
	var search_bar = document.getElementById("search_bar");
	search_bar.addEventListener("keyup",function(){
	 var search_for = search_bar.value;
	 var string_length = search_for.length;

		for (var string_lenght = 0; string_lenght < 1; string_lenght++) {
			var search_request;
			if (window.XMLHttpRequest) {search_request = new XMLHttpRequest();}else{search_request = new ActiveXObject("Microsoft.XMLHTTP"); }
			search_request.open("GET","include/search_products_processor.php?key="+search_for,true);
			search_request.onload = function(){document.getElementById("display_search_results").innerHTML = search_request.responseText;}
			search_request.send();
		}
	})
</script>

		<!-- main starts here -->
		<div class="col">
			<div>