<link rel="stylesheet" href="/lightbox2/dist/css/lightbox.min.css">

<div class="title-wrapper mb-4">
	<h4 class="mbr-section-maintitle mbr-fonts-style mb-0 display-2 text-center"><strong>Gallery</strong></h4>
</div>

<section class="container">
	<div class="d-flex align-content-around flex-wrap">
		<?php
		if (!empty($files)) {
			foreach ($files as $file) {
				$img = str_replace(WWW_ROOT, '', $file);

			?>
				<a class="example-image-link" href="/<?php echo $img; ?>" data-lightbox="example-1">
					<img class="example-image img-thumbnail m-2" src="/<?php echo $img; ?>" alt="image-1" loading="lazy" style="width:300px;"/>
				</a>
			<?php
			}
		}
		?>
	</div>
</section>


<script src="/lightbox2/dist/js/lightbox-plus-jquery.min.js"></script>
