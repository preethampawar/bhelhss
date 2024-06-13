<h2>Block Comment Requests</h2>
<?php
if(!empty($blockCommentRequests)) {
?>
<table width="100%">		
	<tbody>
	<?php
	foreach($blockCommentRequests as $row) {			
		$activityTime = $this->Time->timeAgoInWords($row['Activity']['created'], array('format'=>'F jS, Y', 'end'=>'+1 days'));	
		
		$count = 0;
		if(!empty($row['Comment']['block_user_ids'])) {
			$users = explode(',', $row['Comment']['block_user_ids']);
			$count = count($users);
		}
		$reqVotesCount = Configure::read('CommentBlockVotes');	
		$reqVotesToBlock = $reqVotesCount - $count;
	?>
		<tr>				
			<td>
				<span style="font-style:italic; font-size:90%; color:orange;"><?php echo $activityTime;?></span> <br>
				
				<div style="margin-top:5px;">
					<a href="<?php echo $this->Html->url('/users/info/'.$row['User']['id']);?>" target="_blank"><?php echo $row['User']['name'];?></a>
					has requested to block the following comment.
				</div>
				
				<a href="<?php echo $this->Html->url($row['Activity']['url']);?>" target="_blank" style='color:#555555;' title="View details">
					<div style="background-color:#efefef; padding:5px; margin-top:5px;">
						<?php echo $row['Comment']['name'];?>
					</div>
				</a>			
				
				<div style="margin-top:10px;">					
					<div style="font-style:italic; font-size:11px;">
						<span style="color:red;">Block Votes: <?php echo $count;?></span>.
						<?php echo $reqVotesToBlock;?> Vote(s) needed to block this photo.					
					</div>
				</div>						
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
	echo 'No Requests';
}
?>