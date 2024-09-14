<?php
$name = $this->data['User']['name'] ?? '';
$phone = $this->data['User']['phone'] ?? '';
$email = $this->data['User']['email'] ?? '';
$message = $this->data['User']['message'] ?? '';
?>
<style>
	body {
		background-color: #fff9e6 !important;
	}
</style>


<section data-bs-version="5.1" class="form5 cid-uie1F6KRbz pt-0" id="contact-form-3-uie1F6KRbz">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 content-head">
				<div class="mbr-section-head mb-5">
					<h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2">
						<strong>Contact Us</strong>
					</h3>

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
					<div class="dragArea row">
						<div class="col-md col-sm-12 form-group mb-3" data-for="name">
							<input type="text" name="data[User][name]" placeholder="Name*" data-form-field="name" class="form-control" value="<?php echo $name; ?>" id="name-contact-form" required>
						</div>
						<div class="col-md col-sm-12 form-group mb-3" data-for="email">
							<input type="email" name="data[User][email]" placeholder="Email*" data-form-field="email" class="form-control" value="<?php echo $email; ?>" id="email-contact-form" required>
						</div>
						<div class="col-12 form-group mb-3" data-for="number">
							<input type="text" name="data[User][phone]" placeholder="Phone" data-form-field="phone" class="form-control" value="<?php echo $phone; ?>" id="phone-contact-form">
						</div>
						<div class="col-md col-sm-12 form-group mb-3" data-for="message">
							<textarea name="data[User][message]" placeholder="Message*" data-form-field="message" class="form-control" id="message-contact-form-3-uie1F6KRbz" required><?php echo $message; ?></textarea>
						</div>
						<div class="row justify-content-center mx-auto mb-3">
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
										style="width: 180px; border-radius:0 !important;"
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
						<div class="col-lg-12 col-md-12 col-sm-12 align-center mbr-section-btn">
							<button type="submit" class="btn btn-primary display-7">Send Message</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

