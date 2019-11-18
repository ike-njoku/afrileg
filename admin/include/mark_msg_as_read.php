<?php session_start();?>
<?php include("connect.php");?>
<?php 
	if (isset($_GET['msg_id'])) {
		$msg_id = $_GET['msg_id'];

		// update message table
		$mark_as_read = mysqli_query($config,"update message set viewed = '1' where id ='$msg_id' ");
		if ($mark_as_read) {
			// count how many messages are unread
			$unread_msg = mysqli_query($config,"select * from message where viewed='0' ");
			$unread_msg_count = mysqli_num_rows($unread_msg);
			echo $unread_msg_count;
		}
	}
?>