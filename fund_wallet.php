<?php include("include/header.php");?> 

<?php
	//get the customer's wallet balance
	$get_wallet_balance = mysqli_query($config,"select * from wallet where customer_id = '$customer_id' ");
	$customer_wallet_balance = mysqli_fetch_assoc($get_wallet_balance); 
?>
	<section class="py-5"></section>
	
	<div class="container_fluid p-3">
		<div class="row justify-content-center">
			<div class="col-md-12 text-center">
				<div class="card">
					<div class="card-header py-5 alert alert-info">

					</div>
					<div class="card-body">
						<div class="Lead"> Pay for products directly from your online wallet:</div>
						your wallet balnce is <?php echo $customer_wallet_balance['amount'];?><br>

						<button id="display_payment_form" class="btn btn-group btn-small btn-primary">Fund your Wallet</button>
						<div style="display: none" id="payment_form">
							<div class="row">
								<div class="col-md-12">
									<form method="post">
										<input id="amount_to_pay" class="form-control" type="number" name="amount_to_pay">
										<div class="btn-gorup">
											<button class="btn btn-sm btn-secondary">Cancel</button>

											<script type="text/javascript">

												// hide or display the payment form
												document.getElementById("display_payment_form").addEventListener("click",function(){
												// hide the display form button
												document.getElementById("display_payment_form").style.display = "none";
													document.getElementById("payment_form").style.display ="block";
												})

											</script>
											<form>
												<?php 
												// this is the payment method for rave.flutterwave
												?>
											    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
											    <button id="payment_button" class="btn btn-secondary  btn-info" type="button" onClick="payWithRave()">Pay with card <i class="ti-wallet"></i> </button>
											</form>
											<a href="success.php?mthd=fund_wallet" id="fund_click" name="fund_wallet" type="submit" class="btn btn-sm btn-primary">fund</a>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
					</div>
				</div>
			</div>
		</div>
	</div>



<section class="py-5"></section>

<div class="fixed-bottom">
	<?php include("include/footer.php");?>
</div>

<script>
    const API_publicKey = "FLWPUBK-d021b72dd1b6caf08bf9df2828dc6666-X";

    function payWithRave() {
    	var amount_to_fund = document.getElementById('amount_to_pay').value;
        var x = getpaidSetup({
            PBFPubKey: API_publicKey,
            customer_email: "<?php echo $customer['email'];?>",
            amount:amount_to_fund,
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
                	window.location.href = "success.php" ;//later, change this to grand-total
                } else {
                    // redirect to a failure page.
                    window.location.href ="failed.php";
                }

                x.close(); // use this to close the modal immediately after payment.
            }
        });
    }
    
</script>