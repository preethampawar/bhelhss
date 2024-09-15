<?php
$type = $paymentInfo['Payment']['type'];
$paymentType = '-';

if ($type == 'event_registration_fee') {
	$paymentType = 'Event Registration';
}
if ($type == 'donation') {
	$paymentType = 'Donation';
}
if ($type == 'dependants') {
	$paymentType = 'Dependants Fee';
}
$attedeesCount = $paymentInfo['Payment']['no_of_attendees'];
$paidAmount = $paymentInfo['Payment']['paid_amount'];
$verifiedAmount = $paymentInfo['Payment']['verified_amount'] ? $paymentInfo['Payment']['verified_amount'] : '-';
$transactionId = $paymentInfo['Payment']['transaction_id'];
$transactionFile = $paymentInfo['Payment']['transaction_file'];
$paymentConfirmed = $paymentInfo['Payment']['payment_confirmed']
	? '<span class="text-success fw-bold">Verified</span>'
	: '<span class="text-danger fw-bold">No</span>';
$createdDate = date('d-m-Y', strtotime($paymentInfo['Payment']['created']));
$extraInfo = $paymentInfo['Payment']['extra_info'];
$registeredDependants = '';

if (!empty($extraInfo)) {
	$extraInfo = json_decode($extraInfo, true);

	if ($extraInfo['father'] == 1) {
		$registeredDependants .= $extraInfo['record']['Dependant']['father_name'] ?? '';
		$registeredDependants .= ' (Father, ' . $extraInfo['record']['Dependant']['father_age'] . ' yrs) <hr>';
	}
	if ($extraInfo['mother'] == 1) {
		$registeredDependants .= $extraInfo['record']['Dependant']['mother_name'] ?? '';
		$registeredDependants .= ' (Mother, ' . $extraInfo['record']['Dependant']['mother_age'] . ' yrs) <hr>';
	}
	if ($extraInfo['spouse'] == 1) {
		$registeredDependants .= $extraInfo['record']['Dependant']['spouse_name'] ?? '';
		$registeredDependants .= ' (Spouse, ' . $extraInfo['record']['Dependant']['spouse_age'] . ' yrs) <hr>';
	}
	if ($extraInfo['child1'] == 1) {
		$registeredDependants .= $extraInfo['record']['Dependant']['child1_name'] ?? '';
		$registeredDependants .= ' (Child, ' . $extraInfo['record']['Dependant']['child1_age'] . ' yrs) <hr>';
	}
	if ($extraInfo['child2'] == 1) {
		$registeredDependants .= $extraInfo['record']['Dependant']['child2_name'] ?? '';
		$registeredDependants .= ' (Child, ' . $extraInfo['record']['Dependant']['child2_age'] . ' yrs) <hr>';
	}
	if ($extraInfo['child3'] == 1) {
		$registeredDependants .= $extraInfo['record']['Dependant']['child3_name'] ?? '';
		$registeredDependants .= ' (Child, ' . $extraInfo['record']['Dependant']['child3_age'] . ' yrs) ';
	}
}
?>

<style>
	body {
		background-color: #fff9e6 !important;
	}
