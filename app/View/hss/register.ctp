<?php
$name = $this->data['User']['name'] ?? '';
$phone = $this->data['User']['phone'] ?? '';
if (empty($phone)) {
	$phone = "+91 ";
}
$email = $this->data['User']['email'] ?? '';
$type = $this->data['User']['type'] ?? '';
$passoutClass = $this->data['User']['passout_class'] ?? '';
if (empty($passoutClass)) {
	$passoutClass = 10;
}
$passoutSection = $this->data['User']['passout_section'] ?? '';
$passoutYear = $this->data['User']['passout_year'] ?? '';
?>

<style>
	.iti__selected-flag {
		top: 15px;
		height: 33px !important;
		border-radius: 4px;
		transition: .3s;
	}
	input#phone {
		padding-left: 60px !important;
		/*top: 6px;*/
	}
	.intl-tel-input .flag-dropdown .selected-flag {
		padding: 11px 16px 11px 6px;
	}
	.intl-tel-input {
		z-index: 99;
		width: 100%;
	}
	.iti-flag {
		box-shadow: none;
	}
	.intl-tel-input .selected-flag:focus {
		outline: none;
	}
	.iti--allow-dropdown .iti__flag-container:hover .iti__selected-flag {
		background-color: rgba(0, 0, 0, 0.05);
	}
	.iti--allow-dropdown input{
		padding-right: 6px;
		padding-left: 52px;
		margin-left: 0;
	}
	.iti__country-list {
		border-radius: 4px !important;
		z-index: 999 !important;
		box-shadow: 0 0 16px 0 rgb(0 0 0 / 8%) !important;
		border: 1px solid #ececec !important;
		width: 270px !important;
	}
	.iti {
		position: relative;
		display: block !important;
	}
	.iti__country-list {
		margin-top: 20px !important;
	}
</style>
<section data-bs-version="5.1" class="form5 cid-uie1F6KRbz pt-0" id="register-form">


	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 content-head">
				<div class="mbr-section-head mb-5">
					<h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2">
						<strong>Create Account</strong>
					</h3>
					<p class="mt-3 caption-top text-center">You need to create an account before you register yourself for the event.</p>
					<p class="mt-3 caption-top text-center">
						If you have already created an account <a href="/hss/alumni_member_login" class="text-decoration-underline">click here to login</a>.
					</p>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-lg-8 mx-auto mbr-form">
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
					<div class="row">
						<div class="col-sm-12 form-group mb-3" data-for="name">
							<input type="text" name="data[User][name]" placeholder="Name" data-form-field="name" class="form-control" value="<?php echo $name; ?>" id="name-register-form" required>
						</div>
						<div class="col-sm-12 form-group mb-3" data-for="email">
							<input type="email" name="data[User][email]" placeholder="Email" data-form-field="email" class="form-control" value="<?php echo $email; ?>" id="email-register-form" required>
						</div>
					</div>
					<div class="row">
						<div class="col-md col-12 form-group mb-3" data-for="number">
							<input
								type="tel"
							   	name="data[User][phone]"
								placeholder="Phone"
							   	data-form-field="tel"
								class="form-control"
						  		value="<?php echo $phone; ?>"
							   	id="phone"
								pattern="^\+(?:[0-9] ?){6,25}[0-9]$"
								title="+xx xxxxxxxxxx. Ex: +91 9494203040"
								required>
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
						<h3 class="my-3">Passout Details</h3>
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
									<input type="number" name="data[Image][captcha]" placeholder="Enter Captcha" data-form-field="captcha" class="form-control w-100" value="" id="captcha-register-form" required>
								</div>
							</div>
						</div>

					</div>
					<div class="row mt-3">
						<div class="col-lg-12 col-md-12 col-sm-12 align-center mbr-section-btn">
							<button type="submit" class="btn btn-primary display-7 px-5">Submit</button>
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
<script src='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js'></script>
<script>
	// International telephone format
	// $("#phone").intlTelInput();
	// get the country data from the plugin
	var countryData = window.intlTelInputGlobals.getCountryData(),
		input = document.querySelector("#phone"),
		addressDropdown = document.querySelector("#country");

	// init plugin
	var iti = window.intlTelInput(input, {
		hiddenInput: "full_phone",
		utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // just for formatting/placeholders etc
	});

	// populate the country dropdown
	for (var i = 0; i < countryData.length; i++) {
		var country = countryData[i];
		var optionNode = document.createElement("option");
		optionNode.value = country.iso2;
		var textNode = document.createTextNode(country.name);
		optionNode.appendChild(textNode);
		addressDropdown.appendChild(optionNode);
	}
	// set it's initial value
	addressDropdown.value = iti.getSelectedCountryData().iso2;

	// listen to the telephone input for changes
	input.addEventListener('countrychange', function(e) {
		addressDropdown.value = iti.getSelectedCountryData().iso2;
	});

	// listen to the address dropdown for changes
	addressDropdown.addEventListener('change', function() {
		iti.setCountry(this.value);
	});
</script>

<script>
	//Append Value To Phone Field
	$("#phone").prop('value', '+91 ');

	<?php
	if (!empty($phone)) {
		?>
		$(document).ready(() => {
			setTimeout(function() {
				$("#phone").prop('value', '<?php echo $phone; ?>');
			}, 1000);
		})
		<?php
	}
	?>
</script>
