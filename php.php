<?php 
// when ever your'e done executing the code in this script, delete it.
?>


<?php /*
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
	*/
?>



<?php
// Function to get the client IP address
// function get_client_ip() {
//     $ipaddress = '';
//     if (isset($_SERVER['HTTP_CLIENT_IP']))
//         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
//     else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
//         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
//     else if(isset($_SERVER['HTTP_X_FORWARDED']))
//         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
//     else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
//         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
//     else if(isset($_SERVER['HTTP_FORWARDED']))
//         $ipaddress = $_SERVER['HTTP_FORWARDED'];
//     else if(isset($_SERVER['REMOTE_ADDR']))
//         $ipaddress = $_SERVER['REMOTE_ADDR'];
//     else
//         $ipaddress = 'UNKNOWN';

//     echo $ipaddress;
//     return $ipaddress;

// }


// get_client_ip();


?>

<?php 
	// if (isset($_COOKIE['guest_id'])) {
	// 	echo $_COOKIE['guest_id'];
	// }else{
	// 	$cookie_value= crc32(1);
	// 	$cookie_name = "guest_id";
	// 	// create cookie
	// 	$create_cookie = setcookie($cookie_name,$cookie_value);
	// 	// check if it worked
	// 	if ($create_cookie) {
	// 		echo $_COOKIE['guest_id'];
			
	// 		// destroy cookies
	// 		$destroy_cookie = setcookie($cookie_name,$cookie_value,time()-1);
	// 		if ($destroy_cookie) {
	// 			echo "your cookie has successfully been destroyed";
	// 		}
	// 	}
	// }

?>

<?php
	// create_table function:
	
	function create_table($table_name, $columns){


		// include the database connection:
		$include_db_connection = include("include/connect.php");
		if ($include_db_connection) {
			echo "database connection successful"."<br>";
			// create the table_query
			$create_table_query = "create table ".$table_name." (
				".$columns."

			) ;";

			// inbuilt function>>> merging the query with the sql
			$create_table_mysqli = mysqli_query($config,$create_table_query);
			// error messages 
			if ($create_table_mysqli) {
				echo "table successfully created <br>";
			}else{
				echo "table could not be created because: <br>";
				// check if the table name and columns were specified
				if (strlen($table_name)<1) {
					echo "the table name was not specified<br>";
				}
				if (strlen($columns)<1) {
					echo "the column parameters were not defined <br>";
				}

			}



		}else{
			echo "Database connection error <br>";
		}

	}
?>

<?php 

	create guests table
	
	$table_name ="gurests"; #set the table_name

	$columns ="
		id int NOT NULL AUTO_INCREMENT,

		guest_id varchar(225),

		PRIMARY KEY(ID)
	";

	create_table($table_name,$columns);
?>



<?php 
	// create_column function
	// function alter_table($table_name,$alter_sql)
	// {
	// 	// include the path to the database
	// 	$create_database_connection=include("include/connect.php");

	// 	// verify that the database was created
	// 	if ($create_database_connection) {

	// 		$alter_table_sql = "alter table".$table_name." ".$alter_sql."";

	// 		$alter_table_mysqli_function = mysqli_query($config,$alter_table_sql);
	// 		if ($alter_table_mysqli_function) {

	// 			echo "update successful";
	// 		}else{

	// 			echo "update unsuccessful";
	// 		}
	// 	}else{
	// 		echo "database connectio successful";
	// 	}
	// }
?>


<?php 
	// call the alter table cunction
	// $column1_name = "homophobe";
	// $column1_datatype="varchar(225) ";
	// $table_name = "cart";
	// $alter_sql = "add column".$column1_name." "."$column1_datatype";

	// alter_table($table_name,$alter_sql);

	include("include/connect.php");

	$add_column = mysqli_query($config,"alter table cart add column customer_type varchar(225) ");

	if($add_column){
		echo "successfully updated cart <br> ";
	}else{
		echo "table(cart) update unsuccessful <br>";
	}

	$add_column = mysqli_query($config,"alter table orders add column customer_type varchar(225) ");

	if($add_column){
		echo "successfully updated orders <br>";
	}else{
		echo "table(orders) update unsuccessful <br>";
	}

	$add_column = mysqli_query($config,"alter table saved_items add column everything varchar(225) ");

	if($add_column){
		echo "successfully updated saved_items <br>";
	}else{
		echo "table(saved_items) update unsuccessful <br>";
	}
?>