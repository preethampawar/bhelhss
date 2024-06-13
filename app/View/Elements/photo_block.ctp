<?php
if(!empty($photoInfo)) {	
	$imageID = $photoInfo['Image']['id'];
	$userIDs = $photoInfo['Image']['block_user_ids'];

	$currentUserID = $this->Session->read('User.id');	
	$blockVotes = 0;
	if(!empty($userIDs)) {
		$userIDs = explode(',',$userIDs);
		$likes = '('.count($userIDs).')'	;
		$blockVotes = count($userIDs);
	}
	else {
		$likes = '(0)';
		$userIDs = explode(',',$userIDs);
	}
	$reqVotesCount = Configure::read('PhotoBlockVotes');	
	$reqVotesToBlock = $reqVotesCount - $blockVotes;
	
	?>
	<div class="floatLeft">
	<?php
	if(($photoInfo['Image']['uploaded_by'] != $this->Session->read('User.id')) and !$this->Session->read('User.admin')) {
	?>
		<?php	
		if(in_array($currentUserID, $userIDs)) {
		?>
			<span title="<?php echo $reqVotesToBlock;?> Vote(s) needed to block this photo" style="cursor: default;">
				<?php echo $this->Html->image('block_icon.png', array('height'=>'16', 'class'=>'floatLeft', 'style'=>'margin-top:2px;'));?> <?php echo $likes;?>
			</span>
			<!-- <span onclick="blockComment('<?php echo $imageID;?>')" title="Unblock this comment"  style="cursor:pointer; color:blue;">unblock</span> -->
		<?php	
		}
		else {
		?>
			<span onclick="blockPhoto('<?php echo $imageID;?>')" title="<?php echo $reqVotesToBlock;?> Vote(s) needed to block this photo"  style="cursor:pointer; color:blue;">
				<?php echo $this->Html->image('block_icon.png', array('height'=>'16', 'alt'=>'Block', 'class'=>'floatLeft', 'style'=>'margin-top:2px;'));?> 
				<?php echo $likes;?>
			</span>
		<?php
		}
		?>
	<?php
	}
	else {
	?>
		<div title='<?php echo $blockVotes;?> have voted to block this photo.' class="floatLeft">
			<?php echo $this->Html->image('block_icon.png', array('height'=>'15', 'alt'=>'Block', 'class'=>'floatLeft', 'style'=>'margin-top:3px;'));?> 
			<?php echo $likes;?>
		</div>
		<div class="floatLeft">
		&nbsp;&nbsp;|&nbsp;&nbsp;
		</div>
		<div class="floatLeft">
			<span onclick="removePhoto('<?php echo $imageID;?>')" title="Remove this photo"  style="cursor:pointer; color:blue;">
				<?php echo $this->Html->image('delete_icon.gif', array('height'=>'10', 'alt'=>'Remove', 'class'=>'floatLeft', 'style'=>'margin-top:6px;'));?>
			</span>
		</div>			
	<?php
	}
	?>
	</div>
<?php		
}
else {
	echo 'Photo Removed';
}
?>

