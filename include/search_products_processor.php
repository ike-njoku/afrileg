<?php include("connect.php");?>
<?php 
	if (isset($_GET['key'])) {
		$suggestion = $_GET['key'];
	} 
?>
<?php if(strlen($suggestion)<1) {return;}?>


<?php $get_product = mysqli_query($config,"select * from products where name like '$suggestion%'");?>

<?php if(mysqli_num_rows($get_product)):?>
	<?php while($product = mysqli_fetch_array($get_product)):?>
		<?php $subsubcat_id = $product['sub_sub_category_id'];?>
		<?php $get_sub_sub_categories = mysqli_query($config,"select * from sub_sub_category where id='$subsubcat_id' ") ;while($sscat=mysqli_fetch_assoc($get_sub_sub_categories)):?>
		<div>
			<a href="view_product.php?product_id=<?php echo $product['id'];?>">
				<img height="30" width="30" src="admin/<?php echo $product['image1'];?>">
				<?php echo $product['name'];?> </a>
				   in 	<a href="shop.php?sscat_id=<?php echo $sscat['id'];?> "><?php echo $sscat['name']; ?></a>
		</div>
		<?php endwhile?>
	<?php endwhile ;?>

<?php else :?>
	<div>There is no result for this search</div>
<?php endif;?>


