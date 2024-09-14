<?php
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
$this->set('title_for_layout', '');

// landing page top slider images
$dir = new Folder(WWW_ROOT . 'img/landing_page_slider/');
$landingPageSliderfiles = $dir->findRecursive('.*\.jpg|.png|.jpeg|.gif|.bmp');
$landingPageSliderImages = [];
if (!empty($landingPageSliderfiles)) {
	foreach ($landingPageSliderfiles as $file) {
		$img = basename($file);
		$landingPageSliderImages[] = '/img/landing_page_slider/' . $img;
	}
}

// landing page gallery images (Reliving the golden days..)
$dir = new Folder(WWW_ROOT . 'img/landing_page_gallery/');
$landingPageGalleryFiles = $dir->findRecursive('.*\.jpg|.png|.jpeg|.gif|.bmp');
$landingPageGalleryImages = [];
if (!empty($landingPageGalleryFiles)) {
	foreach ($landingPageGalleryFiles as $file) {
		$img = str_replace(WWW_ROOT, '', $file);
		$landingPageGalleryImages[] = $img;
	}
}
//debug($landingPageGalleryImages);
?>
<link rel="stylesheet" href="/lightbox2/dist/css/lightbox.min.css">
<section data-bs-version="5.1" class="header16 cid-uie1F6G4lr mbr-fullscreen"
		 data-bg-video="https://www.youtube.com/embed/2Gg6Seob5Mg?rel=0&amp;&amp;showinfo=0&amp;autoplay=1&amp;loop=1"
		 id="hero-17-uie1F6G4lr" style="background-image: linear-gradient(to right, #434343 0%, black 100%);">
	<div class="mbr-overlay" style="opacity: 0.1; background-color: rgb(0, 0, 0);"></div>
	<div class="container-fluid">
		<div class="row">
			<div class="content-wrap col-12 col-md-7" style="padding-left: 32px;">
				<h1 class="mbr-section-title mbr-fonts-style mbr-white mb-3 display-1">
					<strong>EUPHORIA 2024</strong>
				</h1>
				<h2 class="mbr-section-title mbr-fonts-style mbr-white mb-3 fs-1">BHEL HSS ALUMNI MEET</h2>

				<p class="mbr-fonts-style mbr-text mbr-white mb-4 display-7 fs-6 d-none">
					<a href="mailto:contactus@bhelhss.com" class="link-info text-decoration-underline">Email
						us</a> for more details.
				</p>
				<p class="mbr-fonts-style mbr-text mbr-white mb-2 display-8 text-info fs-2 fw-bolder">
					22-Dec-2024
				</p>
				<p class="mbr-fonts-style mbr-text mbr-white mb-3 display-7">
					Meet your school teachers, staff, classmates and friends!
				</p>
				<p class="mbr-fonts-style mbr-text mbr-white mb-4 display-7">Reconnect, Reminisce and Revel in the
					Nostalgia at BHEL Higher Secondary School Alumni Event!</p>
				<div class="mbr-section-btn">
					<div contenteditable="true" style="position: absolute; left: -100000px; opacity: 0;"></div>
					<?php
					if (!$this->Session->read('AlumniMember')) {
						?>
							<a class="btn btn-primary display-7" href="/hss/register">Register Now!</a></div>
						<?php
					}
					?>
			</div>
		</div>
	</div>
</section>

