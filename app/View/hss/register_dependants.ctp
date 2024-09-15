<?php
$fatherName = $dependantsInfo['Dependant']['father_name'];
$fatherAge = $dependantsInfo['Dependant']['father_age'];
$motherName = $dependantsInfo['Dependant']['mother_name'];
$motherAge = $dependantsInfo['Dependant']['mother_age'];
$spouseName = $dependantsInfo['Dependant']['spouse_name'];
$spouseAge = $dependantsInfo['Dependant']['spouse_age'];
$child1Name = $dependantsInfo['Dependant']['child1_name'];
$child1Age = $dependantsInfo['Dependant']['child1_age'];
$child2Name = $dependantsInfo['Dependant']['child2_name'];
$child2Age = $dependantsInfo['Dependant']['child2_age'];
$child3Name = $dependantsInfo['Dependant']['child3_name'];
$child3Age = $dependantsInfo['Dependant']['child3_age'];

?>
<section data-bs-version="5.1" class="article11 cid-uijVs7rZbF pt-0" id="article11-1a">
	<div class="container">
		<div class="row justify-content-start">
			<div class="title col-md-12">
				<div class="text-end small">
					<a href="/hss/registration_payment_details" class="">Previous Registrations &raquo;</a>
					<a href="/hss/dependants" class="ms-2">Manage Dependants &raquo;</a>
				</div>
				<h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2 mt-3">
					<strong>Register Dependants</strong>
				</h3>

				<div class="text-end">
					<a href="/hss/dependants" class="btn btn-primary rounded-pill">Add dependants &raquo;</a>
				</div>

				<?php echo $this->Form->create(null, array( 'type' => 'file')); ?>
				<div class="mt-4">
					<div class="row">
						<div class="col-12 col-md-6">
							<h4>Register your dependants for the event.</h4>
							<div class="mt-3">
								<div>Register each dependant to secure their spot for the upcoming event. Please complete the registration by making a payment of Rs.1000 per dependant. This fee will help cover event expenses and ensure a memorable experience for all attendees. We look forward to reconnecting and celebrating together! </div>
							</div>

							<h4 class="mt-4">Payment Details:</h4>
							<ul>
								<li><b>Entry Fee:</b> Rs.1000/- per dependant</li>
								<li><b>Due Date:</b> 22-Dec-2024</li>
								<li><b>Payment Method:</b> PhonePe / Google Pay / Bank Transfer</li>
							</ul>

							<div class="mt-4 text-start p-4 bg-light mb-4" style="border-radius: 1.5rem; !important;">
								<div class="fw-bold mb-2 text-center">
									Select Dependants
								</div>
								<div class="mb-4">
									<input type="hidden" name="data[Dependant][father]" value="0">
									<input type="hidden" name="data[Dependant][mother]" value="0">
									<input type="hidden" name="data[Dependant][spouse]" value="0">
									<input type="hidden" name="data[Dependant][child1]" value="0">
									<input type="hidden" name="data[Dependant][child2]" value="0">
									<input type="hidden" name="data[Dependant][child3]" value="0">

									<table>
										<tbody>
										<?php
										if (!empty($fatherName)) {
											?>
											<tr>
												<td>
													<div class="form-check">
														<input name="data[Dependant][father]" class="form-check-input" type="checkbox" value="1" id="father" onchange="setDependantsCount()" checked>
														<label class="form-check-label" for="father">
															<?php echo $fatherName; ?> (Father, <?php echo $fatherAge; ?> yrs)
														</label>
													</div>
												</td>
											</tr>
											<?php
										}
										if (!empty($motherName)) {
											?>
											<tr>
												<td>
													<div class="form-check">
														<input name="data[Dependant][mother]" class="form-check-input" type="checkbox" value="1" id="mother" onchange="setDependantsCount()" checked>
														<label class="form-check-label" for="mother">
															<?php echo $motherName; ?> (Mother, <?php echo $motherAge; ?> yrs)
														</label>
													</div>
												</td>
											</tr>
											<?php
										}
										if (!empty($spouseName)) {
											?>
											<tr>
												<td>
													<div class="form-check">
														<input name="data[Dependant][spouse]" class="form-check-input" type="checkbox" value="1" id="spouse" onchange="setDependantsCount()" checked>
														<label class="form-check-label" for="spouse">
															<?php echo $spouseName; ?> (Spouse, <?php echo $spouseAge; ?> yrs)
														</label>
													</div>
												</td>
											</tr>
											<?php
										}

										if (!empty($child1Name)) {
											?>
											<tr>
												<td>
													<div class="form-check">
														<input name="data[Dependant][child1]" class="form-check-input" type="checkbox" value="1" id="child1" onchange="setDependantsCount()" checked>
														<label class="form-check-label" for="child1">
															<?php echo $child1Name; ?> (Child, <?php echo $child1Age; ?> yrs)
														</label>
													</div>
												</td>
											</tr>
											<?php
										}

										if (!empty($child2Name)) {
											?>
											<tr>
												<td>
													<div class="form-check">
														<input name="data[Dependant][child2]" class="form-check-input" type="checkbox" value="1" id="child2" onchange="setDependantsCount()" checked>
														<label class="form-check-label" for="child2">
															<?php echo $child2Name; ?> (Child, <?php echo $child2Age; ?> yrs)
														</label>
													</div>
												</td>
											</tr>
											<?php
										}

										if (!empty($child3Name)) {
											?>
											<tr>
												<td>
													<div class="form-check">
														<input name="data[Dependant][child3]" class="form-check-input" type="checkbox" value="1" id="child3" onchange="setDependantsCount()" checked>
														<label class="form-check-label" for="child3">
															<?php echo $child3Name; ?> (Child, <?php echo $child3Age; ?> yrs)
														</label>
													</div>
												</td>
											</tr>
											<?php
										}
										?>
										</tbody>
									</table>
								</div>

								<div class="fw-bold text-center p-2">
									Once the payment is made, please share the transaction details
								</div>

								<input type="hidden" name="data[Payment][type]" value="dependants">

								<label class="ms-2 mt-3">No. of Dependants</label>
								<input
									type="number"
									id="no_of_attendees"
									class="form-control"
									name="data[Payment][no_of_attendees]"
									value="0"
									readonly>

								<label class="ms-2 mt-3">Registration Amount</label>
								<input
									type="number"
									id="payment-transaction-amount"
									class="form-control"
									name="data[Payment][paid_amount]"
									value="0"
									readonly>

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
								<input type="text" id="payment-transaction-id" class="form-control" name="data[Payment][transaction_id]" placeholder="Enter UTR or UPI Transaction ID" required>

								<label for="payment-screenshot" class="mt-4 mb-2 d-block ms-2">Upload Payment Receipt/Screenshot</label>
								<input type="file" id="payment-screenshot" name="data[Payment][screenshot]" class="ms-2" required>

								<div class="mt-4 text-center">
									<button type="submit" class="btn btn-primary rounded-pill" id="dependants_submit">Submit</button>
								</div>

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
				<?php echo $this->Form->end(); ?>

				<div class="text-center d-none">
					<a href="/" class="btn btn-primary btn-lg rounded-pill">Back to Homepage</a>
				</div>

				<br><br><br><br><br>
			</div>
		</div>
	</div>
</section>

<script>
	function setDependantsCount() {
		let count = 0;
		const fatherSelected = $('#father').prop('checked');
		const motherSelected = $('#mother').prop('checked');
		const spouseSelected = $('#spouse').prop('checked');
		const child1Selected = $('#child1').prop('checked');
		const child2Selected = $('#child2').prop('checked');
		const child3Selected = $('#child3').prop('checked');

		count += fatherSelected ? 1 : 0;
		count += motherSelected ? 1 : 0;
		count += spouseSelected ? 1 : 0;
		count += child1Selected ? 1 : 0;
		count += child2Selected ? 1 : 0;
		count += child3Selected ? 1 : 0;

		console.log(count);
		$('#no_of_attendees').val(count);
		$('#payment-transaction-amount').val((count*1000));

		if (count > 0) {
			$('#dependants_submit').removeClass('d-none');
		} else {
			$('#dependants_submit').addClass('d-none');
		}

	}

	function disableBackButton() {
		window.history.forward()
	}
	setDependantsCount();
	disableBackButton();
	window.onload = disableBackButton;
	window.onpageshow = function(evt) { if (evt.persisted) disableBackButton() }
	window.onload = function() {void(0)}
	window.onunload = function() { void(0)}
</script>
