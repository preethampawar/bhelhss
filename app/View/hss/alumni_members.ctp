<?php
if ($download) {
	$csv = '';
	//$csv = ucwords($searchBy) .  "\r\n"  . "\r\n";
	$csv .= implode(',', [
			'Sl.no.',
			'Name',
			'Phone',
			'Email',
			'Type',
			'Passout Class',
			'Passout Section',
			'Passout Year',
			'Account Status',
			'Created on'
		]) . "\r\n";
	if ($alumniMembers) {
		$k = 1;
		foreach ($alumniMembers as $alumniMember) {
			$name = $alumniMember['AlumniMember']['name'];
			$email = $alumniMember['AlumniMember']['email'];
			$phone = $alumniMember['AlumniMember']['phone'];
			$type = ucfirst($alumniMember['AlumniMember']['type']);
			$accountVerified = $alumniMember['AlumniMember']['account_verified'] ?? '';
			$paymentConfirmed = $alumniMember['AlumniMember']['payment_confirmed'] ?? '';
			$amountPaid = (float)$alumniMember['AlumniMember']['amount_paid'];
			$transactionId = $alumniMember['AlumniMember']['transaction_id'] ?? '';
			$transactionFile = $alumniMember['AlumniMember']['transaction_file'] ?? '';
			$createdon = date('d-m-Y', strtotime($alumniMember['AlumniMember']['created']));
			$passoutClass = $alumniMember['AlumniMember']['passout_class'];
			$passoutSection = $alumniMember['AlumniMember']['passout_section'];
			$passoutYear = $alumniMember['AlumniMember']['passout_year'];

			$tmp = array();
			$tmp[] = $k;
			$tmp[] = html_entity_decode($name);
			$tmp[] = html_entity_decode($phone);
			$tmp[] = html_entity_decode($email);
			$tmp[] = html_entity_decode($type);
			$tmp[] = html_entity_decode($passoutClass);
			$tmp[] = html_entity_decode($passoutSection);
			$tmp[] = html_entity_decode($passoutYear);
			$tmp[] = $accountVerified ? 'Verified' : 'Not Verified';
			$tmp[] = html_entity_decode($createdon) . ' ';
			$csv .= implode(',', $tmp) . "\r\n";
			$k++;
		}
	} else {
		$csv .= 'No members found.';
	}
	echo $csv;
	return;
}

$query = $this->request->query;
$params = '';

if ($query) {
	foreach ($query as $k => $v) {
		$params .= $k . '=' . urlencode($v) . '&';
	}
}
?>
<style>
	a[class*="text-"]:not(.nav-link):not(.dropdown-item):not([role]):not(.navbar-caption):hover{
		background-image: none;
	}
</style>

