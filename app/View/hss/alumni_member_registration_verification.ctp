<?php
$errorMsg = $errorMsg ?? '';
$otp = $this->data['User']['otp'] ?? '';
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
				<div class="mbr-section-head mb-5 text-center">
					<h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2">
						<strong>Verify OTP</strong>
					</h3>
					<h6 class="mt-4">You will receive an OTP on your registered Email Address.</h6>
					<p class="mt-3 fw-bold"><?php echo $alumniMemberData['User']['email']; ?></p>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-lg-6 mx-auto mbr-form">
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
						<div class="col-sm-12 form-group mb-3" data-for="email">
							<input type="number" name="data[User][otp]" placeholder="Enter OTP" data-form-field="number" class="form-control" value="<?php echo $otp; ?>" id="otp-verification-form" required>
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
