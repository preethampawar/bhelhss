<link rel="stylesheet" href="/lightbox2/dist/css/lightbox.min.css">
<style>
	body {
		background-color: #fff9e6 !important;
	}
</style>
<section data-bs-version="5.1" class="form5 cid-uie1F6KRbz pt-0" id="register-form">


	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 content-head">
				<div class="mbr-section-head mb-5">
					<h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2">
						<strong>Member Payments</strong>
					</h3>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-12 mx-auto mbr-form">
				<div class="text-end pe-3 mb-2">
					<a href="/hss/alumni_members" class="">Back to Members List &nbsp;&raquo;</a>
				</div>
				<div class="p-3 text-black bg-light" style="border-radius: 1.5rem;">
					<div class="p-3 text-black bg-white" style="border-radius: 1.5rem;">
						<div class="row">
							<div class="col-md-3">
								Member ID:
								<p class="mt-2 fw-bold"><?php echo $alumniMemberInfo['AlumniMember']['id']; ?></p>
							</div>
							<div class="col-md-3">
								Member Name:
								<p class="mt-2 fw-bold"><?php echo $alumniMemberInfo['AlumniMember']['name']; ?></p>
							</div>
							<div class="col-md-3">
								Email Address:
								<p class="mt-2 fw-bold"><?php echo $alumniMemberInfo['AlumniMember']['email']; ?></p>
							</div>
							<div class="col-md-3">
								Phone No.:
								<p class="mt-2 fw-bold"><?php echo $alumniMemberInfo['AlumniMember']['phone']; ?></p>
							</div>

						</div>
					</div>

					<div class="mbr-section-head mt-4">
						<?php
						if ($payments) {
							?>
							<div class="table-responsive">
								<table class="table text-center" style="text-justify: auto">
									<thead>
									<tr>
										<th>#</th>
										<th>Payment Type</th>
										<th>No. of Attendees</th>
										<th>Dependants</th>
										<th>Mentioned Amount</th>
										<th>Credited Amount</th>
										<th>Transaction ID/Screenshot</th>
										<th>Payment Verified</th>
										<th>Date</th>
										<th></th>
									</tr>
									</thead>
									<tbody>
									<?php
									$i = 0;
									foreach ($payments as $payment) {
										$i++;
										$paymentId = $payment['Payment']['id'];
										$type = $payment['Payment']['type'];
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

										$attedeesCount = $payment['Payment']['no_of_attendees'];
										$paidAmount = $payment['Payment']['paid_amount'];
										$verifiedAmount = $payment['Payment']['verified_amount'] ? $payment['Payment']['verified_amount'] : '-';
										$transactionId = $payment['Payment']['transaction_id'];
										$transactionFile = $payment['Payment']['transaction_file'];
										$transactionFile2 = $payment['Payment']['transaction_file2'];
										$paymentConfirmed = $payment['Payment']['payment_confirmed']
											? '<span class="text-success fw-bold">Verified</span>'
											: '<span class="text-danger fw-bold">No</span>';
										$createdDate = date('d-m-Y', strtotime($payment['Payment']['created']));

										$extraInfo = $payment['Payment']['extra_info'];
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
										<tr>
											<td><?php echo $i; ?>.</td>
											<td><?php echo $paymentType; ?></td>
											<td><?php echo $attedeesCount; ?></td>
											<td><?php echo $registeredDependants; ?></td>
											<td><?php echo $paidAmount; ?></td>
											<td><?php echo $verifiedAmount; ?></td>
											<td>
												<?php echo $transactionId; ?>
												<?php
												if (!empty($transactionFile)) {
													?>
													<a class="example-image-link d-block mt-3"
													   href="/payments/<?php echo $transactionFile; ?>"
													   data-lightbox="example-<?php echo $i; ?>">
														<img src="/payments/<?php echo $transactionFile; ?>"
															 alt="Screenshot" class="img-thumbnail"
															 style="width: 250px;">
													</a>
													<?php
												}
												if (!empty($transactionFile2)) {
													?>
													<p class="mt-4 fw-bold">Screenshot updated by Admin</p>
													<a class="example-image-link d-block"
													   href="/payments/<?php echo $transactionFile2; ?>"
													   data-lightbox="example-<?php echo $i; ?>">
														<img src="/payments/<?php echo $transactionFile2; ?>"
															 alt="Screenshot" class="img-thumbnail"
															 style="width: 250px;">
													</a>
													<?php
												}

												?>
											</td>

											<td><?php echo $paymentConfirmed; ?></td>
											<td><?php echo $createdDate; ?></td>
											<td style="width: 90px;" class="text-center">
												<a href="/hss/update_member_payment/<?php echo $paymentId; ?>"
												   class="text-decoration-underline">
													Update
												</a>
											</td>
										</tr>
										<?php
									}
									?>
									</tbody>
								</table>
							</div>
							<?php
						} else {
							?>
							No payments found.
							<?php
						}
						?>


					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script src="/lightbox2/dist/js/lightbox-plus-jquery.min.js"></script>
