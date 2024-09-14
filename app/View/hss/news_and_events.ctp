<link rel="stylesheet" href="/lightbox2/dist/css/lightbox.min.css">
<style>
	.card-box {
		text-align: revert !important;
	}
</style>
<section data-bs-version="5.1" class="timeline02 cid-uiNQjFYLl5 pt-0" id="timeline02-1e">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 mb-5 content-head">
				<h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2">
					<strong>News & Events</strong>
				</h3>
			</div>
		</div>

		<?php

		if (!empty($posts)) {
			$i = 0;
			foreach ($posts as $post) {
				$title = $post['Post']['title'];
				$description = $post['Post']['description'];
				$date = date('d-m-Y', strtotime($post['Post']['created']));
				$postImages = $post['Image'];
				$imageUrls = [];

				foreach ($postImages as $row) {
					$imageID = $row['id'];
					$imageCaption = !empty($row['caption']) ? $row['caption'] : $title;

					if ($this->Img->imageExists('img/images/' . $imageID)) {
						$imageUrls[] = $this->Img->showImage('img/images/' . $imageID, array('height' => '600', 'width' => '600', 'type' => 'original'), array('style' => '', 'alt' => $title, 'title' => $imageCaption), true);
					}
				}
				$i++;
				?>
				<div class="bg-light text-dark p-4 rounded-3 mb-4 col-lg-10 mx-auto"
					 style="border-radius: 2rem !important;">
					<div
						class="row justify-content-start item features-without-image <?php echo $i == 1 ? 'active' : '' ?>">
						<div class="order-1 order-lg-0 col-md-12 <?php echo !empty($imageUrls) ? 'col-lg-12' : ''; ?>">
							<p class="mbr-card-subtitle mbr-fonts-style mt-0 mb-2 display-7 text-warning">
								<?php echo $date; ?>
							</p>
							<h5 class="mbr-card-title mbr-fonts-style mt-0 mb-3 display-5 text-primary">
								<strong><?php echo $title; ?></strong>
							</h5>
							<?php
							if (!empty($imageUrls)) {
								?>
								<section data-bs-version="5.1" class="slider3 cid-uie65GJpci p-0 m-0 mb-4 bg-dark"
										 id="slider03-0"
										 style="border-radius: 15px;">
									<div class="carousel slide" id="uiN5FaRxN3" data-ride="carousel"
										 data-bs-ride="carousel" data-interval="3000"
										 data-bs-interval="3000" style="height:500px; !important;">
										<ol class="carousel-indicators">
											<?php
											$k = 0;
											foreach ($imageUrls as $image) {
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
											foreach ($imageUrls as $image) {
												?>
												<div
													class="carousel-item slider-image item <?php echo $k == 0 ? 'active' : ''; ?>">
													<div class="item-wrapper">
														<a class="example-image-link" href="<?php echo $image; ?>"
														   data-lightbox="example-1">
															<img class="d-block img-fluid" src="<?php echo $image; ?>"
																 alt="" loading="lazy"
																 style="border-radius: 15px !important; object-fit:contain !important;">
														</a>
													</div>
												</div>
												<?php
												$k++;
											}
											?>
										</div>
										<a class="carousel-control carousel-control-prev" role="button"
										   data-slide="prev" data-bs-slide="prev"
										   href="#uiN5FaRxN3">
											<span class="mobi-mbri mobi-mbri-arrow-prev" aria-hidden="true"></span>
											<span class="sr-only visually-hidden">Previous</span>
										</a>
										<a class="carousel-control carousel-control-next" role="button"
										   data-slide="next" data-bs-slide="next"
										   href="#uiN5FaRxN3">
											<span class="mobi-mbri mobi-mbri-arrow-next" aria-hidden="true"></span>
											<span class="sr-only visually-hidden">Next</span>
										</a>
									</div>
								</section>
								<?php
							}
							?>
							<div class="mbr-text mbr-fonts-style mt-0 display-7"><?php echo $description; ?></div>
						</div>

						<?php
						if (false && !empty($imageUrls)) {
							?>
							<div class="order-0 order-lg-1 col-md-12 col-lg-4 item-wrapper">
								<div class="image-wrapper mb-5 mt-5">
									<?php
									if (!empty($imageUrls)) {
										foreach ($imageUrls as $imageUrl) {
											?>
											<a class="example-image-link" href="<?php echo $imageUrl; ?>"
											   data-lightbox="example-1">
												<img src="<?php echo $imageUrl; ?>" alt="<?php echo $title ?>"
													 data-slide-to="0" class="w-auto  m-auto" style="max-width: 100%;">
											</a>
											<?php
										}
									}
									?>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>

				<?php

			}

		} else {
			?>
			<div class="row justify-content-center item features-without-image active">
				<div class="col-md-12 col-lg-8">

					<h5 class="mbr-card-title mbr-fonts-style mt-0 mb-2 display-5">
						<strong>No news or events found.</strong>
					</h5>
				</div>
			</div>
			<?php
		}
		?>


	</div>
</section>

<script src="/lightbox2/dist/js/lightbox-plus-jquery.min.js"></script>