<?php
if (!empty($landingPageSliderImages)) {
	?>
	<section data-bs-version="5.1" class="slider3 cid-uie65GJpci bg-light pb-0" id="slider03-0"
			 style='
			 	background-image: url("/img/pattern_bg/abstract-pattern-design_1053-539.avif");
			 	background-repeat: repeat;
			 	background-size: auto;'>
		<div class="row justify-content-center">
			<div class="col-12 content-head">
				<div class="title-wrapper mb-4 ">
					<h4 class="mbr-section-maintitle mbr-fonts-style mb-0 display-2 text-center">
						<strong>BHEL Higher Secondary School</strong>
					</h4>
				</div>
			</div>
		</div>

		<div class="carousel slide" id="uiN5FaRxN3" data-ride="carousel" data-bs-ride="carousel" data-interval="3000"
			 data-bs-interval="3000">
			<ol class="carousel-indicators">
				<?php
				$k = 0;
				foreach ($landingPageSliderImages as $image) {
					?>
					<li
						class="<?php echo $k == 0 ? 'active' : ''; ?>"
						data-slide-to="<?php echo $k; ?>"
						data-bs-slide-to="<?php echo $k; ?>"
						data-target="#uiN5FaRxN3"
						data-bs-target="#uiN5FaRxN3"
						<?php echo $k == 0 ? 'aria-current="true"' : ''; ?>></li>
					<?php
					$k++;
				}
				?>
			</ol>
			<div class="carousel-inner">
				<?php
				$k = 0;
				$image = '';
				foreach ($landingPageSliderImages as $image) {
					?>
					<div class="carousel-item slider-image item <?php echo $k == 0 ? 'active' : ''; ?>">
						<div class="item-wrapper">
							<img class="d-block img-fluid" src="<?php echo $image; ?>" alt="" <?php echo $k > 0 ? 'loading="lazy"': '' ?>>
						</div>
					</div>
					<?php
					$k++;
				}
				?>
			</div>
			<a class="carousel-control carousel-control-prev" role="button" data-slide="prev" data-bs-slide="prev"
			   href="#uiN5FaRxN3">
				<span class="mobi-mbri mobi-mbri-arrow-prev" aria-hidden="true"></span>
				<span class="sr-only visually-hidden">Previous</span>
			</a>
			<a class="carousel-control carousel-control-next" role="button" data-slide="next" data-bs-slide="next"
			   href="#uiN5FaRxN3">
				<span class="mobi-mbri mobi-mbri-arrow-next" aria-hidden="true"></span>
				<span class="sr-only visually-hidden">Next</span>
			</a>
		</div>
	</section>
	<?php
}
?>

<?php
if (!empty($landingPageGalleryImages)) {
?>
	<section data-bs-version="5.1" class="slider4 mbr-embla cid-uie1F6HgIb" id="gallery-13-uie1F6HgIb"
			 style='
			 	background-image: url("/img/pattern_bg/240_F_200100343_CSBe1jRi8fBHRfza6kBlOrZz5OvPTZwV.jpg");
			 	background-repeat: repeat;
			 	background-size: auto;'>
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-12 content-head">
					<div class="title-wrapper mb-4 ">
						<h4 class="mbr-section-maintitle mbr-fonts-style mb-0 display-2"><strong>Reliving the Golden
								Days!</strong></h4>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="embla position-relative" data-skip-snaps="true" data-align="center"
						 data-contain-scroll="trimSnaps" data-loop="true" data-auto-play="true" data-auto-play-interval="5"
						 data-draggable="true">
						<div class="embla__viewport">
							<div class="embla__container">
								<?php
								foreach($landingPageGalleryImages as $image) {
									?>
									<div class="embla__slide slider-image item" style="margin-left: 1rem; margin-right: 1rem;">
										<div class="slide-content">
											<div class="item-img">
												<div class="item-wrapper">
													<a class="example-image-link" href="/<?php echo $image; ?>" data-lightbox="example-1">
														<img src="<?php echo $image; ?>" alt="" title="" loading="lazy">
													</a>
												</div>
											</div>
										</div>
									</div>
									<?php
								}
								?>
							</div>
						</div>
						<button class="embla__button embla__button--prev">
							<span class="mobi-mbri mobi-mbri-arrow-prev" aria-hidden="true"></span>
							<span class="sr-only visually-hidden visually-hidden">Previous</span>
						</button>
						<button class="embla__button embla__button--next">
							<span class="mobi-mbri mobi-mbri-arrow-next" aria-hidden="true"></span>
							<span class="sr-only visually-hidden visually-hidden">Next</span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
}
?>
<section data-bs-version="5.1" class="video05 cid-uieQHksWqD bg-light" id="video05-2"
		 style='
			 	background-image: url("/img/pattern_bg/240_F_292061200_SKmI4oMmSkAQRg4R7dGuueBNjeGRD7mW.jpg");
			 	background-repeat: repeat;
			 	background-size: auto;'>
	<div class="container">
		<div class="row justify-content-center">
			<div class="title-wrapper mb-4">
				<h4 class="mbr-section-maintitle mbr-fonts-style mb-0 display-2"><strong>Golden Jubliee Celebrations<br>Reunion
						- 2014<br></strong></h4>
			</div>
			<div class="col-12 col-lg-10 video-block">
				<div class="mbr-figure">
					<iframe width="1280" height="auto" style="min-height:450px;"
							src="https://www.youtube.com/embed/Tx8TA8f9i1w?si=tBQMnRr3vVx4RYZN&amp;controls=0"
							title="YouTube video player" frameborder="0"
							allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
							referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>
