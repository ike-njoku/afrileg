<?php session_start();?>
<?php include("connect.php");?>

<?php 
	if (isset($_GET['msg_id'])) {
		$msg_id = $_GET['msg_id'];

		// update the message table

		$mark_as_unread = mysqli_query($config,"update message set viewed ='0' where id ='$msg_id' ");
		if ($mark_as_unread) {
			echo "this message has been marked as unread. please reload this page to view changes";
		}
	}
?>