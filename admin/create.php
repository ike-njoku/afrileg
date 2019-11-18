<?php include("include/header.php");?>

<div class="container-fluid">
<?php include("include/menulist.php");?>

	<div class="row">
			<div class="col-md-4 mb-4">
		<div class="card">
<?php if (isset($_FILES['image1']['name']) and isset($_FILES['image2']['name']) and isset($_FILES['image3']['name'])) {	

	// images
	$image1=$_FILES['image1']['name'];
	$target1="products/".$_FILES['image1']['name'] ;
	

	$image2=$_FILES['image2']['name'];
	$target2='products/'.$image2;
	

	$image3=$_FILES['image3']['name'];
	$target3='products/'.$image3;

	// transfer images to destination folder
	if(move_uploaded_file($_FILES['image3']['tmp_name'] , $target3) and move_uploaded_file($_FILES['image1']['tmp_name'] , $target1) and move_uploaded_file($_FILES['image2']['tmp_name'] , $target2))
		{echo"the images were successflly moved";
			// post the details of the product to the produts database
			if (isset($_POST['submit'])) {
				$name=$_POST['name'];
				$description=$_POST['description'];
				$price=$_POST['price'];
				$inventory=$_POST['inventory'];
				$sscat_id = $_POST['sscat_id'];
				$err ="";


				$insert_ = mysqli_query($config, "insert into products(sub_sub_category_id,name,description,price,inventory,image1,image2,image3) values('$sscat_id','$name','$description','$price','$inventory','$target1','$target2','$target3') " );

				if ($insert_) {
					$err = '<div class="alert alert-info p-3">Product created successfully</div>';
				}else{$err ='<div class= "alert alert-danger p-3">Product could not be created</div>';}
			}

		} 
	else {echo "unsuccessful";}

} 
?>



			<div class="card-header alert alert-info py-5 text-center">
				<h1>Cerate Product</h1>
			</div>
			<div class="card-body p-4">
				<?php echo $err;?>
				<form class="form-group"  method="post" enctype="multipart/form-data" >
				 	category
					<select name="sscat_id" class="p-2 mt-2 mb-2 form-control">
						<?php $getcategory = mysqli_query($config,"select * from category"); while($category=mysqli_fetch_array($getcategory)): $category_id= $category['id'] ?>				
						<optgroup class="form-control" label="category  <?php echo $category['name'];?> ">
							<?php $getsubcategory = mysqli_query($config,"select * from sub_category where category_id = '$category_id' "); foreach ($getsubcategory as  $sub_category): $sub_category_id = $sub_category['id'] ?>									
							<optgroup class="form-control" label=" --subcategory <?php echo $sub_category['name'] ?>">
								<?php $getsubsubcategory= mysqli_query($config,"select * from sub_sub_category where subcategory_id ='$sub_category_id' "); foreach ($getsubsubcategory as $sub_sub_category): ?>
								<option value="<?php echo $sub_sub_category['id'];?>" class="form-control">
									---<?php echo $sub_sub_category['name'];?>
								</option>
							</optgroup>
						</optgroup>
								<?php endforeach;?>
							<?php endforeach;?>
						<?php endwhile;?>	
					</select>
					<hr>

					<input class="form-control mb-2" form-control type="text" name="name" placeholder="name">
					<textarea class="form-control mb-2" name="description" placeholder="description"></textarea> 
					<input class="form-control mb-2" type="text" name="price" placeholder="price">
					<input class="form-control mb-2" type="text" name="inventory" placeholder="inventory">
					<hr>
					
					<label class="sr" for="image1">Image 1<input placeholder="image 1" class="mb-2 form-control" type="file" name="image1"></label>
					<label class="sr" for="image2">Image 2<input placeholder="image 2" class="mb-2 form-control" type="file" name="image2"></label>
					<label class="sr" for="image3">Image 3<input placeholder="image 3" class="mb-2 form-control" type="file" name="image3"></label>
			
			</div>
			<div class="card-footer text-right">
				<button class="btn btn-sm btn-outline-info" type="submit" name="submit">create Product</button>
					
				</form>
			</div>
		</div>
	</div>
	<!-- create product ends -->
		<div class="col-md-4 mb-4">
			<div class="card">
				<div class="card-header py-5">
					<h1>create Category</h1>
				</div>
				<div class="card-body">
					<form>
						<input class="form-control" type="text" name="category_name"placeholder="Category Name">
					</form>
					
				</div>
				<div class="card-footer text-right">
					<button class=" btn btn-sm btn-primary">
						create category
					</button>
				</div>
			</div>
		</div>
		<!-- create category ends -->
	</div>

<?php include("include/end_menulist.php");?>

</div>


<?php include("include/footer.php");?>
