<h2>Block Photo Requests</h2>
<?php
if(!empty($blockPhotoRequests)) {
?>
<table class="" width="100%">		
	<tbody>
	<?php
	$i=0;		
	foreach($blockPhotoRequests as $row) {
		$i++;
		$activityTime = $this->Time->timeAgoInWords($row['Activity']['created'], array('format'=>'F jS, Y', 'end'=>'+1 days'));	
		$count = 0;
		if(!empty($row['Image']) and !empty($row['Image']['block_user_ids'])) {
			$users = explode(',', $row['Image']['block_user_ids']);
			$count = count($users);
		}		
		$reqVotesCount = Configure::read('PhotoBlockVotes');	
		$reqVotesToBlock = $reqVotesCount - $count;
		?>
		<tr>				
			<td style="text-align:center; width:75px;">
				<?php
					$imageID = $row['Activity']['image_id'];						
				?>				
				<a href="<?php echo $this->Html->url($row['Activity']['url']);?>" target="_blank">						
					<?php $this->Img->showImage('img/images/'.$imageID, array('height'=>'75','width'=>'75','type'=>'crop'));?>
				</a>
				
			</td>
			<td style="vertical-align:top;">
				<span style="font-style:italic; font-size:90%; color:orange;"><?php echo $activityTime;?></span> <br>
				<a href="<?php echo $this->Html->url('/users/info/'.$row['User']['id']);?>" target="_blank"><?php echo $row['User']['name'];?></a>
				&nbsp; has requested to block this photo. <br>
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