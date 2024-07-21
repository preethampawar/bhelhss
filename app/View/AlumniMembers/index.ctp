<?php
if ($download) {
	$csv = implode(',', array('Sl.no.', 'Name', 'Phone', 'Email', 'Type', 'Created on')) . "\r\n";
	if ($alumniMembers) {
		$k = 1;
		foreach ($alumniMembers as $alumniMember) {
			$name = $alumniMember['AlumniMember']['name'];
			$phone = $alumniMember['AlumniMember']['phone'];
			$email = $alumniMember['AlumniMember']['email'];
			$type = ucfirst($alumniMember['AlumniMember']['type']);
			$createdon = date('d-m-Y H:i A', strtotime($alumniMember['AlumniMember']['created']));

			$tmp = array();
			$tmp[] = $k;
			$tmp[] = html_entity_decode($name);
			$tmp[] = html_entity_decode($phone);
			$tmp[] = html_entity_decode($email);
			$tmp[] = html_entity_decode($type);
			$tmp[] = html_entity_decode($createdon);
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


<section data-bs-version="5.1" class="AlumniMembers article12 cid-uiiaMNlS5D pt-0" id="article12-17">


	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 content-head">
				<div class="mbr-section-head mb-5">
					<br>
					<h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2">
						<strong>Alumni Members</strong>
					</h3>

				</div>
			</div>
		</div>
		<div class="mb-4">

			<div class="row text-center">
				<div class="col-12 col-md-6">
					<?php
					echo $this->Form->create();
					?>
					<input type="hidden" name="data[AlumniMember][search_text]" value="">
					<input type="hidden" name="data[AlumniMember][date]" value="<?php echo date('Y-m-d'); ?>">
					<button type="submit" class="btn btn-info text-center p-4 rounded-pill w-100 fs-4 d-block">
						Members Registered Today
						<br>
						<span class="badge alert-light text-info rounded-pill fs-3 mt-3"><?php echo $todaysAlumniMembersCount ; ?></span>
					</button>
					<?php
					echo $this->Form->end();
					?>
				</div>
				<div class="col-12 col-md-6">
					<form method="get">
						<button type="submit"  class=" btn btn-info text-center p-4 rounded-pill w-100 fs-4 d-block">
							Total Registered Members
							<br>
							<span class="badge alert-light text-info rounded-pill fs-3 mt-3"><?php echo $allAlumniMembersCount ; ?></span>
						</button>
					</form>
				</div>
			</div>

		</div>
		<div class="row">
			<div class="col-12 mb-3 px-4">
				<div class="navbar-buttons mbr-section-btn text-end">
					<a href="/hss/add_member" class="btn btn-outline-secondary display-4 m-0 mt-1 py-3 me-3">+ Add Member</a>
					<a href="/AlumniMembers/index/1" class="btn btn-outline-secondary display-4 m-0 mt-1 py-3">Download All</a>
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
					<p class="mt-3 text-info ms-1"><?php echo count($alumniMembers); ?> record(s) found.</p>
					<div class="table-responsive">
						<table class="table table-hover small mt-0">
						<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Phone</th>
							<th>Email</th>
							<th>Amount Paid</th>
							<th>Created On</th>
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
							$createdon = date('d-m-Y H:i A', strtotime($alumniMember['AlumniMember']['created']));
							?>
							<tr>
								<td><?php echo $i; ?>.</td>
								<td><?php echo $name; ?></td>
								<td><?php echo $phone; ?></td>
								<td><?php echo $email; ?></td>
								<td><?php echo $amountPaid > 0 ? $amountPaid : ''; ?></td>
								<td><?php echo $createdon; ?></td>
								<td>
									<a href="/hss/edit_member/<?php echo $alumniMemberId; ?>" class="">Edit</a>

									<?php
										echo $this->Html->link(
										'Delete',
										array('controller' => 'AlumniMembers', 'action' => 'delete', $alumniMemberId),
										array('confirm' => 'Are you sure you want to delete this member?', 'class'=>'link-danger ms-2')
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


