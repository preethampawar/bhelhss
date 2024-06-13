<?php 
echo $this->Html->css('jquery.lightbox-0.5', false); // jQuery Light box
echo $this->Html->script('jquery.lightbox-0.5', false); // jQuery Light box	
?>

<div id="postImage">
	<?php
	if(!empty($postPhotoInfo)) {
		$views = $postPhotoInfo['Image']['views'];
	?>
		<span class="floatRight button orange small" title="Page views: <?php echo $views;?>">Page Views: <?php echo $views;?></span>
		
		<?php echo $this->Html->link('&laquo; Back', '/images/showPostPhotoUploads/'.$postPhotoInfo['Post']['id'], array('escape'=>false));?></h3>
		<br>
		<br>
		<h3><?php echo $postPhotoInfo['Post']['title'];?> </h3>
		
		<script type="text/javascript">
		$(function() {
			$('.postPhotos a').lightBox();
		});
		</script>
		
		
		<div id="showPhotoBox<?php echo $postPhotoInfo['Image']['id'];?>" class="clear">
			<?php echo $this->element('show_post_photo', array('photoInfo'=>$postPhotoInfo));?>
		</div>
	<?php
	}
	else {
		echo ' - Photo Not Found';
	}
	?>
</div>



