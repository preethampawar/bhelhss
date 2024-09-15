<?php
$name = $this->data['User']['name'] ?? '';
$phone = $this->data['User']['phone'] ?? '';
$email = $this->data['User']['email'] ?? '';
$type = $this->data['User']['type'] ?? '';
$passoutClass = $this->data['User']['passout_class'] ?? '';
if (empty($passoutClass)) {
	$passoutClass = 10;
}
$passoutSection = $this->data['User']['passout_section'] ?? '';
$passoutYear = $this->data['User']['passout_year'] ?? '';
$amountPaid = $this->data['User']['amount_paid'] ?? '';
$accountVerified = $this->data['User']['account_verified'] ?? '';
$transactionId = $this->data['User']['transaction_id'] ?? '';
$transactionFile = $this->data['User']['transaction_file'] ?? '';
$paymentConfirmed = $this->data['User']['payment_confirmed'] ?? 0;
?>

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
						<strong>Edit Member</strong>
					</h3>
					<h4 class="mbr-section-title mbr-fonts-style align-center mb-0 fs-2 mt-3"><?php echo $name; ?></h4>

				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="p-4 bg-light" style="border-radius: 2rem;">
				<form method="POST" class="mbr-form form-with-styler" data-form-title="Form Name">
					<div class="row">
						<?php
						if ($errorMsg) {
							?>
							<div data-form-alert-danger="" class="alert alert-danger col-12 rounded-pill bg-gradient">
								<?php echo $errorMsg; ?>
							</div>
							<?php
						}
						?>
					</div>
					<h3 class="">Account Details</h3>
					<div class="row mt-4">
						<div class="col-sm-12 form-group mb-3" data-for="name">
							<input type="text" name="data[User][name]" placeholder="Name" data-form-field="name" class="form-control" value="<?php echo $name; ?>" id="name-register-form" required>
						</div>
						<div class="col-sm-12 form-group mb-3" data-for="email">
							<input type="email" name="data[User][email]" placeholder="Email" data-form-field="email" class="form-control" value="<?php echo $email; ?>" id="email-register-form" required>
						</div>
					</div>
					<div class="row">
						<div class="col-md col-12 form-group mb-3" data-for="number">
							<input type="text" name="data[User][phone]" placeholder="Phone" data-form-field="url" class="form-control" value="<?php echo $phone; ?>" id="phone-register-form" required>
						</div>
						<div class="col-md col-sm-12 form-group mb-3" data-for="member">
							<select
								name="data[User][type]"
								required="required"
								class="form-control form-select"
								id="user-type"
								style="line-height: 2rem !important;"
								onchange="toggleClassInfo()"
							>
								<option value="student" <?php echo $type == 'student' ? 'selected' : ''; ?>>Member Type - Student</option>
								<option value="teacher" <?php echo $type == 'teacher' ? 'selected' : ''; ?>>Member Type - Teacher</option>
								<option value="principal" <?php echo $type == 'principal' ? 'selected' : ''; ?>>Member Type - Principal</option>
								<option value="non_teaching_staff" <?php echo $type == 'non_teaching_staff' ? 'selected' : ''; ?>>Member Type - Non Teaching Staff</option>
							</select>
						</div>
					</div>
					<div class="row" id="class-info">
						<h3 class="mt-4 mb-4">Passout Details</h3>
						<div class="col-md col-sm-12  form-group mb-3" data-for="passout_class">
							<select
								name="data[User][passout_class]"
								required="required"
								class="form-control form-select"
								id="passout-class"
								style="line-height: 2rem !important;"
							>
								<?php
								for ($i = 12; $i > 0; $i--) {
									?>
									<option value="<?php echo $i; ?>" <?php echo $passoutClass == $i ? 'selected' : ''; ?>>
										Class - <?php echo $i; ?>
									</option>
									<?php
								}
								?>
							</select>
						</div>
						<div class="col-md col-sm-12  form-group mb-3" id="class-info" data-for="passout_section">
							<select
								name="data[User][passout_section]"
								required="required"
								class="form-control form-select"
								id="passout-section"
								style="line-height: 2rem !important;"
							>
								<?php
								foreach (range('A', 'Z') as $section) {
									?>
									<option value="<?php echo $section; ?>" <?php echo $passoutSection == $section ? 'selected' : ''; ?>>
										Section - <?php echo $section; ?>
									</option>
									<?php
								}
								?>
							</select>
						</div>
						<div class="col-md col-sm-12 form-group mb-3" id="class-info" data-for="passout_year">
							<select
								name="data[User][passout_year]"
								required="required"
								class="form-control form-select"
								id="passout-year"
								style="line-height: 2rem !important;"
							>
								<?php
								foreach (range(1965, 2002) as $year) {
									?>
									<option value="<?php echo $year; ?>" <?php echo $passoutYear == $year ? 'selected' : ''; ?>>
										<?php echo $year; ?>
									</option>
									<?php
								}
								?>
							</select>
						</div>
					</div>
					<div class="row mt-3 d-none">
						<div class="col-md col-sm-12 form-group mb-3" data-for="number">
							<label for="amount-paid-register-form" class="ps-4">Amount Paid</label>
							<input type="text" name="data[User][amount_paid]" placeholder="Amount Paid" data-form-field="url" class="form-control" value="<?php echo $amountPaid; ?>" id="amount-paid-register-form" required>
						</div>
						<div class="col-md col-sm-12 form-group mb-3" data-for="text">
							<label for="transaction-id-register-form" class="ps-4">UTR or UPI Transaction ID</label>
							<input type="text" name="data[User][transaction_id]" placeholder="UTR or UPI Transaction ID" data-form-field="text" class="form-control" value="<?php echo $transactionId; ?>" id="transaction-id-register-form" required>
							<div class="mt-2 px-3 text-center">
								Screenshot:
								<?php
								if (!empty($transactionFile)) {
									?>
									<br>
									<a href="/payments/<?php echo $transactionFile; ?>" target="_blank">
										<img src="/payments/<?php echo $transactionFile; ?>" alt="transaction screenshot" class="img-thumbnail mx-auto" style="max-width: 150px;">
									</a>
									<?php
								} else {
									// echo '-';
								}
								?>
							</div>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col-md col-sm-12 form-group mb-3 px-4 fs-4" data-for="number">
							<div class="form-check form-switch">
								<input name="data[User][account_verified]" type="hidden" value="0">
								<input name="data[User][account_verified]" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" value="1" <?php echo $accountVerified == 1 ? 'checked' : ''; ?>>
								<label class="form-check-label" for="flexSwitchCheckDefault">Account Verified</label>
							</div>
						</div>
						<div class="col-md col-sm-12 form-group mb-3 px-4 fs-4 d-none" data-for="number">
							<div class="form-check form-switch">
								<input name="data[User][payment_confirmed]" type="hidden" value="0">
								<input name="data[User][payment_confirmed]" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault2" value="1" <?php echo $paymentConfirmed == 1 ? 'checked' : ''; ?>>
								<label class="form-check-label" for="flexSwitchCheckDefault2">Payment Verified</label>
							</div>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col-lg-12 col-md-12 col-sm-12 align-center mbr-section-btn">
							<button type="submit" class="btn btn-primary display-7">Save</button>
							<a href="/hss/alumni_members" class="btn btn-outline-secondary ms-3">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script>
	function toggleClassInfo() {
		let ele = $('#user-type') ?? false;
		if (ele) {
			let selectedOption = ele.val();

			if (selectedOption === 'student') {
				$('#class-info').removeClass('d-none');
			} else {
				$('#class-info').addClass('d-none');
			}
		}
	}

	$(document).ready(function () {
		toggleClassInfo();
	})
</script>
