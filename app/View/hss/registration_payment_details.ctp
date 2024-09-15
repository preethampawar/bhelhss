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
						<strong>Event Registration Details</strong>
					</h3>

				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-12 mx-auto mbr-form">
				<div class="text-end pe-3 mb-2">
					<a href="/hss/event_registration" class="btn btn-secondary rounded-pill">Event Registration &raquo;</a>
					<a href="/hss/register_dependants" class="btn btn-primary rounded-pill ms-2">Register Dependants &raquo;</a>
				</div>
				<div class="p-5 text-black bg-light" style="border-radius: 1.5rem;">
					<div class="mbr-section-head">

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
									<th>Mentioned Amount</th>
									<th>Credited Amount</th>
									<th>Transaction ID</th>
									<th>Screenshot</th>
									<th>Payment Verified</th>
									<th>Date</th>
								</tr>
								</thead>
								<tbody>
								<?php
								$i = 0;
								foreach ($payments as $payment) {
									$i++;
									$type = $payment['Payment']['type'];
									$registrationType = $type === 'event_registration_fee'
										? 'Event Registration Fee'
										: 'Dependant Registration Fee';

									$attedeesCount = $payment['Payment']['no_of_attendees'];
									$paidAmount = $payment['Payment']['paid_amount'];
									$verifiedAmount = $payment['Payment']['verified_amount'] ? $payment['Payment']['verified_amount'] : '-';
									$transactionId = $payment['Payment']['transaction_id'];
									$transactionFile = $payment['Payment']['transaction_file'];
									$paymentConfirmed = $payment['Payment']['payment_confirmed']
										? '<span class="text-success fw-bold">Verified</span>'
										: '<span class="text-danger fw-bold">No</span>';
									$createdDate = date('d-m-Y', strtotime($payment['Payment']['created']));
									?>
									<tr>
										<td><?php echo $i; ?>.</td>
										<td><?php echo $registrationType ; ?></td>
										<td><?php echo $attedeesCount; ?></td>
										<td><?php echo $paidAmount; ?></td>
										<td><?php echo $verifiedAmount; ?></td>
										<td><?php echo $transactionId; ?></td>
										<td>
											<?php
											if (!empty($transactionFile)) {
												?>
												<a class="example-image-link"
												   href="/payments/<?php echo $transactionFile; ?>"
												   data-lightbox="example-<?php echo $i; ?>">
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
