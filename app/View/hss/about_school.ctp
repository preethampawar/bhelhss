<link rel="stylesheet" href="/lightbox2/dist/css/lightbox.min.css">
<section data-bs-version="5.1" class="article12 cid-uiiaMNlS5D pt-0 pb-4 bg-transparent" id="article12-17">

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 content-head">
				<div class="mbr-section-head mb-5">
					<h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2">
						<strong>About BHEL HSS</strong>
					</h3>

				</div>
			</div>
		</div>
		<div class="bg-light text-dark p-4 rounded-3 col-lg-10 mx-auto" style="border-radius: 2rem !important;">
			<div class="row justify-content-center mt-1">
				<div class="col-md-12 mbr-form">
					<?php
					if (!empty($post)) {
						$title = $post['Post']['title'];
						$description = $post['Post']['description'];
						$postImages = $post['Image'];
						$imageUrls = [];

						foreach($postImages as $row) {
							$imageID = $row['id'];
							$imageCaption = !empty($row['caption']) ? $row['caption'] : $title;

							if ($this->Img->imageExists('img/images/'.$imageID)) {
								$imageUrls[] = $this->Img->showImage('img/images/'.$imageID, array('height'=>'600','width'=>'600','type'=>'original'), array('style'=>'', 'alt'=>$title, 'title'=>$imageCaption), true);
							}
						}
						?>

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

						<div class="mbr-text mbr-fonts-style display-7">
							<?php echo($post['Post']['description']); ?>
						</div>
						<?php
					} else {
						?>
						<p class="mbr-text mbr-fonts-style display-7">
							In a fleeting world, photographs are like tiny frames capturing life's essence. They freeze moments, preserving emotions and stories for eternity. Like artwork in frames, photos capture the ordinary and make it
							extraordinary. A smile, a glance, a sunset—they all become chapters in our personal narrative.
							<br>
							<br>Photographers are storytellers. They use frames, light, and composition to craft emotional tales. Each shot is a canvas painted with memories, inviting us to revisit the past. In today's digital age, photos
							connect us globally, but their essence remains timeless, whether on mantelpieces or screens.
							<br>
							<br>Photos as frames bridge generations. Family albums pass down traditions and legacies. Amid life's chaos, photos offer a pause, a chance to reflect and appreciate. They're the threads weaving our life's tapestry,
							reminding us of the beauty in the everyday.
						</p>
						<?php
					}
					?>


				</div>
			</div>
		</div>

	</div>
</section>

<script src="/lightbox2/dist/js/lightbox-plus-jquery.min.js"></script>
