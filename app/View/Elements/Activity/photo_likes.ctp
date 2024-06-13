<h2>Photos liked by users</h2>
<?php
if(!empty($photoLikes)) {
?>
<table class="" width="100%">		
	<tbody>
	<?php
	$i=0;		
	foreach($photoLikes as $row) {
		$i++;
		$activityTime = $this->Time->timeAgoInWords($row['Activity']['created'], array('format'=>'F jS, Y', 'end'=>'+1 days'));	
		$album = 'Unknown';
		$blockCount = 0;
		$likeCount = 0;
		
		if(!empty($row['Image']['id'])) {			
			if(!empty($row['Post']['id'])) {
				$album = $row['Post']['title'];
				$albumUrl = '/images/showPostPhotoUploads/'.$row['Post']['id'];				
			}
			if(!empty($row['Image']['block_user_ids'])) {
				$users = explode(',', $row['Image']['block_user_ids']);
				$blockCount = count($users);			
			}
			
			if(!empty($row['Image']['likes_user_ids'])) {
				$users = explode(',', $row['Image']['likes_user_ids']);
				$likeCount = count($users);			
			}
		}
		$text = '';			
		
		$reqVotesCount = Configure::read('PhotoBlockVotes');	
		$reqVotesToBlock = $reqVotesCount - $blockCount;
		?>
		<tr>				
			<td style="text-align:center; width:75px;">
				<?php
					$imageID = $row['Activity']['image_id'];						
				?>				
				<a href="<?php echo $this->Html->url($row['Activity']['url']);?>" target="_blank">						
					<?php $this->Img->showImage('img/images/'.$imageID, array('height'=>'75','width'=>'75','type'=>'crop'));?>
				</a>
				<div>					
					<?php echo $this->Html->image('like.gif', array('alt'=>'like', 'style'=>'margin:2px 2px 0 0;', 'class'=>''));?>
					(<?php echo $likeCount;?>)
				</div>
			</td>
			<td style="vertical-align:top;">
				<span style="font-style:italic; font-size:90%; color:orange;"><?php echo $activityTime;?></span> <br>
				<a href="<?php echo $this->Html->url('/users/info/'.$row['User']['id']);?>" target="_blank"><?php echo $row['User']['name'];?></a> likes this photo.
				<p><?php echo $text;?></p>
			</td>
		</tr>			
		<tr>
			<td colspan='2'><div style="border-bottom:1px dotted grey;"></div> </td>
		</tr>
	<?php	
	}
	?>
	</tbody>
</table>
<?php 
}
else {
	echo 'No recent activity';
}
?>