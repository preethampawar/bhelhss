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
?>


<section data-bs-version="5.1" class="form5 cid-uie1F6KRbz pt-0" id="register-form">


	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 content-head">
				<div class="mbr-section-head mb-5">
					<h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2">
						<strong>My Profile</strong>
					</h3>

				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-lg-8 mx-auto mbr-form">
				<form method="POST" class="mbr-form form-with-styler" data-form-title="Form Name">
					<input type="hidden" name="data[User][email]" value="<?php echo $email; ?>">
					<input type="hidden" name="data[User][phone]" value="<?php echo $phone; ?>">
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
					<div class="row">
						<div class="col-sm-12 form-group mb-3" data-for="name">
							<input type="text" name="data[User][name]" placeholder="Name" data-form-field="name" class="form-control" value="<?php echo $name; ?>" id="name-register-form" required>
						</div>
						<div class="col-sm-12 form-group mb-3" data-for="email">
							<input type="email" class="form-control"  id="email-register-form" value="<?php echo $email; ?>" disabled>
						</div>
					</div>
					<div class="row">
						<div class="col-md col-12 form-group mb-3" data-for="number">
							<input type="tel" name="data[User][phone]" placeholder="Phone" data-form-field="tel" class="form-control" value="<?php echo $phone; ?>" id="phone" required>
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
						<div class="col-md col-sm-12  form-group mb-3" data-for="passout_class">
							<select
								name="data[User][passout_class]"
								required="required"
								class="form-control form-select"
								id="passout-class"
								style="line-height: 2rem !important;"
							>
								<?php
								for ($i = 10; $i > 0; $i--) {
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
						<div class="col-md col-sm-12  form-group mb-3" id="class-info" data-for="passout_year">
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
					<div class="row mt-3 justify-content-center mx-auto">
						<div class="col-md col-sm-12 mb-3 bg-light px-2 py-3 border rounded-3" data-for="captcha-text">
							<label for="captcha-image" class="d-block ms-2">
								Captcha <span class="fs-5 text-info fw-bold" role="button" onclick="document.getElementById('captcha-image').src='/hss/getcaptcha?i='+Math.random();">&#x27f3;</span>
							</label>
							<div class="input-group">
								<span class="input-group-text bg-transparent border-0">
									<img
										id="captcha-image"
										src="/hss/getcaptcha?<?php echo time(); ?>"
										class="mt-2"
										alt="Enter this text"
										style="width: 250px; border-radius:5px !important;"
										onclick="this.src='/hss/getcaptcha?i='+Math.random();"
										title="Click here to reload Captcha"
										role="button"
									>
								</span>
								<div class="flex-fill mt-2 pt-1">
									<input type="text" name="data[Image][captcha]" placeholder="Enter Captcha" data-form-field="captcha" class="form-control w-100" value="" id="captcha-register-form" required>
								</div>
							</div>
						</div>

					</div>
					<div class="row mt-3">
						<div class="col-lg-12 col-md-12 col-sm-12 align-center mbr-section-btn">
							<button type="submit" class="btn btn-primary display-7 px-5">Update</button>
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

$(document).ready(function() {
	toggleClassInfo();
})
</script>
