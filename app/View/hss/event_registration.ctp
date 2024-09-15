<section data-bs-version="5.1" class="article11 cid-uijVs7rZbF pt-0" id="article11-1a">
	<div class="container">
		<div class="row justify-content-start">
			<div class="title col-md-12">
				<div class="text-end small">
					<a href="/hss/registration_payment_details" class="">Previous Registrations &raquo;</a>
					<a href="/hss/register_dependants" class="ms-2">Register Dependants &raquo;</a>
					<a href="/hss/donations" class="ms-2">Donations &raquo;</a>
				</div>
				<h1 class="mbr-section-title mbr-fonts-style align-center mt-3 mb-0 display-2">
					<strong>Event Registration</strong>
				</h1>

				<div class="mt-4">
					<h4>Join Us for the Alumni Reunion!</h4>
					<div class="mt-3">
						We are excited to invite you to our upcoming Alumni Reunion event. To secure your spot, please complete your registration by making a payment of Rs.1500. This fee will help cover event expenses and ensure a memorable experience for all attendees. We look forward to reconnecting and celebrating together!
					</div>
					<h4 class="mt-4">Payment Details:</h4>
					<ul>
						<li><b>Entry Fee:</b> Rs.1500/- per head</li>
						<li><b>Due Date:</b> 22-Dec-2024</li>
						<li><b>Payment Method:</b> PhonePe / Google Pay / Bank Transfer</li>
					</ul>
					<div class="row">
						<div class="col-12 col-md-8 mb-4 mx-auto">
							<div class="text-start p-4 bg-light" style="border-radius: 1.5rem; !important;">
								<div class="fw-bold mb-2 text-center fs-4">
									Once the payment is made, please share the transaction details
								</div>

								<?php echo $this->Form->create(null, array( 'type' => 'file')); ?>
								<input type="hidden" name="data[Payment][type]" value="event_registration_fee">

								<div class="row">
									<div class="col-md-3">
										<label for="no-of-attendees" class="ms-2 mt-3">No. of attendees</label>
										<select
											name="data[Payment][no_of_attendees]"
											required="required"
											class="form-control form-select"
											id="no-of-attendees"
											style="line-height: 1.55rem !important;"
											onchange="setAmount()"
										>
											<?php
											for ($i=1; $i <=10; $i++) {
												?>
												<option value="<?php echo $i; ?>">
													<?php echo $i; ?>
												</option>
												<?php
											}
											?>
										</select>
									</div>
									<div class="col-md-9">
										<label class="ms-2 mt-3">Event Fee</label>
										<input
											type="number"
											id="payment-transaction-amount"
											class="form-control"
											name="data[Payment][paid_amount]"
											value="1500"
											required
											readonly
											onchange="setAmount()">
									</div>
								</div>

								<label class="ms-2 mt-3 d-block">Donation Amount</label>

								<button
									type="button"
									id="d-5000"
									class="btn btn-outline-success btn-sm ms-2 me-0 py-1 px-2 d-amount"
									style="min-height: auto !important; border-radius: 15px;"
									onclick="setDonationAmount(5000)">5,000</button>
								<button
									type="button"
									id="d-10000"
									class="btn btn-outline-success btn-sm ms-1 me-0 py-1 px-2 d-amount"
									style="min-height: auto !important; border-radius: 15px;"
									onclick="setDonationAmount(10000)">10,000</button>
								<button
									type="button"
									id="d-15000"
									class="btn btn-outline-success btn-sm ms-1 me-0 py-1 px-2 d-amount"
									style="min-height: auto !important; border-radius: 15px;"
									onclick="setDonationAmount(15000)">15,000</button>
								<button
									type="button"
									id="d-any"
									class="btn btn-outline-success btn-sm ms-1 me-0 py-1 px-2 d-amount"
									style="min-height: auto !important; border-radius: 15px;"
									onclick="$('#payment-donation-amount').val('');
										$('#payment-donation-amount').focus();
										resetDonationButtons();
										$('#d-any').addClass('btn-success');
										setTotalAmount();">
									Other
								</button>
								<button
									type="button"
									id="d-not-now"
									class="btn btn-outline-secondary btn-sm ms-2 me-0 py-1 px-1"
									style="min-height: auto !important; border-radius: 15px;"
									onclick="setDonationAmount(0)">Not Now</button>
								<input
									type="number"
									id="payment-donation-amount"
									class="form-control"
									name="data[Donation][paid_amount]"
									value="5000"
									required
									onchange="setDonationAmount($('#payment-donation-amount').val())">

								<label for="payable-amount-id" class="ms-2 mt-3">Total Amount Payable</label>
								<input
									type="text"
									id="payable-amount-id"
									class="form-control fw-bolder"
									placeholder="Total payable amount"
									disabled>

								<div class="mt-4">
									<h6 class="fw-bold text-center">Please make the payment using the following bank account details or by scanning the QR code</h6>
									<div class="alert btn-secondary text-center">
										<b>Beneficiary Name:</b> BHEL HIGHER SECONDARY SCHOOL ALUMNI ASSOCIATION</b><br>
										<b>Bank name:</b> Bank of Baroda</b><br>
										<b>Bank A/c No -</b> 89690100004880</b><br>
										<b>IFSC code -</b> BARB0VJCHAN</b>
									</div>
								</div>

								<div class="text-center">
									<img src="/img/payment_qr_code.png" class="img-thumbnail mt-3 mx-auto" style="width: 400px;">
									<a href="/img/bhelhssaa_payment_qr_code.png" class="mt-1 btn btn-info btn-sm rounded-pill" download>
										<img width="16" height="16" src="/img/icon-download.png" alt="" style="width: 16px;" class="me-1" >
										Download QR Code
									</a>
								</div>

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

								<label for="payment-transaction-id" class="ms-2 mt-2">Enter UTR or UPI Transaction ID / Reference No.
									<span class="badge bg-warning small rounded-circle mb-1"
									   title="Click to know about UTR or UPI Transaction ID"
									   role="button"
									   data-bs-toggle="modal"
									   data-bs-target="#staticBackdrop">
										?
									</span>
								</label>
								<input type="text" id="payment-transaction-id" class="form-control" name="data[Payment][transaction_id]" placeholder="Enter UTR or UPI Transaction ID" required>
								<!-- Button trigger modal -->



								<label for="payment-screenshot" class="mt-4 mb-2 d-block ms-2">Upload Payment Receipt/Screenshot</label>
								<input type="file" id="payment-screenshot" name="data[Payment][screenshot]" class="ms-2" required>

								<div class="mt-4 text-center">
									<button type="submit" class="btn btn-primary rounded-pill">Submit</button>
								</div>

								<?php echo $this->Form->end(); ?>

							</div>
						</div>
					</div>
				</div>

				<br><br>
			</div>
		</div>
	</div>
