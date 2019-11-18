<?php include("connect.php");?>

<?php 
	if (isset($_GET['key'])) {
		$suggestion = $_GET['key'];
	}
?>


<!-- table is copied from customers.php -->
<table class="table">
	<thead>
		<th>User Name</th>
		<th>Eamail</th>
		<th>Status</th>
	</thead>
	<!-- head ends -->

<?php $get_suggestion = mysqli_query($config,"select * from  customers where username like '$suggestion%' "); if(mysqli_num_rows($get_suggestion)):?>
	<?php while ($customer = mysqli_fetch_array($get_suggestion)):?>

	<tbody>
		
		
		<tr>
			<td><?php echo $customer['username'];?> </td>
			<td><?php echo $customer['email'];?></td>
			<td><?php echo $customer['active'];?> </td>
		</tr>
		
	<?php endwhile?>
<?php else :?>
<div class="alert alert-info py-5 text-center">
	No Such customer was found
</div>	
<?php endif;?>
	</tbody>
</table>


		