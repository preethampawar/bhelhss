<?php
if(isset($comments) and !empty($comments)) {		
	$commentsCount = count($comments);
	
?>	
<strong> Comments (<?php echo $commentsCount;?>)</strong>	
	<?php
	foreach($comments as $row) {
		$commentID = $row['Comment']['id'];
		$commentName = $row['Comment']['name'];		
		
		$commentTime = $this->Time->timeAgoInWords($row['Comment']['created'], array('format'=>'F jS, Y', 'end'=>'+1 days'));		
		
		$userID = $row['User']['id'];
		$userName = $row['User']['name'];		
		
		$imageID = $row['Comment']['image_id'];
		$bgColor = null;
		if(Validation::blank($row['Comment']['block_user_ids'])) {
			if($userID == $this->Session->read('User.id')) {
				$bgColor = 'background-color: #EFFFE6;';
			}		
		}
		else {		
			$bgColor = (!empty($row['Comment']['block_user_ids'])) ? 'background-color: #FFF6EC; ' : null;
		}
?>
		<div style="font-size:11px; padding: 2px; border-bottom:1px dotted #aaa; margin-bottom:5px; <?php echo $bgColor;?>" id="photoCommentBox<?php echo $imageID.'-'.$commentID;?>">
			<div class="floatLeft">
				<?php echo $this->Html->link($userName, array('controller'=>'users', 'action'=>'info', $userID), array('target'=>'_blank'));?><br>
			</div>
			
			<div class="floatRight" id="blockCommentDiv<?php echo $commentID;?>" style="margin-right:10px;">
				<?php echo $this->element('photo_comment_block', array('comment'=>$row));?>									
			</div>						
			
			<div class="clear"></div>
			
			<?php echo $commentName;?>
			
			<div style="margin-top:8px; font-style:italic;">
				<div class="floatLeft" id="likeCommentDiv<?php echo $commentID;?>">
					<?php echo $this->element('comment_likes', array('comment'=>$row));?>									
				</div>
				
				<div class="floatRight" style="color:orange;"><?php echo $commentTime;?></div>
				<div class="clear"  style="clear:both;"></div>
			</div>
		</div>
<?php	
	}
}
?>	
		  