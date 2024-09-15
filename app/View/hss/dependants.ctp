<?php
$fatherName = $this->data['Dependant']['father_name'] ?? '';
$fatherAge = $this->data['Dependant']['father_age'] ?? 60;
$motherName = $this->data['Dependant']['mother_name'] ?? '';
$motherAge = $this->data['Dependant']['mother_age'] ?? 60;
$spouseName = $this->data['Dependant']['spouse_name'] ?? '';
$spouseAge = $this->data['Dependant']['spouse_age'] ?? 40;
$child1Name = $this->data['Dependant']['child1_name'] ?? '';
$child1Age = $this->data['Dependant']['child1_age'] ?? 20;
$child2Name = $this->data['Dependant']['child2_name'] ?? '';
$child2Age = $this->data['Dependant']['child2_age'] ?? 20;
$child3Name = $this->data['Dependant']['child3_name'] ?? '';
$child3Age = $this->data['Dependant']['child3_age'] ?? 20;
//debug($dependants);
?>
<section data-bs-version="5.1" class="form5 cid-uie1F6KRbz pt-0" id="register-form">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12">
				<div class="mbr-section-head mb-5">
					<h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2">
						<strong>Add Dependants</strong>
					</h3>
					<div class="text-end">
						<a class="btn btn-primary rounded-pill" href="/hss/register_dependants">Register Dependants &raquo;</a>
					</div>
					<h4 class="fw-bold mt-4">Add dependants for the Event</h4>
					<div class="">
						Add details of your dependants to ensure a smooth registration process.
						Fill in the required information and <a class="" href="/hss/register_dependants">register dependants</a> to secure their spot for the upcoming event.
					</div>

					<form method="POST" class="mbr-form form-with-styler mt-4" data-form-title="Form Name">
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
							<div class="col-7 col-lg-8 form-group mb-3" data-for="name">
								<label class="ms-2">Father Name</label>
								<input
									type="text"
									name="data[Dependant][father_name]"
									placeholder="Enter Father Name"
									data-form-field="father name"
									class="form-control"
									value="<?php echo $fatherName ?? ''; ?>"
									id="father-name-register-form">
							</div>
							<div class="col-5 col-lg-4 form-group mb-3" data-for="email">
								<label class="ms-2" for="father-age" title="Father's Age">Age</label>
								<select
									name="data[Dependant][father_age]"
									class="form-control form-select"
									id="father-age"
									style="line-height: 2rem !important;"
								>
									<?php
									foreach (range(4, 100) as $age) {
										?>
										<option value="<?php echo $age; ?>" <?php echo $fatherAge == $age ? 'selected' : ''; ?>>
											<?php echo $age; ?> Yrs
										</option>
										<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-7 col-lg-8 form-group mb-3" data-for="name">
								<label class="ms-2">Mother Name</label>
								<input
									type="text"
									name="data[Dependant][mother_name]"
									placeholder="Enter Mother Name"
									data-form-field="name"
									class="form-control"
									value="<?php echo $motherName ?? ''; ?>"
									id="mother-name-register-form">
							</div>
							<div class="col-5 col-lg-4 form-group mb-3" data-for="email">
								<label class="ms-2" for="mother-age" title="Mother's Age">Age</label>
								<select
									name="data[Dependant][mother_age]"
									class="form-control form-select"
									id="mother-age"
									style="line-height: 2rem !important;"
								>
									<?php
									foreach (range(4, 100) as $age) {
										?>
										<option value="<?php echo $age; ?>" <?php echo $motherAge == $age ? 'selected' : ''; ?>>
											<?php echo $age; ?> Yrs
										</option>
										<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-7 col-lg-8 form-group mb-3" data-for="name">
								<label class="ms-2">Spouse Name</label>
								<input
									type="text"
									name="data[Dependant][spouse_name]"
									placeholder="Enter Spouse Name"
									data-form-field="name"
									class="form-control"
									value="<?php echo $spouseName ?? ''; ?>"
									id="mother-name-register-form">
							</div>
							<div class="col-5 col-lg-4 form-group mb-3" data-for="email">
								<label class="ms-2" for="spouse-age" title="Spouse's Age">Age</label>
								<select
									name="data[Dependant][spouse_age]"
									class="form-control form-select"
									id="spouse-age"
									style="line-height: 2rem !important;"
								>
									<?php
									foreach (range(4, 100) as $age) {
										?>
										<option value="<?php echo $age; ?>" <?php echo $spouseAge == $age ? 'selected' : ''; ?>>
											<?php echo $age; ?> Yrs
										</option>
										<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-7 col-lg-8 form-group mb-3" data-for="name">
								<label class="ms-2">Child-1 Name</label>
								<input
									type="text"
									name="data[Dependant][child1_name]"
									placeholder="Enter Child1 Name"
									data-form-field="child1 name"
									class="form-control"
									value="<?php echo $child1Name ?? ''; ?>"
									id="child1-name-register-form">
							</div>
							<div class="col-5 col-lg-4 form-group mb-3" data-for="email">
								<label class="ms-2" for="child1_age" title="Age of Child1">Age</label>
								<select
									name="data[Dependant][child1_age]"
									class="form-control form-select"
									id="child1_age"
									style="line-height: 2rem !important;"
								>
									<?php
									foreach (range(4, 100) as $age) {
										?>
										<option value="<?php echo $age; ?>" <?php echo $child1Age == $age ? 'selected' : ''; ?>>
											<?php echo $age; ?> Yrs
										</option>
										<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-7 col-lg-8 form-group mb-3" data-for="name">
								<label class="ms-2">Child-2 Name</label>
								<input
									type="text"
									name="data[Dependant][child2_name]"
									placeholder="Enter Child2 Name"
									data-form-field="child2 name"
									class="form-control"
									value="<?php echo $child2Name ?? ''; ?>"
									id="child2-name-register-form">
							</div>
							<div class="col-5 col-lg-4 form-group mb-3" data-for="email">
								<label class="ms-2" for="child2_age" title="Age of Child2">Age</label>
								<select
									name="data[Dependant][child2_age]"
									class="form-control form-select"
									id="child2_age"
									style="line-height: 2rem !important;"
								>
									<?php
									foreach (range(4, 100) as $age) {
										?>
										<option value="<?php echo $age; ?>" <?php echo $child2Age == $age ? 'selected' : ''; ?>>
											<?php echo $age; ?> Yrs
										</option>
										<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-7 col-lg-8 form-group mb-3" data-for="name">
								<label class="ms-2">Child-3 Name</label>
								<input
									type="text"
									name="data[Dependant][child3_name]"
									placeholder="Enter Child3 Name"
									data-form-field="child3Name"
									class="form-control"
									value="<?php echo $child3Name ?? ''; ?>"
									id="child3-name-register-form">
							</div>
							<div class="col-5 col-lg-4 form-group mb-3" data-for="email">
								<label class="ms-2" for="child3_age" title="Age of Child3">Age</label>
								<select
									name="data[Dependant][child3_age]"
									class="form-control form-select"
									id="child3_age"
									style="line-height: 2rem !important;"
								>
									<?php
									foreach (range(4, 100) as $age) {
										?>
										<option value="<?php echo $age; ?>" <?php echo $child3Age == $age ? 'selected' : ''; ?>>
											<?php echo $age; ?> Yrs
										</option>
										<?php
									}
									?>
								</select>
							</div>
						</div>

						<div class="row mt-3">
							<div class="col-lg-12 col-md-12 col-sm-12 align-center mbr-section-btn">
								<button type="submit" class="btn btn-primary display-7">Save Information</button>
							</div>
						</div>
					</form>


				</div>
			</div>
		</div>
	</div>
</section>

