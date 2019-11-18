<?php echo '
			<div class="container">
				<div class="row">
					<div  class="mb-4 col-md-4" style="float: right;" > <input id="search_bar" class="form-control" type="search" placeholder="search transaction id"> </div>
				</div>

<script type="text/javascript">
	//programming the search bar
	var search_bar = document.getElementById("search_bar");
	search_bar.addEventListener("keyup",function(){

		var search_request;
		if(window.XMLHttpRequest){search_request=new XMLHttpRequest();}else{search_request = new ActiveXObject("Microsoft.XMLHTTP");}
		search_request.open("GET","include/search_tracking_id.php?search_for="+search_bar.value,true);
		search_request.onreadystatechange = function(){
			if (search_request.readyState==4 && search_request.status == 200) {
				document.getElementById("display_search_results").innerHTML= search_request.responseText;
			}
		}
		search_request.send();
	})
</script>
				<div id="display_search_results" class="row mb-4"></div>

';
?>