</style>
<section data-bs-version="5.1" class="form5 cid-uie1F6KRbz pt-0" id="register-form">


	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12">
				<div class="mbr-section-head mb-5">
					<h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2">
						<strong>Update Payment</strong>
					</h3>
				</div>
			</div>
		</div>
		<div class="text-end pe-3 mb-2">
			<a href="/hss/member_payments/<?php echo $paymentInfo['AlumniMember']['id']; ?>" class="">Back &nbsp;&raquo;</a>
		</div>
		<div class="row justify-content-center">
			<div class="p-4 bg-light" style="border-radius: 2rem;">
				<h3><?php echo $paymentType; ?></h3>
				<div class="row mt-4">
					<div class="col-md-4">
						Member Name:
						<p class="mt-2 fw-bold"><?php echo $paymentInfo['AlumniMember']['name']; ?></p>
					</div>
					<div class="col-md-4">
						Email Address:
						<p class="mt-2 fw-bold"><?php echo $paymentInfo['AlumniMember']['email']; ?></p>
					</div>
					<div class="col-md-4">
						Phone No.:
						<p class="mt-2 fw-bold"><?php echo $paymentInfo['AlumniMember']['phone']; ?></p>
					</div>

				</div>

				<div class="table-responsive mt-4">
					<table class="table text-center" style="text-justify: auto">
						<thead>
						<tr>
							<?php
							if ($type != 'donation') {
								?>
								<th>No. of Attendees</th>
								<?php
							}
							?>
							<th>Dependants</th>
							<th>Mentioned Amount</th>
							<th>Credited Amount</th>
							<th>Transaction ID</th>
							<th>Screenshot</th>
							<th>Payment Verified</th>
							<th>Date</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<?php
							if ($type != 'donation') {
							?>
							<td><?php echo $attedeesCount; ?></td>
								<?php
							}
							?>
							<td><?php echo $registeredDependants; ?></td>
							<td><?php echo $paidAmount; ?></td>
							<td><?php echo $verifiedAmount; ?></td>
							<td><?php echo $transactionId; ?></td>
							<td>
								<?php
								if (!empty($transactionFile)) {
									?>
									<a class="example-image-link"
									   href="/payments/<?php echo $transactionFile; ?>"
									   data-lightbox="example-1">
										<img src="/payments/<?php echo $transactionFile; ?>"
											 alt="Screenshot" class="img-thumbnail" style="width: 250px;">
									</a>
									<?php
								} else {
									echo 'N/A';
								}
								?>
							</td>
							<td><?php echo $paymentConfirmed; ?></td>
							<td><?php echo $createdDate; ?></td>
						</tr>
						<?php

						?>
						</tbody>
					</table>
				</div>


				<div class="mt-5">

					<?php echo $this->Form->create(null, array('type' => 'file')); ?>

					<div class="row">
						<?php
						if ($type != 'donation') {
						?>
						<div class="col-12 col-md-4 pt-3">
							<label for="no-of-attendees" class="ms-2">No. of attendees</label>
							<select
								name="data[Payment][no_of_attendees]"
								required="required"
								class="form-control form-select"
								id="no-of-attendees"
								style="line-height: 1.75rem !important;"
							>
								<?php
								$tmpCount = $this->data['Payment']['no_of_attendees'] ?? $attedeesCount;
								for ($i = 1; $i <= 10; $i++) {
									?>
									<option value="<?php echo $i; ?>" <?php echo $i == $tmpCount ? 'selected' : ''; ?>>
										<?php echo $i; ?>
									</option>
									<?php
								}
								?>
							</select>
						</div>
						<?php
						}
						?>
						<div class="col-12 col-md-4 pt-3">
							<label for="payment-transaction-id" class="ms-2">UTR or UPI Transaction ID / Reference No.</label>
							<input
								type="text"
								value="<?php echo $this->data['Payment']['transaction_id'] ?? $transactionId; ?>"
								id="payment-transaction-id"
								class="form-control"
								name="data[Payment][transaction_id]"
								placeholder="Enter UTR or UPI Transaction ID">

						</div>
						<div class="col-12 col-md-4 pt-3">
							<label class="ms-2">Credited Amount</label>
							<input
								type="number"
								value="<?php echo $this->data['Payment']['verified_amount'] ?? $verifiedAmount; ?>"
								id="payment-verified-amount"
								class="form-control"
								name="data[Payment][verified_amount]"
								required>
						</div>
					</div>

					<div class="row mt-4">
						<div class="col-md col-sm-12" data-for="screenshot2">
							<label for="payment-screenshot" class="mb-2 d-block ms-2">Upload Payment Receipt/Screenshot</label>
							<input type="file" id="payment-screenshot" name="data[Payment][screenshot]" class="ms-2">
						</div>
					</div>

					<div class="row mt-4">
						<div class="col-md col-sm-12 form-group mb-3 px-4 fs-4" data-for="number">
							<div class="form-check form-switch">
								<input name="data[Payment][payment_confirmed]" type="hidden" value="0">
								<input
									name="data[Payment][payment_confirmed]"
									class="form-check-input"
									type="checkbox"
									id="flexSwitchCheckDefault"
									value="1"
									<?php echo $paymentInfo['Payment']['payment_confirmed'] == 1 ? 'checked' : ''; ?>>
								<label class="form-check-label" for="flexSwitchCheckDefault">Payment Verified</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md col-sm-12 form-group mb-3 px-4 fs-4" data-for="number">
							<div class="form-check form-switch">
								<input name="data[Payment][send_email]" type="hidden" value="0">
								<input
									name="data[Payment][send_email]"
									class="form-check-input"
									type="checkbox"
									id="flexSwitchCheckDefault2"
									value="1"
								>
								<label class="form-check-label" for="flexSwitchCheckDefault2">Send payment confirmation email</label>
							</div>
						</div>
					</div>

					<div class="mt-4 text-center">
						<button type="submit" class="btn btn-primary rounded-pill">Update</button>
						<a href="/hss/member_payments/<?php echo $paymentInfo['AlumniMember']['id']; ?>"
						   class="btn btn-outline-secondary rounded-pill ms-2">Cancel</a>
					</div>

					<?php echo $this->Form->end(); ?>
				</div>

			</div>
		</div>
	</div>
</section>
<script>
	// function toggleClassInfo() {
	// 	let ele = $('#user-type') ?? false;
	// 	if (ele) {
	// 		let selectedOption = ele.val();
	//
	// 		if (selectedOption === 'student') {
	// 			$('#class-info').removeClass('d-none');
	// 		} else {
	// 			$('#class-info').addClass('d-none');
	// 		}
	// 	}
	// }
	//
	// $(document).ready(function () {
	// 	toggleClassInfo();
	// })
</script>
