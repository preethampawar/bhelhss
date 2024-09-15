<?php
if ($download) {
	$csv = '';
//$csv = ucwords($searchBy) .  "\r\n"  . "\r\n";
	$csv .= implode(',', [
			'Sl.no.',
			'Member ID',
			'Name',
			'Phone',
			'Email',
			'Payment Type',
			'No of Attendees',
			'Dependants',
			'Mentioned Amount',
			'Credited Amount',
			'Transaction ID',
			'Transaction Screenshot',
			'Payment Verified',
			'Payment Date'
		]) . "\r\n";
	if ($payments) {
		$k = 1;
		foreach ($payments as $payment) {
			$paymentId = $payment['Payment']['id'];
			$type = $payment['Payment']['type'];
			$paymentType = '-';

			if ($type == 'event_registration_fee') {
				$paymentType = 'Event Fee';
			}
			if ($type == 'donation') {
				$paymentType = 'Donation';
			}
			if ($type == 'dependants') {
				$paymentType = 'Dependants Fee';
			}

			$attedeesCount = $payment['Payment']['no_of_attendees'];
			$paidAmount = $payment['Payment']['paid_amount'];
			$verifiedAmount = (float)($payment['Payment']['verified_amount'] ? $payment['Payment']['verified_amount'] : '');
			$transactionId = $payment['Payment']['transaction_id'];
			$transactionFile = $payment['Payment']['transaction_file'];
			$paymentConfirmed = $payment['Payment']['payment_confirmed'];
			$extraInfo = $payment['Payment']['extra_info'];
			$registeredDependants = '"';

			if (!empty($extraInfo)) {
				$extraInfo = json_decode($extraInfo, true);

				if ($extraInfo['father'] == 1) {
					$registeredDependants .= $extraInfo['record']['Dependant']['father_name'] ?? '';
					$registeredDependants .= ' (Father, ' . $extraInfo['record']['Dependant']['father_age'] . ' yrs), ';
				}
				if ($extraInfo['mother'] == 1) {
					$registeredDependants .= $extraInfo['record']['Dependant']['mother_name'] ?? '';
					$registeredDependants .= ' (Mother, ' . $extraInfo['record']['Dependant']['mother_age'] . ' yrs), ';
				}
				if ($extraInfo['spouse'] == 1) {
					$registeredDependants .= $extraInfo['record']['Dependant']['spouse_name'] ?? '';
					$registeredDependants .= ' (Spouse, ' . $extraInfo['record']['Dependant']['spouse_age'] . ' yrs), ';
				}
				if ($extraInfo['child1'] == 1) {
					$registeredDependants .= $extraInfo['record']['Dependant']['child1_name'] ?? '';
					$registeredDependants .= ' (Child, ' . $extraInfo['record']['Dependant']['child1_age'] . ' yrs), ';
				}
				if ($extraInfo['child2'] == 1) {
					$registeredDependants .= $extraInfo['record']['Dependant']['child2_name'] ?? '';
					$registeredDependants .= ' (Child, ' . $extraInfo['record']['Dependant']['child2_age'] . ' yrs), ';
				}
				if ($extraInfo['child3'] == 1) {
					$registeredDependants .= $extraInfo['record']['Dependant']['child3_name'] ?? '';
					$registeredDependants .= ' (Child, ' . $extraInfo['record']['Dependant']['child3_age'] . ' yrs) ';
				}
			}

			$registeredDependants .= '"';

			$createdDate = date('d-m-Y', strtotime($payment['Payment']['created']));
			$alumniMemberId = $payment['AlumniMember']['id'];
			$name = $payment['AlumniMember']['name'];
			$email = $payment['AlumniMember']['email'];
			$phone = $payment['AlumniMember']['phone'];


			$tmp = array();
			$tmp[] = $k;
			$tmp[] = html_entity_decode($alumniMemberId);
			$tmp[] = html_entity_decode($name);
			$tmp[] = html_entity_decode($phone);
			$tmp[] = html_entity_decode($email);
			$tmp[] = html_entity_decode($paymentType);
			$tmp[] = html_entity_decode($attedeesCount);
			$tmp[] = html_entity_decode($registeredDependants);
			$tmp[] = html_entity_decode($paidAmount);
			$tmp[] = html_entity_decode($verifiedAmount);
			$tmp[] = html_entity_decode($transactionId);
			$tmp[] = html_entity_decode(Configure::read('DomainUrl') . 'payments/' . $transactionFile);
			$tmp[] = $paymentConfirmed ? 'Verified' : 'Not Verified';
			$tmp[] = html_entity_decode($createdDate) . ' ';
			$csv .= implode(',', $tmp) . "\r\n";
			$k++;
		}
	} else {
		$csv .= 'No members found.';
	}
	echo $csv;
	return;
}
?>