</section>

<section data-bs-version="5.1" class="article8 cid-uie1F6GvMy" id="about-us-8-uie1F6GvMy"
		 style='
				background-color: #eef6fc !important;
			 	background-image: url("/img/pattern_bg/240_F_774652086_f0dOtzFGe3hkFEWdTwZsS2xblOJXcLB2.jpg");
			 	background-repeat: repeat;
			 	background-size: auto;'>
	<div class="container">
		<div class="row justify-content-center">
			<div class="card col-md-12 col-lg-10">
				<div class="card-wrapper p-5">
					<div class="card-content-text">
						<div class="title-wrapper mb-4">
							<h4 class="mbr-section-maintitle mbr-fonts-style mb-0 display-2 text-center"><strong>Connecting
									Alumni Community</strong></h4>
						</div>
						<div class="row align-left">
							<div class="item features-without-image col-12">
								<div class="item-wrapper">

									<p class="mbr-text mbr-fonts-style display-7">Welcome to the vibrant world of BHEL
										Higher Secondary School Alumni! Get ready to relive the nostalgia and create new
										memories at our upcoming event, EUPHORIA 2024, on December 22, 2024. It's a time
										to reunite with old friends, classmates, and beloved teachers, and share
										laughter and stories from the good old school days.</p>
								</div>
							</div>
							<div class="item features-without-image col-12">
								<div class="item-wrapper">

									<p class="mbr-text mbr-fonts-style display-7">Our alumni association is dedicated to
										fostering lifelong connections and celebrating the spirit of togetherness. Join
										us in this exciting journey filled with laughter, joy, and a sprinkle of
										mischief!</p>
								</div>
							</div>
							<div class="item features-without-image col-12">
								<div class="item-wrapper">

									<p class="mbr-text mbr-fonts-style display-7">At BHEL Higher Secondary School
										Alumni, we believe in creating moments that last a lifetime. Come, be a part of
										our ever-growing family and let's make EUPHORIA 2024 an event to remember!</p>
								</div>
							</div>

						</div>
					</div>
					<div class="image-wrapper d-flex justify-content-center mt-3">
						<img src="/img/association_members.jpeg" alt="Association Members" class="img-fluid" loading="lazy">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section data-bs-version="5.1" class="list1 cid-uie1F6IlgQ bg-light" id="faq-1-uie1F6IlgQ"
		 style='background-image: url("/img/pattern_bg/240_F_690781074_pKqsKxPrjzUyHTIAhbMGAN7xKfCqQ12O.jpg"); background-repeat: repeat;background-size: auto;'>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-md-12 col-lg-10 m-auto">
				<div class="content">
					<div class="row justify-content-center mb-4">
						<div class="col-12 content-head">
							<div class="mbr-section-head">
								<h4 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2">
									<strong>Curious Minds</strong>
								</h4>

							</div>
						</div>
					</div>
					<div id="bootstrap-accordion_12" class="panel-group accordionStyles accordion" role="tablist"
						 aria-multiselectable="true">
						<div class="card">
							<div class="card-header" role="tab" id="headingOne">
								<a role="button" class="panel-title collapsed" data-toggle="collapse"
								   data-bs-toggle="collapse" data-core="" href="#collapse1_12" aria-expanded="false"
								   aria-controls="collapse1">
									<h6 class="panel-title-edit mbr-semibold mbr-fonts-style mb-0 display-5">What is
										EUPHORIA 2024 all about?</h6>
									<span class="sign mbr-iconfont mobi-mbri-arrow-down"></span>
								</a>
							</div>
							<div id="collapse1_12" class="panel-collapse noScroll collapse" role="tabpanel"
								 aria-labelledby="headingOne" data-parent="#accordion"
								 data-bs-parent="#bootstrap-accordion_12">
								<div class="panel-body">
									<p class="mbr-fonts-style panel-text display-7">EUPHORIA 2024 is a grand reunion
										event for BHEL High alumni to reconnect, reminisce, and create new memories
										together!</p>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-header" role="tab" id="headingOne">
								<a role="button" class="panel-title collapsed" data-toggle="collapse"
								   data-bs-toggle="collapse" data-core="" href="#collapse2_12" aria-expanded="false"
								   aria-controls="collapse2">
									<h6 class="panel-title-edit mbr-semibold mbr-fonts-style mb-0 display-5">How can I
										participate in EUPHORIA 2024?</h6>
									<span class="sign mbr-iconfont mobi-mbri-arrow-down"></span>
								</a>
							</div>
							<div id="collapse2_12" class="panel-collapse noScroll collapse" role="tabpanel"
								 aria-labelledby="headingOne" data-parent="#accordion"
								 data-bs-parent="#bootstrap-accordion_12">
								<div class="panel-body">
									<p class="mbr-fonts-style panel-text display-7">To join EUPHORIA 2024, simply
										register on our website and get ready for a nostalgic journey back to BHEL
										Higher Secondary School!</p>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-header" role="tab" id="headingOne">
								<a role="button" class="panel-title collapsed" data-toggle="collapse"
								   data-bs-toggle="collapse" data-core="" href="#collapse3_12" aria-expanded="false"
								   aria-controls="collapse3">
									<h6 class="panel-title-edit mbr-semibold mbr-fonts-style mb-0 display-5">Are family
										members allowed at EUPHORIA 2024?</h6>
									<span class="sign mbr-iconfont mobi-mbri-arrow-down"></span>
								</a>
							</div>
							<div id="collapse3_12" class="panel-collapse noScroll collapse" role="tabpanel"
								 aria-labelledby="headingOne" data-parent="#accordion"
								 data-bs-parent="#bootstrap-accordion_12">
								<div class="panel-body">
									<p class="mbr-fonts-style panel-text display-7">Yes, family members are more than
										welcome to join the celebration at EUPHORIA 2024 and experience the magic of
										BHEL Higher Secondary School!</p>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-header" role="tab" id="headingOne">
								<a role="button" class="panel-title collapsed" data-toggle="collapse"
								   data-bs-toggle="collapse" data-core="" href="#collapse4_12" aria-expanded="false"
								   aria-controls="collapse4">
									<h6 class="panel-title-edit mbr-semibold mbr-fonts-style mb-0 display-5">What should
										I wear to EUPHORIA 2024?</h6>
									<span class="sign mbr-iconfont mobi-mbri-arrow-down"></span>
								</a>
							</div>
							<div id="collapse4_12" class="panel-collapse noScroll collapse" role="tabpanel"
								 aria-labelledby="headingOne" data-parent="#accordion"
								 data-bs-parent="#bootstrap-accordion_12">
								<div class="panel-body">
									<p class="mbr-fonts-style panel-text display-7">Dress to impress! Show off your
										unique style and relive the fashion trends of your BHEL Higher Secondary School
										days at EUPHORIA 2024!</p>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-header" role="tab" id="headingOne">
								<a role="button" class="panel-title collapsed" data-toggle="collapse"
								   data-bs-toggle="collapse" data-core="" href="#collapse5_12" aria-expanded="false"
								   aria-controls="collapse5">
									<h6 class="panel-title-edit mbr-semibold mbr-fonts-style mb-0 display-5">Will there
										be food at EUPHORIA 2024?</h6>
									<span class="sign mbr-iconfont mobi-mbri-arrow-down"></span>
								</a>
							</div>
							<div id="collapse5_12" class="panel-collapse noScroll collapse" role="tabpanel"
								 aria-labelledby="headingOne" data-parent="#accordion"
								 data-bs-parent="#bootstrap-accordion_12">
								<div class="panel-body">
									<p class="mbr-fonts-style panel-text display-7">Indulge in delicious treats and
										nostalgic flavors at EUPHORIA 2024, where culinary delights await to tantalize
										your taste buds!</p>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section data-bs-version="5.1" class="contacts03 cid-uie1F6K9vk" id="contacts-11-uie1F6K9vk"
		 style='
			 	background-image: url("/img/pattern_bg/240_F_532175048_dX1y4TCCyDiaZhMeR9hBpE1y6q2BcvvZ.jpg");
			 	background-repeat: repeat;
			 	background-size: auto;'>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-lg-10">
				<h5 class="mbr-section-title mbr-fonts-style mt-0 mb-3 display-2 text-center">
					<strong>Connect Now</strong>
				</h5>
				<p class="mbr-section-subtitle mbr-fonts-style mt-0 mb-4 display-7 text-center">
					<!--						Phone: 123-456-7890-->
					<b>BHEL Higher Secondary School</b>
					<br>Email: <a href="mailto:contact@bhelhss.com">contact@bhelhss.com</a>
				</p>

			</div>
			<div class="col-12 col-md-12 col-lg-10 side-features">
				<div class="google-map">
					<iframe frameborder="0" style="border:0"
							src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3805.207015880414!2d78.30043527492157!3d17.497628599620448!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb9365f891cd1f%3A0x228e3f7608349805!2sBHEL%20HIGHER%20SECONDARY%20SCHOOL!5e0!3m2!1sen!2sin!4v1720717280202!5m2!1sen!2sin"
							allowfullscreen=""></iframe>
				</div>
			</div>
		</div>
	</div>
