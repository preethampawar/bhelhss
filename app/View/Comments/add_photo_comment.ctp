
<?php echo $this->element('simple_message');?>
<?php echo $this->element('add_photo_comment');?>
<br>

<div id="photoCommentsList<?php echo $imageID;?>">	
	
	<div style="">	
		<?php
		if(isset($comments) and !empty($comments)) {
		?>
			<?php echo $this->element('list_photo_comments');?>
			<div class='clear'></div>
		<?php	
		}
		?>
	</div>
</div>


<script type="text/javascript">
setInterval("updatePhotoComments('<?php echo $encodedImageID;?>', '<?php echo $imageID;?>')", '10000');	
</script>