<section data-bs-version="5.1" class="AlumniMembers article12 cid-uiiaMNlS5D pt-0" id="article12-17">


	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 content-head">
				<div class="mbr-section-head mb-5">

					<h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2">
						<strong>Alumni Members</strong>
					</h3>

				</div>
			</div>
		</div>
		<div class="mb-4">

			<div class="row text-center">
				<div class="col-12 col-md-3">
					<form method="get">
						<input type="hidden" name="searchby" value="total-registered">
						<button type="submit" class=" btn btn-info text-center p-4 rounded-pill w-100 fs-4 d-block">
							Total Registered
							<br>
							<span class="badge alert-light text-info rounded-pill fs-3 mt-3"><?php echo $allAlumniMembersCount; ?></span>
						</button>
					</form>
				</div>
				<div class="col-12 col-md-3">
					<?php
					echo $this->Form->create(null, ['url' => '/hss/alumni_members?searchby=registered-today']);
					?>
					<input type="hidden" name="data[AlumniMember][search_text]" value="">
					<input type="hidden" name="data[AlumniMember][date]" value="<?php echo date('Y-m-d'); ?>">
					<button type="submit" class="btn btn-info text-center p-4 rounded-pill w-100 fs-4 d-block">
						Registered Today
						<br>
						<span class="badge alert-light text-info rounded-pill fs-3 mt-3"><?php echo $todaysAlumniMembersCount; ?></span>
					</button>
					<?php
					echo $this->Form->end();
					?>
				</div>
				<div class="col-12 col-md-3">
					<form method="get">
						<input type="hidden" name="searchby" value="accounts-verified">
						<button type="submit" class=" btn btn-info text-center p-4 rounded-pill w-100 fs-4 d-block">
							Accounts Verified
							<br>
							<span class="badge alert-light text-info rounded-pill fs-3 mt-3"><?php echo $accountsVerifiedCount; ?></span>
						</button>
					</form>
				</div>
				<div class="col-12 col-md-3">
					<form method="get">
						<input type="hidden" name="searchby" value="payments-confirmed">
						<a href="/hss/payments" class=" btn btn-info text-center p-4 rounded-pill w-100 fs-4 d-block">
							Payments Confirmed
							<br>
							<span class="badge alert-light text-info rounded-pill fs-3 mt-3">
								<?php echo $paymentsConfirmedCount; ?> / <?php echo $totalPaymentsConfirmedCount; ?>
							</span>
						</a>
					</form>
				</div>
			</div>

		</div>
		<div class="row">
			<div class="col-12 mb-3 px-4">
				<div class="navbar-buttons mbr-section-btn text-end">
					<a href="/hss/add_member" class="btn btn-outline-secondary display-4 m-0 mt-1 py-3 me-3">+ Add Member</a>
					<a href="/hss/alumni_members/1?<?php echo $params; ?>" class="btn btn-outline-secondary display-4 m-0 mt-1 py-3">Download</a>
				</div>
			</div>
		</div>
		<div class="bg-light text-dark p-4 rounded-3 mb-4" style="border-radius: 2rem !important;">
			<div class="">

				<?php
				$searchText = $this->data['AlumniMember']['search_text'] ?? '';
				$date = $this->data['AlumniMember']['date'] ?? '';
				?>
				<?php echo $this->Form->create() ?>
				<div class="row">
					<div class="col-12 col-md-4 mb-3">
						<input type="search" name="data[AlumniMember][search_text]" placeholder="Name, Phone, Email" class="form-control form-control-sm" value="<?php echo $searchText; ?>">
					</div>
					<div class="col-12 col-md-4 mb-3">
						<input type="date" name="data[AlumniMember][date]" placeholder="Date" class="form-control form-control-sm " value="<?php echo $date; ?>">
					</div>
					<div class="col-12 col-md-4 mb-3">
						<div class="text-start navbar-buttons mbr-section-btn">
							<button type="submit" class="btn btn-primary display-4 m-0 mt-1 py-3 ">Search</button>
						</div>
					</div>
				</div>
				<?php echo $this->Form->end() ?>

				<?php
				if (!empty($alumniMembers)) {
					?>
					<p class="mt-3 ms-1">
						<?php
						$searchBy = $searchBy ?? '';
						$title = '';
						switch ($searchBy) {
							case 'total-registered':
								$title = 'Total Registered Members: ';
								break;
							case 'accounts-verified':
								$title = 'Total Accounts Verified: ';
								break;
							case 'payments-confirmed':
								$title = 'Total Payments Confirmed: ';
								break;
							case 'registered-today':
								$title = 'Total Registered Today: ';
								break;
							default:
								$title = 'Total Members: ';
						}
						?>
						<b><span class=""><?php echo $title; ?></span>
							<span class="badge bg-info fs-6 rounded-pill"><?php echo count($alumniMembers); ?></b></span>
					</p>
					<div class="table-responsive">
						<table class="table table-hover small mt-0">
							<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Phone</th>
								<th>Email</th>
								<th>Passout Details</th>
								<th class="text-center">Account Verified</th>

								<th>Registered On</th>
								<th>Actions</th>
							</tr>
							</thead>
							<tbody>

							<?php
							$i = 1;
							foreach ($alumniMembers as $alumniMember) {
								$alumniMemberId = $alumniMember['AlumniMember']['id'];
								$name = $alumniMember['AlumniMember']['name'];
								$phone = $alumniMember['AlumniMember']['phone'];
								$email = $alumniMember['AlumniMember']['email'];
								$type = ucfirst($alumniMember['AlumniMember']['type']);
								$amountPaid = (float)$alumniMember['AlumniMember']['amount_paid'];
								$createdon = date('d-m-Y', strtotime($alumniMember['AlumniMember']['created']));
								$accountVerified = $alumniMember['AlumniMember']['account_verified'] ?? '';
								$passoutClass = $alumniMember['AlumniMember']['passout_class'];
								$passoutSection = $alumniMember['AlumniMember']['passout_section'];
								$passoutYear = $alumniMember['AlumniMember']['passout_year'];
								$passoutInfo = 'N/A';
								if ($alumniMember['AlumniMember']['type'] == 'student') {
									$passoutInfo = $passoutClass . ' ' . $passoutSection . ', ' . $passoutYear;
								}
								?>
								<tr>
									<td><?php echo $i; ?>.</td>
									<td><?php echo $name; ?></td>
									<td><?php echo $phone; ?></td>
									<td><?php echo $email; ?></td>
									<td><?php echo $passoutInfo; ?></td>
									<td class="text-center" title="Account Verified?"><?php echo $accountVerified ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>'; ?></td>
									<td><?php echo $createdon; ?></td>
									<td>
										<a href="/hss/member_details/<?php echo $alumniMemberId; ?>" class="">Details</a>
										<a href="/hss/edit_member/<?php echo $alumniMemberId; ?>" class="ms-2">Edit</a>
										<a href="/hss/member_payments/<?php echo $alumniMemberId; ?>" class="ms-2">Payments</a>

										<?php
										echo $this->Html->link(
											'Delete',
											array('controller' => 'AlumniMembers', 'action' => 'delete', $alumniMemberId),
											array('confirm' => 'Are you sure you want to delete this member?', 'class' => 'link-danger ms-2')
										);
										?>

									</td>
								</tr>
								<?php
								$i++;
							}
							?>
							</tbody>
						</table>
					</div>
					<br>
					<?php
				} else {
					echo '<div class="py-4 px-3">No members found.</div>';
				}
				?>
			</div>


		</div>

	</div>
</section>


