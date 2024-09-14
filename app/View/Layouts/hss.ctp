<?php
$controller = $this->request->params['controller'] ?? '';
$action = $this->request->params['action'] ?? '';
$param = $this->request->params['pass'][0] ?? '';
$isLanding = $controller == 'pages' && $action == 'display' && $param == 'landing';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
	<link rel="shortcut icon"
		  href="/img/hss_logo_optimized.png"
		  type="image/x-icon">
	<meta name="description"
		  content="The BHEL Higher Secondary School Alumni is thrilled to announce EUPHORIA 2024, a grand event where you can reunite with friends, classmates, teachers, and staff members. Join us for a day filled with nostalgia and joy!">
	<title>BHEL HSS ALUMNI <?php echo !empty($title_for_layout) ? ' - ' . $title_for_layout : ''; ?></title>
	<?php echo $this->element('hss/head_css'); ?>
	<style>
		<?php
		if (!$isLanding) {
			?>
			body {
				background-image: linear-gradient(to top, #ffb3b3 0%, #fdf9dc 100%);
			}
			<?php
		}
		?>

		/*.nav-bg {*/
		/*	!*background-image: linear-gradient(to top, #e7f3fd  0%, #ffffff 49%, #e7f3fd 100%);*!*/
		/*	background: rgb(238,174,202);*/
		/*	background: radial-gradient(circle, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%);*/
		/*}*/

		@media (max-width: 991px) {
			.menu .navbar-collapse.show {
				overflow: inherit !important;
			}

			.dropdown-menu.show {
				margin-top: 60px !important;
			}
		}

		.cid-uiic8SDzwO .navbar .dropdown.open > .dropdown-menu {
			margin-top: -15px;
		}
	</style>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" crossorigin="anonymous" />
</head>

<body style="background-color: #ffffff" data-google-ads-ver="<?php echo isset($cnn) ? base64_encode($cnn) : ''; ?>">

<?php echo $this->element('hss/nav'); ?>
<div class="content-main">
	<?php echo $this->Session->flash(); ?>

	<div class="<?php echo !$isLanding ? 'py-5' : ''; ?>">
		<?php echo $this->fetch('content'); ?>
	</div>
</div>

<?php
$hideFooter = $hideFooter ?? false;

if ($hideFooter === false) {
	?>
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
						<div class="soc-item">
							<a href="https://x.com/bhel_hss" target="_blank">
								<span class="mbr-iconfont socicon-twitter socicon"></span>
							</a>
						</div>
						<div class="soc-item">
							<a href="https://www.instagram.com/bhelhss/" target="_blank">
								<span class="mbr-iconfont socicon-instagram socicon"></span>
							</a>
						</div>
						<div class="soc-item">
							<a href="https://www.linkedin.com/in/bhelhss" target="_blank">
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
					<p class="mbr-fonts-style copyright display-7">© 2024 BHEL Higher Secondary School Alumni. All
						Rights Reserved.</p>
				</div>
			</div>
		</div>
	</section>
	<?php
}
?>

<?php echo $this->element('hss/footer_scripts'); ?>

</body>
</html>