</section>

<section data-bs-version="5.1" class="features10 cid-uie1F6IFzA" id="metrics-2-uie1F6IFzA"
		 style='
			 	background-image: url("/img/pattern_bg/240_F_479933799_3VL2PnxOSRqtT8Ghf98YrZi5PGKyZGxC.jpg");
			 	background-repeat: repeat;
			 	background-size: auto;'>
	<div class="container">
		<div class="row justify-content-center">
			<div class="item features-without-image col-12 col-md-6 col-lg-4">
				<div class="item-wrapper">
					<div class="card-box align-left">

						<p class="card-title mbr-fonts-style mb-3 display-1">
							<strong>1500+</strong>
						</p>
						<p class="card-text mbr-fonts-style mb-3 display-7">Excited Alumni</p>

					</div>
				</div>
			</div>
			<div class="item features-without-image col-12 col-md-6 col-lg-4">
				<div class="item-wrapper">
					<div class="card-box align-left">

						<p class="card-title mbr-fonts-style mb-3 display-1">
							<strong>60+</strong>
						</p>
						<p class="card-text mbr-fonts-style mb-3 display-7">Years of Legacy</p>

					</div>
				</div>
			</div>
			<div class="item features-without-image col-12 col-md-6 col-lg-4">
				<div class="item-wrapper">
					<div class="card-box align-left">

						<p class="card-title mbr-fonts-style mb-3 display-1">
							<strong>500+</strong>
						</p>
						<p class="card-text mbr-fonts-style mb-3 display-7">Memorable Moments</p>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section data-bs-version="5.1" class="gallery10 cid-uie1F6GYyK" id="features-61-uie1F6GYyK"
		 style='
			 	background-image: url("/img/pattern_bg/gift-paper_660899-464.avif");
			 	background-repeat: repeat;
			 	background-size: auto;'>

	<div class="container-fluid" style="text-shadow: 2px 5px 2px #efefef;">
		<div class="loop-container">
			<div class="item display-2"
				 data-linewords="Reunite * Celebrate * Memories * Laughter * Friendship * Legacy *" data-direction="-1"
				 data-speed="0.05">Reunite * Celebrate * Memories * Laughter * Friendship * Legacy *
			</div>

			<div class="item display-2"
				 data-linewords="Reunite * Celebrate * Memories * Laughter * Friendship * Legacy *" data-direction="-1"
				 data-speed="0.05">Reunite * Celebrate * Memories * Laughter * Friendship * Legacy *
			</div>
		</div>
	</div>
</section>
<script src="/lightbox2/dist/js/lightbox-plus-jquery.min.js"></script>
