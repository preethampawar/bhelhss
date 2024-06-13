<?php
$commentID = $comment['Comment']['id'];
$userIDs = $comment['Comment']['likes_user_ids'];

	$currentUserID = $this->Session->read('User.id');	
	if(!empty($userIDs)) {
		$userIDs = explode(',',$userIDs);
		$commentLikes = '('.count($userIDs).')'	;
	}
	else {
		$commentLikes = null;
		$userIDs = explode(',',$userIDs);
	}
	 
	?>
	<div class="floatLeft">
	<?php
	if(in_array($currentUserID, $userIDs)) {
	?>
		<?php echo $this->Html->image('like.gif', array('alt'=>'like', 'style'=>'margin:2px 2px 0 0;', 'class'=>'floatLeft'));?> <?php echo $commentLikes;?> &nbsp;
		<!-- <span onclick="likeComment('<?php echo $commentID;?>')" title="Unlike this comment"  style="cursor:pointer; color:blue;">unlike</span> -->
	<?php	
	}
	else {
	?>
		<?php echo $this->Html->image('like.gif', array('alt'=>'like', 'style'=>'margin:2px 3px 0 0;', 'class'=>'floatLeft'));?> <?php echo $commentLikes;?>
		<span onclick="likeComment('<?php echo $commentID;?>')" title="Like this comment"  style="cursor:pointer; color:blue;">like</span>
	<?php
	}
	?>
	</div>
	<?php
?>

