<section data-bs-version="5.1" class="article11 cid-uijVs7rZbF pt-0" id="article11-1a">
	<div class="container">
		<div class="row justify-content-start">
			<div class="title col-md-12">
				<div class="text-end">
					<a href="/hss/donation_details" class="">Previous Donations &nbsp;&raquo;</a>
					<a href="/hss/event_registration" class="ms-2">Event Registration &nbsp;&raquo;</a>
				</div>
				<h1 class="mbr-section-title mbr-fonts-style align-center mt-3 mb-0 display-2">
					<strong>Donations</strong>
				</h1>

				<div class="mt-4">
					<div class="row">
						<div class="col-12 col-md-6">
							<h4>Every contribution makes a significant impact.</h4>
							<div class="mt-3">
								<div>As we continue our efforts to maintain and improve our beloved school, we kindly seek your support. Donations will help cover event expenses and fund key initiatives of the Alumini Association.</div>

								<div class="mt-3">Your generosity, no matter the amount, will make a meaningful difference in keeping our school community alive and vibrant.</div>

								<div class="mt-3">Thank you for considering this request. Together, we can continue to create a positive impact on our school community.</div>
							</div>
							<h4 class="mt-4">Payment Details:</h4>
							<ul>
<!--								<li><b>Donation Amount:</b> Any amount will help.</li>-->
<!--								<li><b>Due Date:</b> N/A</li>-->
								<li><b>Payment Method:</b> PhonePe / Google Pay</li>
							</ul>

							<div class="mt-4 text-start p-4 bg-light mb-4" style="border-radius: 1.5rem; !important;">
								<div class="fw-bold mb-4 text-center">Once the payment is made, please share the transaction details</div>

								<?php echo $this->Form->create(null, array( 'type' => 'file')); ?>
								<input type="hidden" name="data[Payment][type]" value="donation">

								<label class="ms-2 mt-3">Donation Amount</label>
								<input
									type="number"
									id="payment-transaction-amount"
									class="form-control"
									name="data[Payment][paid_amount]"
									value="5000"
									required>

								<!-- Modal -->
								<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-scrollable">
										<div class="modal-content">
											<div class="modal-header">
												<h1 class="modal-title fs-5" id="staticBackdropLabel">
													UTR or UPI Transaction ID / Reference No.
												</h1>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body text-center">
												<h5 class="fw-bold">PhonePe</h5>
												<img src="/img/utr_screenshots/phonepe.jpg" alt="UTR or UPI Transaction ID on PhonePe"
													 class="img-thumbnail">

												<h5 class="mt-5 fw-bold">Google Pay</h5>
												<img src="/img/utr_screenshots/gpay.jpeg" alt="UTR or UPI Transaction ID on Google Pay"
													 class="img-thumbnail">

												<h5 class="mt-5 fw-bold">Paytm (or) UPI Apps</h5>
												<img src="/img/utr_screenshots/paytm.jpg" alt="UTR or UPI Transaction ID on Google Pay"
													 class="img-thumbnail">
												<br><br>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-primary btn-sm rounded-pill" data-bs-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>

								<label for="payment-transaction-id" class="ms-2  mt-3">UTR or UPI Transaction ID / Reference No.
									<span class="badge bg-warning small rounded-circle mb-1"
										  title="Click to know about UTR or UPI Transaction ID"
										  role="button"
										  data-bs-toggle="modal"
										  data-bs-target="#staticBackdrop">
										?
									</span>
								</label>
								<input type="text" id="payment-transaction-id" class="form-control" name="data[Payment][transaction_id]" placeholder="Enter UTR or UPI Transaction ID">

								<label for="payment-screenshot" class="mt-4 mb-2 d-block ms-2">Upload Payment Receipt/Screenshot</label>
								<input type="file" id="payment-screenshot" name="data[Payment][screenshot]" class="ms-2">

								<div class="mt-4 text-center">
									<button type="submit" class="btn btn-primary rounded-pill">Submit</button>
								</div>

								<?php echo $this->Form->end(); ?>

							</div>
						</div>
						<div class="col-12 col-md-6 text-center">
							<div class="">
								<h6 class="fw-bold text-center">Please make the payment using the following bank account details or by scanning the QR code</h6>
								<div class="alert btn-secondary text-center">
									<b>Beneficiary Name:</b> BHEL HIGHER SECONDARY SCHOOL ALUMNI ASSOCIATION</b><br>
									<b>Bank name:</b> Bank of Baroda</b><br>
									<b>Bank A/c No -</b> 89690100004880</b><br>
									<b>IFSC code -</b> BARB0VJCHAN</b>
								</div>
							</div>

							<img src="/img/payment_qr_code.png" class="img-thumbnail">
							<a href="/img/payment_qr_code.png" class="mt-3 btn btn-info rounded-pill" download>Download QR Code</a>
						</div>
					</div>

					<div class="d-none">
						Thank you for your support, and we can't wait to see you there!
					</div>
				</div>


				<div class="text-center d-none">
					<a href="/" class="btn btn-primary btn-lg rounded-pill">Back to Homepage</a>
				</div>

				<br><br><br><br><br>
			</div>
		</div>
	</div>
</section>

<script>
	function disableBackButton(){
		window.history.forward()
	}

	disableBackButton();
	window.onload = disableBackButton;
	window.onpageshow = function(evt) { if (evt.persisted) disableBackButton() }
	window.onload = function() {void(0)}
	window.onunload = function() { void(0)}
</script>
