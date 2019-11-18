<div class="row">
		<div class="alert alert-info py-3 col-md-2">
			<div class="sticky-top">
				Statistics
				<hr>
				<a href="customers.php"> Customers</a>
				<hr>
				<a href ="messages.php"> messages </a>
				<hr>
				view products
				<hr>
				<a href = "create.php">create products </a>
				<hr>
				<div class="d-flex justify-content-between">
					<a>
						orders	
					</a>
					<span id="orders_dropdown" class="badge badge-secondary">
						+
					</span>
				</div>
				<hr>
				<div style="display: none;" id="display_orders_list">
					<div><a href="new_orders.php"> New Orders </a></div><br>
					<div><a href="sorted_orders.php">Sorted Orders</a></div><br>
					<div><a href="#shipped_orders.php"> Shipped </a></div>
				</div>
			</div>
		</div>
<script type="text/javascript">	
	document.getElementById("orders_dropdown").addEventListener("click",function(){
		document.getElementById("display_orders_list").style.display = "block";
	})
</script>
		<!-- main starts here -->
		<div class="col">
			<div>