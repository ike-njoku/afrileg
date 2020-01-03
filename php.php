<?php 
// when ever your'e done executing the code in this script, delete it.
?>


<?php 
	function create_table_function($table_name,$columns)
	{
		//you have to specify the names of the table and columns that you want to create
		

		// sql statement to create the table
		$create_table = "create table  ".$table_name." 
		(
			".$columns."
		) 
		";


		// include the path to the database connection;
		include("include/connect.php");

		// php/mysqli to actually create the table with the sql statement above

		$cretae_table_query = mysqli_query($config,$create_table);

		if ($cretae_table_query) {
			echo $table_name ." table created successfully <br>";
		}else{
			echo $table_name. " unable to create table at this momnet <br>";
		}
	}
?>

<?php 
	// create table for wallet
	$table_name = "wallet";
	$columns = "id int(16) NOT NULL AUTO_INCREMENT, customer_id varchar(225), amount varchar(225), PRIMARY KEY(id) ";
	// call the function:

	create_table_function($table_name,$columns);

	// create orders table
	$table_name = "orders";
	$columns = "id int(15) NOT NULL AUTO_INCREMENT,customer_id varchar(225), tracking_id varchar(225), regdate datetime, processing int(2) NOT NULL, shipped int(2) NOT NULL, fulfilled int(2) NOT NULL, grand_total int(2), PRIMARY KEY(id) ";

	create_table_function($table_name,$columns);


	// create coupons table;
	$table_name = "coupons";
	$columns = "id int(15) NOT NULL AUTO_INCREMENT, customer_id varchar(225), used int(2)NOT Null, code varchar(30), order_id varchar(225), value varchar(225), event varchar(225), PRIMARY KEY(id) ";
	create_table_function($table_name,$columns);
?>

