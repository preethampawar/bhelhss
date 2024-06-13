<?php
if(!empty($comment)) {
	$commentID = $comment['Comment']['id'];
	
	$userIDs = $comment['Comment']['block_user_ids'];

	$currentUserID = $this->Session->read('User.id');	
	$blockVotes = 0;
	if(!empty($userIDs)) {
		$userIDs = explode(',',$userIDs);
		$commentLikes = '('.count($userIDs).')'	;
		$blockVotes = count($userIDs);
	}
	else {
		$commentLikes = '(0)';
		$userIDs = explode(',',$userIDs);
	}
	$reqVotesCount = Configure::read('CommentBlockVotes');	
	$reqVotesToBlock = $reqVotesCount - $blockVotes;
	
	?>
	<div class="floatLeft">
	<?php
	if(($comment['Comment']['user_id'] != $this->Session->read('User.id')) and !$this->Session->read('User.admin')) {
	?>
		<?php	
		if(in_array($currentUserID, $userIDs)) {
		?>
			<span title="<?php echo $reqVotesToBlock;?> Vote(s) needed to block this comment" style="cursor: default;">
				<?php echo $this->Html->image('block_icon.png', array('height'=>'15', 'class'=>'floatLeft', 'style'=>'margin-top:3px;'));?> <?php echo $commentLikes;?> need <?php echo $reqVotesToBlock;?> more 
			</span>
			<!-- <span onclick="blockComment('<?php echo $commentID;?>')" title="Unblock this comment"  style="cursor:pointer; color:blue;">unblock</span> -->
		<?php	
		}
		else {
		?>			
			<span onclick="blockComment('<?php echo $commentID;?>')" title="<?php echo $reqVotesToBlock;?> Vote(s) needed to block this comment"  style="cursor:pointer; color:blue;">
				<?php echo $this->Html->image('block_icon.png', array('height'=>'15', 'alt'=>'Block', 'class'=>'floatLeft', 'style'=>'margin-top:2px;'));?> 
				<?php echo $commentLikes;?>
			</span>
		<?php
		}
		?>
	<?php
	}
	else {
	?>
		<div title='<?php echo ($blockVotes > 1) ? $blockVotes. 'people have ' : $blockVotes.' person has';?> voted to block this comment.'  class="floatLeft">
			<?php echo $this->Html->image('block_icon.png', array('height'=>'15', 'alt'=>'Block', 'class'=>'floatLeft', 'style'=>'margin-top:3px;'));?> 
			<?php echo $commentLikes;?>
		</div>
		
	<?php
	}
	?>
	</div>
<?php		
}
else {
	echo 'Comment Removed';
}
?>

