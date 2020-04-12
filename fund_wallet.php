<?php include("include/header.php");?> 
<?php
	//redirect if the person is not a regisgered customer
	$get_registered_customer = mysqli_query($config,"select * from customers where id='$customer_id' ");
	if (mysqli_num_rows($get_registered_customer)<1) {
		header("location:index.php");
	}
?>

<?php
	//get the customer's wallet balance
	$get_wallet_balance = mysqli_query($config,"select * from wallet where customer_id = '$customer_id' ");
	$customer_wallet_balance = mysqli_fetch_assoc($get_wallet_balance); 
?>
	<section class="py-5"></section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header alert alert-info py-5 ">
						<b><h1>Fund Wallet</h1></b>
					</div>
					<div class="card-body">
						pay for products from your wallet and get discounts and extra bonuses
						<hr>
						<div class="form-group">
							<div class="justify-content-center">
								<div>
									<form>
										<?php 
										// this is the payment method for rave.flutterwave
										?>
										<div class="row">
											<div class="col-xs-6 col-md-6">
												<input class="form-control" id="amount_to_pay" type="number" name="">
											</div>
												<script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>

										   <div class="col-xs-6 col-md-6">
											    <button id="payment_button" style="display: none;" class="btn btn-secondary mt-1 btn-block btn-info" type="button" onClick="payWithRave()">Pay with card <i class="ti-wallet"></i> </button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div><a href="success2.php?mthd=fund_wallet">pay</a>
				</div>
			</div>
		</div>
	</div>
<script type="text/javascript">
	document.getElementById("amount_to_pay").addEventListener("keyup",function(){
		if (document.getElementById("amount_to_pay").value.length < 1) {document.getElementById("payment_button").style.display = "none";}else{document.getElementById("payment_button").style.display ="inline";}
	})
</script>

<script type="text/javascript">
	document.getElementById("amount_to_pay").addEventListener("keyup",function(){
		var update_fund_request;
		if (window.XMLHttpRequest) {update_fund_request = new XMLHttpRequest();}else{update_fund_request = new ActiveXObject("Microsoft.XMLHTTP")}
		update_fund_request.open("GET","include/fund_wallet_processor.php?key="+amount_to_pay.value,true);
		update_fund_request.send();
	})
</script>


<?php include("include/footer.php");?>

<script>
    const API_publicKey = "FLWPUBK-d021b72dd1b6caf08bf9df2828dc6666-X";

    function payWithRave() {
    	// declare the value that the person is entering as a variable
    	var amount_to_pay = document.getElementById("amount_to_pay").value;

        var x = getpaidSetup({
            PBFPubKey: API_publicKey,
            customer_email: "<?php echo $customer['email'];?>",
            amount: amount_to_pay,
            customer_phone: "234099940409",
            currency: "NGN",
            txref: "rave-123456",
            meta: [{
                metaname: "flightID",
                metavalue: "AP1234"
            }],
            onclose: function() {},
            callback: function(response) {
                var txref = response.tx.txRef; // collect txRef returned and pass to a 					server page to complete status check.
                console.log("This is the response returned after a charge", response);
                if (
                    response.tx.chargeResponseCode == "00" ||
                    response.tx.chargeResponseCode == "0"
                ) {
                    // redirect to a success page
                	window.location.href = "success2.php?mthd=fund_wallet" ;//later, change this to grand-total
                } else {
                    // redirect to a failure page.
                    window.location.href ="failed.php";
                }

                x.close(); // use this to close the modal immediately after payment.
            }
        });
    }
    
</script>
