<?php
$name = $this->data['User']['name'] ?? '';
$phone = $this->data['User']['phone'] ?? '';
$email = $this->data['User']['email'] ?? '';
$type = $this->data['User']['type'] ?? '';
$amountPaid = $this->data['User']['amount_paid'] ?? '';
?>

<section data-bs-version="5.1" class="form5 cid-uie1F6KRbz pt-0" id="register-form">


	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 content-head">
				<div class="mbr-section-head mb-5">
					<h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2">
						<strong>Add Member</strong>
					</h3>

				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-lg-8 mx-auto mbr-form">
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
						<div class="dragArea row">
							<div class="col-md col-sm-12 form-group mb-3" data-for="name">
								<input type="text" name="data[User][name]" placeholder="Name" data-form-field="name" class="form-control" value="<?php echo $name; ?>" id="name-register-form" required>
							</div>
							<div class="col-md col-sm-12 form-group mb-3" data-for="email">
								<input type="email" name="data[User][email]" placeholder="Email" data-form-field="email" class="form-control" value="<?php echo $email; ?>" id="email-register-form" required>
							</div>
							<div class="col-12 form-group mb-3" data-for="number">
								<input type="text" name="data[User][phone]" placeholder="Phone" data-form-field="url" class="form-control" value="<?php echo $phone; ?>" id="phone-register-form" required>
							</div>
							<div class="col-md col-sm-12 form-group mb-3" data-for="member">
								<select name="data[User][type]" required="required" class="form-control form-select" id="user-type" style="line-height: 2rem !important;">
									<option value="student" <?php echo $type == 'student' ? 'selected' : ''; ?>>Member Type - Student</option>
									<option value="teacher" <?php echo $type == 'teacher' ? 'selected' : ''; ?>>Member Type - Teacher</option>
									<option value="principal" <?php echo $type == 'principal' ? 'selected' : ''; ?>>Member Type - Principal</option>
									<option value="non_teaching_staff" <?php echo $type == 'non_teaching_staff' ? 'selected' : ''; ?>>Member Type - Non Teaching Staff</option>
								</select>
							</div>
							<div class="col-12 form-group mb-3" data-for="number">
								<input type="text" name="data[User][amount_paid]" placeholder="Amount Paid" data-form-field="url" class="form-control" value="<?php echo $amountPaid; ?>" id="amount-paid-register-form" required>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 align-center mbr-section-btn mt-3">
								<button type="submit" class="btn btn-primary display-7">Submit</button>
								<a href="/AlumniMembers/" class="btn btn-outline-secondary ms-3">Cancel</a>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</section>
