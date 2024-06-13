<h2>Photo Comments</h2>
<?php
if(!empty($photoComments)) {
?>
<table width="100%">		
	<tbody>
	<?php
	foreach($photoComments as $row) {			
		$activityTime = $this->Time->timeAgoInWords($row['Activity']['created'], array('format'=>'F jS, Y', 'end'=>'+1 days'));	
		
		// debug($row);
		// exit;
		
		if(!empty($row['Image']['id'])) {
			$imageID = $row['Image']['id'];
			if(!empty($row['Post']['id'])) {
				$album = $row['Post']['title'];
				$albumUrl = '/images/showPostPhotoUploads/'.$row['Post']['id'];				
			}
			if(!empty($row['Image']['block_user_ids'])) {
				$users = explode(',', $row['Image']['block_user_ids']);
				$blockCount = count($users);			
			}
		}
		
		$text = '';				
		
		$count = 0;
		if(!empty($row['Comment']['block_user_ids'])) {
			$users = explode(',', $row['Comment']['block_user_ids']);
			$count = count($users);
		}
		$reqVotesCount = Configure::read('CommentBlockVotes');	
		$reqVotesToBlock = $reqVotesCount - $count;
	?>
		<tr>			
			<td style="vertical-align:top;">
				<span style="font-style:italic; font-size:90%; color:orange;"><?php echo $activityTime;?></span> <br>
				
				<div style="margin-top:5px;">
					<a href="<?php echo $this->Html->url('/users/info/'.$row['User']['id']);?>" target="_blank"><?php echo $row['User']['name'];?></a>
					has commented on a photo.
				</div>
				
				<a href="<?php echo $this->Html->url($row['Activity']['url']);?>" target="_blank" style='color:#555555;' title="View details">
					<div style="background-color:#efefef; padding:5px; margin-top:5px;">
						<?php echo $row['Comment']['name'];?>
					</div>
				</a>			
									
			</td>
			<td style="text-align:center; width:75px; vertical-align:top;">							
				<a href="<?php echo $this->Html->url($row['Activity']['url']);?>" target="_blank">						
					<?php $this->Img->showImage('img/images/'.$imageID, array('height'=>'75','width'=>'75','type'=>'crop'));?>
				</a>		
				<?php echo $text;?>	
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