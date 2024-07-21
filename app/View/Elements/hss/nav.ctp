<section data-bs-version="5.1" class="menu menu5 cid-uiic8SDzwO" once="menu" id="menu05-18">
	<nav class="navbar navbar-dropdown navbar-expand-lg">
	<div class="container">
		<div class="navbar-brand">
				<span class="navbar-logo">
					<a href="/">
						<img src="/bhelhss/r.mobirisesite.com/558418/assets/images/photo-1617184896380-579b1fa76-h_lyiaze7x.jpg" alt="" style="height: 4rem;">
					</a>
				</span>
			<span class="navbar-caption-wrap"><div contenteditable="true" style="position: absolute; left: -100000px; opacity: 0;"></div><a class="navbar-caption text-black display-4" href="/">BHEL HSS Alumni<br></a></span>
		</div>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-toggle="collapse" data-target="#navbarSupportedContent" data-bs-target="#navbarSupportedContent" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
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
					<a class="nav-link link text-black display-4" href="/hss/news_and_events" aria-expanded="false">News & Events</a>
				</li>
				<li class="nav-item">
					<a class="nav-link link text-black display-4" href="/hss/contact_us">Contact Us</a>
				</li>
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
						<a class="nav-link link text-black display-4" href="/AlumniMembers/">Alumni Members</a>
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
			?>
			<div class="navbar-buttons mbr-section-btn">
				<a class="btn btn-primary display-4" href="/hss/register"> Register Now!</a>
			</div>
			<?php
			}
			?>
		</div>
	</div>
</nav>
</section>
