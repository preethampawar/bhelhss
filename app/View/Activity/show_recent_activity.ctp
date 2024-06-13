<div style="float:left; width:200px; padding:0 10px 0 10px;">
	<h2>Recent Activity</h2>	
	
	
	<div style="margin-bottom:5px;">
		<?php echo $this->Html->link('New Photos', '/activity/showRecentActivity/NewPhotos');?> 
		<?php if($photoUploadsCount) { ?>
		<span style="font-style:italic; font-size:11px; color:orange;"><?php echo "($photoUploadsCount)";?></span>
		<?php } ?>	
	</div>
	<div style="margin-bottom:5px;">
		<?php echo $this->Html->link('Photo Comments', '/activity/showRecentActivity/PhotoComments');?>
		<?php if($photoCommentsCount) { ?>
		<span style="font-style:italic; font-size:11px; color:orange;"><?php echo "($photoCommentsCount)";?></span>
		<?php } ?>	
	</div>
	<div style="margin-bottom:5px;">
		<?php echo $this->Html->link('Photo Likes', '/activity/showRecentActivity/PhotoLikes');?>
		<?php if($likePhotosCount) { ?>
		<span style="font-style:italic; font-size:11px; color:orange;"><?php echo "($likePhotosCount)";?></span>
		<?php } ?>	
	</div>
	<div style="margin-bottom:5px;">
		<?php echo $this->Html->link('Comment Likes', '/activity/showRecentActivity/CommentLikes');?>
		<?php if($likeCommentsCount) { ?>
		<span style="font-style:italic; font-size:11px; color:orange;"><?php echo "($likeCommentsCount)";?></span>
		<?php } ?>	
	</div>
	<div style="margin-bottom:5px;">
		<?php echo $this->Html->link('New Posts', '/activity/showRecentActivity/NewPosts');?>
		<?php if($newPostRequestsCount) { ?>
		<span style="font-style:italic; font-size:11px; color:orange;"><?php echo "($newPostRequestsCount)";?></span>
		<?php } ?>	
	</div>
	<br>
	<h2>Block Requests</h2>
	<div style="margin-bottom:5px;">
		<?php echo $this->Html->link('Block Photos', '/activity/showRecentActivity/BlockPhotos');?>
		<?php if($blockPhotoRequestsCount) { ?>
		<span style="font-style:italic; font-size:11px; color:orange;"><?php echo "($blockPhotoRequestsCount)";?></span>
		<?php } ?>		
	</div>
	<div style="margin-bottom:5px;">
		<?php echo $this->Html->link('Block Comments', '/activity/showRecentActivity/BlockComments');?>
		<?php if($blockCommentRequestsCount) { ?>
		<span style="font-style:italic; font-size:11px; color:orange;"><?php echo "($blockCommentRequestsCount)";?></span>
		<?php } ?>	
	</div>
	<div style="margin-bottom:5px;">
		<?php echo $this->Html->link('Block Posts', '/activity/showRecentActivity/BlockPosts');?>
		<?php if($blockPostRequestsCount) { ?>
		<span style="font-style:italic; font-size:11px; color:orange;"><?php echo "($blockPostRequestsCount)";?></span>
		<?php } ?>	
	</div>		
</div>
<div style="float:left; margin-left:30px; width:650px;">

	
	<!-- New Photo Uploads -->
	<?php
	if($type == 'NewPhotos') {
		echo $this->element('Activity/photo_uploads', array('photoUploads'=>$photoUploads));
	}
	?>
	
	<!-- Photo Comments -->
	<?php
	if($type == 'PhotoComments') {
		echo $this->element('Activity/photo_comments', array('photoComments'=>$photoComments));
	}
	?>
	
	<!-- Photo Likes -->
	<?php
	if($type == 'PhotoLikes') {
		echo $this->element('Activity/photo_likes', array('photoLikes'=>$likePhotos));
	}
	?>
	
	<!-- Comment Likes -->
	<?php
	if($type == 'CommentLikes') {
		echo $this->element('Activity/comments_likes', array('likeComments'=>$likeComments));
	}
	?>
	
	<!-- New Posts -->
	<?php
	if($type == 'NewPosts') {
		echo $this->element('Activity/new_post_requests', array('newPostRequests'=>$newPostRequests));
	}
	?>
	
	<!-- Block Photo Requests -->
	<?php
	if($type == 'BlockPhotos') {
		echo $this->element('Activity/block_photo_requests', array('blockPhotoRequests'=>$blockPhotoRequests));
	}
	?>

	<!-- Block Comments -->	
	<?php
	if($type == 'BlockComments') {
		echo $this->element('Activity/block_comment_requests', array('blockCommentRequests'=>$blockCommentRequests));	
	}
	?>
	
	<!-- Block Post -->	
	<?php
	if($type == 'BlockPosts') {
		echo $this->element('Activity/block_posts', array('blockPostRequests'=>$blockPostRequests));	
	}
	?>

</div>
<div style="clear:both;"></div>
<br><br>
