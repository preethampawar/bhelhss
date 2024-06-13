<?php
if($hasActivity) {
	$type = '';
	if(!empty($latestActivityInfo)) {		
		$activityType = $latestActivityInfo['Activity']['type'];
		switch($activityType) {
			case 'photo_upload': $type = 'NewPhotos'; break;
			case 'photo_like': $type = 'PhotoLikes'; break;
			case 'photo_comment': $type = 'PhotoComments'; break;
			case 'photo_block': $type = 'BlockPhotos'; break;
			case 'comment_like': $type = 'CommentLikes'; break;
			case 'comment_block': $type = 'BlockComments'; break;
		}		
	}
?>
	<div style="float:left;">
		<?php echo $this->Html->link($this->Html->image('red_button.png', array('height'=>'16')), '/activity/showRecentActivity/'.$type, array('style'=>'color:orange; font-weight:normal;', 'escape'=>false));?>
	</div>
	<div style="float:left; margin-left:5px;">
		<?php echo $this->Html->link('Recent Activity ('.$hasActivity.')', '/activity/showRecentActivity/'.$type, array('style'=>'color:orange; font-weight:normal;'));?>
	</div>
	<div style="clear:both;"></div>
<?php
}
else {
?>
	<?php echo $this->Html->link('Recent Activity', '/activity/showRecentActivity');?>	
<?php
}
?>
<script type="text/javascript">
	setTimeout('getActivityUpdates()',30000);
</script>