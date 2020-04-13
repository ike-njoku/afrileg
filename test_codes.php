<?php include("include/connect.php");?>

<?php 

	function add_column($table_name,$column_name,$data_type)
	{	
		// include db_connection
		include("include/connect.php");

		if (isset($config)) {
			echo "database connection successful <br>";
		}
		// add column (amount) to fund_wallet table
		$add_column_amount = mysqli_query($config,"alter table $table_name add $column_name $data_type ");

		if ($add_column_amount) {
			echo " column $column_name was successfully added to $table_name";
		}else{
			echo "could not add $column_name to $table_name";
		}
	}
?>

<?php 
	// cerate column ( amount ) in fund_wallet
	$table_name = 'fund_wallet';
	$column_name ='amount';
	$data_type ='varchar(220)';
	add_column($table_name,$column_name,$data_type);


	// create column ( address ) to delivery_details
	$table_name ="delivery_details";
	$column_name = "address";
	$data_type "longtext";
	add_column($table_name,$column_name,$data_type);


	// add column( regdate ) to fund_wallet
	$table_name ="fund_wallet";
	$column_name = "regdate";
	$data_type "datetime";
	add_column($table_name,$column_name,$data_type);


	// add column( regdate ) to fund_wallet
	$table_name ="saved_items";
	$column_name = "customer_type";
	$data_type "varchar(225)";
	add_column($table_name,$column_name,$data_type);
	

?> 