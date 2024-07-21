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
				$date = date('d-m-Y h:i A', strtotime($post['Post']['created']));
				$postImages = $post['Image'];
				$imageUrls = [];

				foreach($postImages as $row) {
					$imageID = $row['id'];
					$imageCaption = !empty($row['caption']) ? $row['caption'] : $title;

					if ($this->Img->imageExists('img/images/'.$imageID)) {
						$imageUrls[] = $this->Img->showImage('img/images/'.$imageID, array('height'=>'600','width'=>'600','type'=>'original'), array('style'=>'', 'alt'=>$title, 'title'=>$imageCaption), true);
					}
				}
				$i++;
				?>
				<div class="bg-light text-dark p-4 rounded-3 mb-4" style="border-radius: 2rem !important;">
					<div class="row justify-content-start item features-without-image <?php echo $i == 1 ? 'active' : '' ?>">
						<div class="order-1 order-lg-0 col-md-12 <?php echo !empty($imageUrls) ? 'col-lg-6' : ''; ?>">
							<p class="mbr-card-subtitle mbr-fonts-style mt-0 mb-2 display-7 text-warning">
								<?php echo $date; ?>
							</p>
							<h5 class="mbr-card-title mbr-fonts-style mt-0 mb-3 display-5 text-primary">
								<strong><?php echo $title; ?></strong>
							</h5>
							<div class="mbr-text mbr-fonts-style mt-0 display-7"><?php echo $description; ?></div>
						</div>

						<?php
						if (!empty($imageUrls)) {
						?>
							<div class="order-0 order-lg-1 col-md-12 col-lg-6 item-wrapper">
								<div class="image-wrapper mb-5">
									<?php
									if (!empty($imageUrls)) {
										foreach($imageUrls as $imageUrl) {
											?>
											<img src="<?php echo $imageUrl; ?>" alt="<?php echo $title ?>" data-slide-to="0" class="w-auto  m-auto" style="max-width: 100%;">
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
				<div class="col-md-12 col-lg-6">

					<h5 class="mbr-card-title mbr-fonts-style mt-0 mb-2 display-5">
						<strong>No news or events found.</strong>
					</h5>
				</div>
				<div class="col-md-12 col-lg-6 item-wrapper">
					<div class="image-wrapper mb-5">
						<img src="https://r.mobirisesite.com/558418/assets/images/11.jpg?rnd=1721234087845" alt="no news or events" data-slide-to="0">
					</div>
				</div>
			</div>
			<?php
		}
		?>


	</div>
</section>
