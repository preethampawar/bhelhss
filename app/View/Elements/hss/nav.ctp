<section data-bs-version="5.1" class="menu menu5 cid-uiic8SDzwO shadow-sm bg-transparent" once="menu" id="menu05-18">
	<nav class="navbar navbar-dropdown navbar-expand-lg nav-bg bg-light;"
		 style='
			 	background-image: url("/img/pattern_bg/peach-gradient-background-with-geomatric-pattern_873105-534.avif");
			 	background-repeat: repeat;
			 	background-size: auto;
				background-color: #ffffff'>
		<div class="container-fluid bg-transparent" style="width: 100% !important;">
			<div class="navbar-brand">
				<span class="navbar-logo">
					<a href="/">
						<img src="/img/hss_logo_optimized.png" alt="" style="height: 4rem;">
					</a>
				</span>
				<span class="navbar-caption-wrap"><div contenteditable="true"
													   style="position: absolute; left: -100000px; opacity: 0;"></div><a
						class="navbar-caption text-black display-4" href="/">BHEL HSS Alumni<br></a></span>
			</div>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-toggle="collapse"
					data-target="#navbarSupportedContent" data-bs-target="#navbarSupportedContent"
					aria-controls="navbarNavAltMarkup"
					aria-expanded="false" aria-label="Toggle navigation">
				<div class="hamburger">
					<span></span>
					<span></span>
					<span></span>
					<span></span>
				</div>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
					<li class="nav-item">
						<a class="nav-link link text-black display-4" href="/">Home</a>
					</li>
					<?php
					if (!$this->Session->check('Auth.User')) {
						?>
						<li class="nav-item">
							<a class="nav-link link text-black display-4" href="/hss/about_school">About BHEL HSS</a>
						</li>
						<li class="nav-item">
							<a class="nav-link link text-black display-4" href="/hss/news_and_events"
							   aria-expanded="false">News & Events</a>
						</li>
						<li class="nav-item">
							<a class="nav-link link text-black display-4" href="/img/gallery"
							   target="_blank">Gallery</a>
						</li>
						<li class="nav-item">
							<a class="nav-link link text-black display-4" href="/hss/contact_us">Contact Us</a>
						</li>
						<?php
						if ($this->Session->check('AlumniMember.id')) {
							?>
							<li class="nav-item">
								<div>
									<a href="/hss/donations" class=" btn btn-primary btn-sm rounded-pill">Donate
										Now!</a>
								</div>
							</li>
							<?php
						}
						?>
						<?php
						if (!$this->Session->check('AlumniMember.id')) {
							?>
							<li class="nav-item">
								<a class="nav-link link text-black display-4" href="/hss/alumni_member_login">Login</a>
							</li>
							<?php
						}
						?>

						<?php
					}
					?>

					<?php
					if ($this->Session->check('Auth.User')) {
						?>
						<li class="nav-item">
							<a class="nav-link link text-black display-4" href="/admin/categories/">Manage Posts</a>
						</li>
						<li class="nav-item">
							<a class="nav-link link text-black display-4" href="/hss/alumni_members">Alumni Members</a>
						</li>
						<li class="nav-item">
							<a class="nav-link link text-black display-4" href="/hss/payments">Payments</a>
						</li>
						<li class="nav-item">
							<a class="nav-link link text-black display-4" href="/users/logout">Logout</a>
						</li>
						<?php
					}
					?>
				</ul>
				<?php

				if (!$this->Session->check('Auth.User')) {
					$alumniMember = $this->Session->read('AlumniMember');

					if ($alumniMember) {
						$name = $alumniMember['name'];
						?>

						<div class="dropdown">
							<a class="nav-link link text-black dropdown-toggle display-4 bg-white shadow-sm rounded-pill py-3 px-4"
							   href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
							   data-bs-auto-close="outside"
							   aria-expanded="false">
								<?php echo $name; ?> &nbsp;
							</a>

							<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" data-bs-popper="none"
								style="background: rgba(255, 255, 255, 0.97) !important;">
								<li><a class="dropdown-item" href="/hss/alumni_member_profile">My Profile</a></li>
								<li><a class="dropdown-item" href="/hss/donations">Donations</a></li>
								<li><a class="dropdown-item" href="/hss/register_dependants">Register Dependants</a></li>
								<li><a class="dropdown-item" href="/hss/event_registration">Event Registration</a></li>
								<li><a class="dropdown-item" href="/hss/logout">Logout</a></li>
							</ul>
						</div>
						<?php
					} else {
						?>

						<div class="navbar-buttons mbr-section-btn">
							<a class="btn btn-primary display-4" href="/hss/register"> Register Now!</a>
						</div>

						<?php
					}
				}
				?>
			</div>
		</div>
	</nav>
</section>