<link rel="stylesheet" href="/lightbox2/dist/css/lightbox.min.css">

<section data-bs-version="5.1" class="form5 cid-uie1F6KRbz pt-0" id="register-form">


	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 content-head">
				<div class="mbr-section-head mb-5">
					<h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2">
						<strong>Payments</strong>
					</h3>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-12 mx-auto mbr-form">
				<div class="text-end">
					<a href="/hss/payments/download" class="btn btn-primary btn-sm">Download All Payments</a>
				</div>
				<div class="px-2 py-2 text-black bg-light" style="border-radius: 1.5rem;">
					<div class="mbr-section-head">
						<?php
						if ($payments) {
							?>
							<div class="row">
								<div class="col-12">
									<div class="dropdown text-start">
										<button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
												id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
											Filter by: <span
												class="fw-bold ms-2"><?php echo ucwords($paymentType ?? 'All Payments'); ?></span>
										</button>
										<ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
											<li>
												<a class="dropdown-item py-2 <?php echo $paymentType == null ? 'active' : '' ?>"
												   href="/hss/payments"> -- All Payments -- </a>
											</li>
											<li>
												<a class="dropdown-item py-2 <?php echo $paymentType == 'Event-Fees' ? 'active' : '' ?>"
												   href="/hss/payments/Event-Fees">Event-Fees</a>
											</li>
											<li>
												<a class="dropdown-item py-2 <?php echo $paymentType == 'Dependants-Fee' ? 'active' : '' ?>"
												   href="/hss/payments/Dependants-Fee">Dependants-Fee</a>
											</li>
											<li>
												<a class="dropdown-item py-2 <?php echo $paymentType == 'Donations' ? 'active' : '' ?>"
												   href="/hss/payments/Donations">Donations</a>
											</li>
										</ul>
										<span class="btn btn-light btn-sm">
											<?php echo count($payments) . ' records found.'; ?>
										</span>
									</div>
								</div>

							</div>


							<hr>
							<div class="table-responsive mt-4">
								<table class="table table-hover table-sm small text-center" style="text-justify: auto">
									<thead>
									<tr>
										<th>#</th>
										<th>Member ID</th>
										<th>Name</th>
										<th>Email</th>
										<th>Phone</th>
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
											$paymentType = 'Event Fee';
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
										$paymentConfirmed = $payment['Payment']['payment_confirmed']
											? '<span class="text-success fw-bold">Verified</span>'
											: '<span class="text-danger fw-bold">No</span>';
										$createdDate = date('d-m-Y', strtotime($payment['Payment']['created']));
										$alumniMemberId = $payment['AlumniMember']['id'];
										$name = $payment['AlumniMember']['name'];
										$email = $payment['AlumniMember']['email'];
										$phone = $payment['AlumniMember']['phone'];
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
											<td>
												<a href="/hss/member_payments/<?php echo $alumniMemberId; ?>"
												   class="nowrap"><?php echo $alumniMemberId; ?></a>
											</td>
											<td>
												<a href="/hss/member_payments/<?php echo $alumniMemberId; ?>"
												   class="nowrap"><?php echo $name; ?></a>
											</td>
											<td><a href="/hss/member_payments/<?php echo $alumniMemberId; ?>"
												   class="nowrap"><?php echo $email; ?></a></td>
											<td><?php echo $phone; ?></td>
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
												} else {
													echo 'N/A';
												}
												?>
											</td>

											<td><?php echo $paymentConfirmed; ?></td>
											<td><?php echo $createdDate; ?></td>
											<td style="width: 90px;" class="text-end">
												<a
													href="/hss/update_member_payment/<?php echo $paymentId; ?>"
													class="text-decoration-underline" title="Edit Payment Details">
													Edit
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