</section>

<script>
	function setAmount() {
		let attendeesCount = $('#no-of-attendees').val();
		let amountPaid = attendeesCount * 1500;
		$('#payment-transaction-amount').val(amountPaid);

		setTotalAmount();
	}

	function setDonationAmount(amount='') {
		amount = parseInt(amount);

		if (isNaN(amount)) {
			setTotalAmount();
			return;
			// amount = $('#payment-donation-amount').val();
		}

		if (amount == 0) {
			$('#payment-donation-amount').val(0);
		} else if (amount > 0) {
			$('#payment-donation-amount').focus();
		}

		amount = parseInt(amount);

		if (amount == 1000) {
			$('#payment-donation-amount').val(1000);
			resetDonationButtons();
			$('#d-1000').addClass('btn-success');
		} else if (amount == 2000) {
			$('#payment-donation-amount').val(2000);
			resetDonationButtons();
			$('#d-2000').addClass('btn-success');
		} else if (amount == 5000) {
			$('#payment-donation-amount').val(5000);
			resetDonationButtons();
			$('#d-5000').addClass('btn-success');
		} else if (amount == 10000) {
			$('#payment-donation-amount').val(10000);
			resetDonationButtons();
			$('#d-10000').addClass('btn-success');
		} else if (amount == 15000) {
			$('#payment-donation-amount').val(15000);
			resetDonationButtons();
			$('#d-15000').addClass('btn-success');
		} else if (amount == 0) {
			$('#payment-donation-amount').val(0);
			resetDonationButtons();
			$('#d-not-now').addClass('btn-secondary');
		} else {
			resetDonationButtons();
		}

		setTotalAmount();
	}

	function setTotalAmount() {
		let eventFee = parseInt($('#payment-transaction-amount').val())
		let donationAmount = parseInt($('#payment-donation-amount').val())
		eventFee = isNaN(eventFee) ? 0 : eventFee;
		donationAmount = isNaN(donationAmount) ? 0 : donationAmount;
		const totalAmount = eventFee + donationAmount;
		$('#payable-amount-id').val(totalAmount);
		$('#payable-amount-id2').val(totalAmount);
	}

	function resetDonationButtons()	{
		$('#d-1000').removeClass('btn-success');
		$('#d-2000').removeClass('btn-success');
		$('#d-5000').removeClass('btn-success');
		$('#d-10000').removeClass('btn-success');
		$('#d-15000').removeClass('btn-success');
		$('#d-any').removeClass('btn-success');
		$('#d-not-now').removeClass('btn-secondary');
		$('#d-1000').addClass('btn-outline-success');
		$('#d-2000').addClass('btn-outline-success');
		$('#d-5000').addClass('btn-outline-success');
		$('#d-10000').addClass('btn-outline-success');
		$('#d-15000').addClass('btn-outline-success');
		$('#d-any').addClass('btn-outline-success');
		$('#d-not-now').addClass('btn-outline-secondary');
	}

	$(document).ready(function() {
		setAmount();
		setDonationAmount(0);
	})
</script>

<script>
	function disableBackButton(){
		window.history.forward()
	}

	disableBackButton();
	window.onload = disableBackButton;
	window.onpageshow = function(evt) { if (evt.persisted) disableBackButton() }
	window.onload = function() {void(0)}
	window.onunload = function() { alert('he'); void(0)}
</script>
