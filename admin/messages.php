<?php include("include/header.php");?>
<div class="container-fluid">
	<?php include("include/menulist.php");?>
	<?php if($unread_msg>0): ?>
	<h1> Unread messages </h1><hr>
	<?php endif;?>
		<div class="container">
			<div class="row text-center mb-4">
			<?php $getallunread = mysqli_query($config,"select * from message where viewed = 0 "); while($unread_messages = mysqli_fetch_array($getallunread)):?>
				
				<div id="dismiss_display<?php echo $unread_messages['id'];?>" class="col-md-6 mb-4">
					<div class="card text-left">
						<div class="text-right">
							<button id="dismiss_btn<?php echo $unread_messages['id'];?>" class=" m-2 rounded-circle btn btn-sm fas fa-times"></button>
						</div>
						<div class="card-body">
							<h6><b>From:</b>  <?php echo $unread_messages['firstname']; ?> </h6>
							<hr>
							<div class="d-flex justify-content-between">
								<?php echo $unread_messages['subject']; ?>
								<button id="read_new<?php echo $unread_messages['id'];?>" class=" btn-primary btn-sm fas fa-chevron-down"></button>
							</div>
							<div id="display_unread_msg<?php echo $unread_messages['id'];?>" style="display: none;" class="p-2">
								<?php echo $unread_messages['message'];?>
								<div class="text-right">
									<button id="colapse_unread_msg<?php echo $unread_messages['id'];?>" class="btn btn-sm fas fa-chevron-up"></button>
								</div>
							</div>
						</div>
						<div class="card-footer text-right">
							<?php echo $unread_messages['regdate'];?>
						</div>
					</div>
				</div>
		
		<!-- end of message -->

<script type="text/javascript">
	document.getElementById("read_new<?php echo $unread_messages['id'];?>").addEventListener("click",function(){
		// hide the button and drop down:
		document.getElementById("display_unread_msg<?php echo $unread_messages['id'];?>").style.display="block";
		document.getElementById("read_new<?php echo $unread_messages['id'];?>").style.display="none";
	})

	//ajax to set the message as read
	document.getElementById("read_new<?php echo $unread_messages['id'];?>").addEventListener("click",function(){
		var mark_as_read;
		if (window.XMLHttpRequest) {mark_as_read= new XMLHttpRequest();} else{mark_as_read= new ActiveXObject("Microsoft.XMLHTTP");}
		mark_as_read.open("GET","include/mark_msg_as_read.php?msg_id=<?php echo $unread_messages['id'];?>",true);
		mark_as_read.onload = function(){document.getElementById("msg_count").innerHTML = mark_as_read.responseText;}
		mark_as_read.send();
	})


	document.getElementById("colapse_unread_msg<?php echo $unread_messages['id'];?>").addEventListener("click",function(){
		document.getElementById("display_unread_msg<?php echo $unread_messages['id'];?>").style.display="none";
		document.getElementById("read_new<?php echo $unread_messages['id'];?>").style.display="inline";
	})

	// dismiss messages:
	document.getElementById("dismiss_btn<?php echo $unread_messages['id'];?>").addEventListener("click",function(){
		document.getElementById("dismiss_display<?php echo $unread_messages['id'];?>").style.display="none";
	})

</script>

			<?php endwhile;?>
		</div>
	</div>

	<?php $alltheunreadmsg = mysqli_query($config,"select * from message where viewed = '1' "); if(mysqli_num_rows($alltheunreadmsg)):?>
	<h1>Previous Messages</h1><hr>
	<?php endif;?>

	<div class="container">
		<div class="row mt-3">
		<?php $getallread = mysqli_query($config,"select * from message where viewed=1 order by regdate DESC"); while($allread = mysqli_fetch_array($getallread)):?>
		
		<div class="col-md-6 mb-4">
			<div class="card">
				<div class="card-body">
					<h6><b>from:</b> <?php echo $allread['firstname'];?></h6>
					<hr>
					<div class="d-flex justify-content-between">
						<?php echo $allread['subject'];?>
						<button id="expand_msg<?php echo $allread['id'];?>" class="btn btn-sm fas fa-chevron-down"></button>	
					</div>
					<div id="display_msg<?php echo $allread['id'];?>" style="display:none;" class="p-2">
						<?php echo $allread['message'];?>
						<div class="text-right">
							<button id="collapse<?php echo $allread['id']?>" class="btn btn-sm fas fa-chevron-up"></button>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button id="mark_msg<?php echo $allread['id'];?>_as_unread" class="btn btn-sm btn-primary">
						mark as unread
					</button>
					<div class="sm text-right"><?php echo $allread['regdate'];?></div>
				</div>
			</div>	
		</div>

<script type="text/javascript">
	var expand_btn =document.getElementById("expand_msg<?php echo $allread['id'];?>");
	var display_box = document.getElementById("display_msg<?php echo $allread['id'];?>");
	var collapse_btn = document.getElementById("collapse<?php echo $allread['id']?>");


	expand_btn.addEventListener("click",function(){
		if (document.getElementById("display_msg<?php echo $allread['id'];?>").style.display="none") 
			{document.getElementById("display_msg<?php echo $allread['id'];?>").style.display="block";document.getElementById("expand_msg<?php echo $allread['id'];?>").style.display="none";}
	})

	document.getElementById("collapse<?php echo $allread['id']?>").addEventListener("click",function(){
		if (document.getElementById("display_msg<?php echo $allread['id'];?>").style.display="block") {document.getElementById("display_msg<?php echo $allread['id'];?>").style.display = "none";document.getElementById("expand_msg<?php echo $allread['id'];?>").style.display = "inline";}
	})

	// mark as unread
	document.getElementById("mark_msg<?php echo $allread['id'];?>_as_unread").addEventListener("click",function(){
		var mark_as_unread;
		if (window.XMLHttpRequest){mark_as_unread = new XMLHttpRequest();}else{mark_as_unread = new ActiveXObject("Microsoft.XMLHTTP");}
		mark_as_unread.open("GET","include/mark_msg_as_unread.php?msg_id=<?php echo $allread['id'];?>",true);
		mark_as_unread.onload = function(){window.alert(mark_as_unread.responseText);}
		mark_as_unread.send();
	})
</script>

		<?php endwhile;?>
		</div>
	</div>
		
	<?php include("include/end_menulist.php");?>
</div>
<?php include("include/footer.php");?>

