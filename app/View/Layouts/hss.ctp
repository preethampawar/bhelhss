<?php
$controller = $this->request->params['controller'] ?? '';
$action = $this->request->params['action'] ?? '';
$param = $this->request->params['pass'][0] ?? '';
$isLanding = $controller == 'pages' && $action == 'display' && $param == 'landing';
?>
<!DOCTYPE html>
<html>

<!-- Mirrored from bhelhss.mobirisesite.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 12 Jul 2024 06:44:42 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8"/><!-- /Added by HTTrack -->
<head>
	<!-- Site made with Mobirise Online Website Builder v5.9.13, https://a.mobirise.com -->
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="generator" content="Mobirise v5.9.13, a.mobirise.com">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="shortcut icon" href="/bhelhss/r.mobirisesite.com/558418/assets/images/photo-1617184896380-579b1fa76-h_lyiaze7x.jpg" type="image/x-icon">
	<meta name="description"
		  content="The BHEL Higher Secondary School Alumni is thrilled to announce EUPHORIA 2024, a grand event where you can reunite with friends, classmates, teachers, and staff members. Join us for a day filled with nostalgia and joy!">
	<title>BHEL HSS ALUMNI <?php echo !empty($title_for_layout) ? ' - ' . $title_for_layout : ''; ?></title>
	<?php echo $this->element('hss/head_css'); ?>
	<style>
		.content-main {
			/*padding-top: 8rem;*/
			/*padding-bottom: 5rem;*/
			/*background-color: #ffffff;*/
		}
		@media only screen and (max-width: 768px) {
			.content-main {
				padding-top:6rem !important;
			}
		}
	</style>
</head>
<body style="background-color: #ffffff">
<?php echo $this->element('hss/nav'); ?>
<div class="content-main" style="<?php echo !$isLanding ? 'padding-top:9rem;' : ''; ?>">
	<?php echo $this->Session->flash(); ?>

	<?php echo $this->fetch('content'); ?>
</div>

<section data-bs-version="5.1" class="footer3 cid-uie1F6Kx7f" once="footers" id="footer-3-uie1F6Kx7f">


	<div class="container">
		<div class="row">
			<div class="row-links d-none mb-4">
				<ul class="header-menu">


					<li class="header-menu-item mbr-fonts-style display-5">
						<a href="#" class="text-white">About</a>
					</li>
					<li class="header-menu-item mbr-fonts-style display-5">
						<a href="#" class="text-white">Gallery</a>
					</li>
					<li class="header-menu-item mbr-fonts-style display-5">
						<a href="#" class="text-white">Blog</a>
					</li>
					<li class="header-menu-item mbr-fonts-style display-5">
						<a href="#" class="text-white">Services</a>
					</li>
				</ul>
			</div>

			<div class="col-12 ">
				<div class="social-row">
					<div class="soc-item">
						<a href="https://www.facebook.com/groups/296465983802820/" target="_blank">
							<span class="mbr-iconfont socicon socicon-facebook display-7"></span>
						</a>
					</div>
					<div class="soc-item d-none">
						<a href="/" target="_blank">
							<span class="mbr-iconfont socicon-twitter socicon"></span>
						</a>
					</div>
					<div class="soc-item d-none">
						<a href="/" target="_blank">
							<span class="mbr-iconfont socicon-instagram socicon"></span>
						</a>
					</div>
					<div class="soc-item">
						<a href="http://in.linkedin.com/groups?gid=161745" target="_blank">
							<span class="mbr-iconfont socicon socicon-linkedin"></span>
						</a>
					</div>
					<div class="soc-item d-none">
						<a href="/" target="_blank">
							<span class="mbr-iconfont socicon socicon-twitch"></span>
						</a>
					</div>
				</div>
			</div>
			<div class="col-12 mt-5">
				<p class="mbr-fonts-style copyright display-7">© 2024 BHEL Higher Secondary School Alumni. All Rights Reserved.</p>
			</div>
		</div>
	</div>
</section>


<?php echo $this->element('hss/footer_scripts'); ?>

</body>
</html>
