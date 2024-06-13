<?php
if(!empty($photoInfo)) {
	$imageID = $photoInfo['Image']['id'];	
	$userIDs = $photoInfo['Image']['likes_user_ids'];

	$currentUserID = $this->Session->read('User.id');	
	if(!empty($userIDs)) {
		$userIDs = explode(',',$userIDs);
		$commentLikes = '('.count($userIDs).')'	;
	}
	else {
		$commentLikes = '(0)';
		$userIDs = explode(',',$userIDs);
	}
	 
	?>
	<div class="floatLeft">
	<?php
	if(in_array($currentUserID, $userIDs)) {
	?>
		<?php echo $this->Html->image('like.gif', array('alt'=>'like'));?> <?php echo $commentLikes;?> &nbsp;
		<!-- <span onclick="likeComment('<?php echo $imageID;?>')" title="Unlike this comment"  style="cursor:pointer; color:blue;">unlike</span> -->
	<?php	
	}
	else {
	?>
		<span onclick="likePhoto('<?php echo $imageID;?>')" title="Like this photo"  style="cursor:pointer; color:blue;">
			<?php echo $this->Html->image('like.gif', array('alt'=>'like'));?> <?php echo $commentLikes;?>		
		</span>
		&nbsp;
	<?php
	}
	?>
	|						
	</div>
<?php
}
?>

