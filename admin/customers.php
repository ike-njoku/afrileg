<?php include("include/header.php");?>
<?php 
	// customers count
	$get_customers = mysqli_query($config,"select * from customers order by username ASC");
	$customer_count = mysqli_num_rows($get_customers);
?>

<div class="container-fluid">
	<?php include("include/menulist.php");?>
	<div  class="mb-4" style="float: right;" > <input id="search_customers" class="form-control" type="search" name="search" placeholder="search customers by username"> </div>
		<div>
			<h1>Customers  <b><?php echo $customer_count;?></b></h1>
		</div>
		</hr>
		<div id="display_search_results" class="container">
			<table class="table">
				<thead>
					<th>User Name</th>
					<th>Eamail</th>
					<th>Status</th>
				</thead>
				<!-- head ends -->

				<tbody>
					
					<?php while ($customer =mysqli_fetch_array($get_customers)):?>
					<tr>
						<td><?php echo $customer['username'];?> </td>
						<td><?php echo $customer['email'];?></td>
						<td><?php echo $customer['active'];?> </td>
					</tr>
					<?php endwhile;?>

				</tbody>
			</table>
		</div>

	<?php include("include/end_menulist.php");?>
</div>

<script type="text/javascript">
	var search_bar = document.getElementById("search_customers");
	search_bar.addEventListener("keyup",function(){
	 var search_for = search_bar.value;
	 var string_length = search_for.length;

	 for (string_length = 0; string_length < 1; string_length++) {
	 	var search_request;
	 	if (window.XMLHttpRequest) {search_request = new XMLHttpRequest();} else {search_request = new ActiveXObject("Microsoft.XMLHTTP"); }
	 	search_request.open("GET","include/customer_search_processor.php?key="+search_for,true);
	 	search_request.onload = function(){document.getElementById("display_search_results").innerHTML = search_request.responseText;}
	 	search_request.send();
	 }

	})

</script>

<?php include("include/footer.php");?>