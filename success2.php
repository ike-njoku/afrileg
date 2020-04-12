<?php include("include/header.php");?>
<?php 
// first, you can only access this page by referal
?>
<section class="py-5"></section>
<div class="container-fluid">
	<div class="row">
		<div class="col-12 text-center">
			<?php 
				// pre declear the "message" variable that is going to be the message conveyed per page
				$message ="";
				// make the image to display into a variable too
				$img_displayed = "";

				// /get the referring url... if there is none, redirect to the indexpage.

				if (isset($_SERVER['HTTP_REFERER'])) {
					// get the referring url
					$referer_url = $_SERVER['HTTP_REFERER'];

					// the case scenerios:
					/* if the person  funded their wallet*/
					/* if the person changed their password*/
					/* if the person bought a product>>>>>>>> i: paid with cart. ii: paid from wallet */


					/*password change */
					if ($referer_url == "https://afrileg.herokuapp.com/change_password.php") {
						// these are editable later
						$img_displayed ="<img src='images/tick-loop-1.gif' ><br> ";
						$message ="Your Password has been changed successfully. <br> Click <a href='dashboard.php'> here </a> to retur to your dashboard ";
						
						// display the image and the message:
						echo $img_displayed;
						echo $message;
						return;

						// close the page
					}


					/*funded wallet*/
					if ($referer_url =="https://afrileg.herokuapp.com/fund_wallet.php" ) {

						// check if the person just funded his wallet
						if (isset($_GET['mthd'])) {
							// check the refering page

							
							if($_GET['mthd']="fund_walllet")
							{	
								// define new balance to be zero
								$new_balance = 0;					

								// update the user's wallet balance
								$get_amount_funded= mysqli_query($config,"select * from fund_wallet where customer_id='$customer_id' and paid='0' ");
								if (mysqli_num_rows($get_amount_funded)<1) { 
									// check for foul play
									header("location:fund_wallet.php");return;
								}
								$amount_funded = mysqli_fetch_assoc($get_amount_funded);
								$funded_amount = $amount_funded['amount'];


								// get the customer's current wallet balance
								$get_current_balance = mysqli_query($config,"select * from wallet where customer_id ='$customer_id' ");

						

									$current_balance = mysqli_fetch_assoc($get_current_balance); 
									$wallet_balance = $current_balance['amount'];

									$new_balance = $wallet_balance + $funded_amount;
									
									// update the persons wallet balance with the amount-funded
									$update_wallet_balance = mysqli_query($config,"update wallet set amount ='$new_balance' where customer_id='$customer_id' ");
									if (mysqli_affected_rows($config)>0) {
										// change "paid from 0 to 1 in the fund_wallet table "

										$update_fund_wallet_table = mysqli_query($config,"update fund_wallet set paid='1', regdate = NOW() where customer_id ='$customer_id' and paid='0' ");
										if (mysqli_affected_rows($config)>0) {
											// new balance
											$new_balance = $wallet_balance + $funded_amount;
											$message =  "your new wallet balance is : NGN $new_balance";


											
									
										}else{
											$message = "we are currently experiencing a server-side lag. Please contace our team for help";
										}

									}else{
										$update_fund_wallet_table = mysqli_query($config,"update fund_wallet set paid='1', regdate =NOW() where customer_id ='$customer_id' and paid='0' ");
										if (mysqli_affected_rows($config)>0) {
											// new balance
											$new_balance = $wallet_balance + $funded_amount;
											$message = "your new wallet balance is : NGN $new_balance";
											
									
										}
										
									}
								
								
								echo $img_displayed;
								echo $message;
							}
						}else{
							header("location:index.php");
						}
							
						
					}
						
					
				}	

				else{
					header("location:index.php");
				}

				// end of php scripts
			?>

		</div>
	</div>
</div>