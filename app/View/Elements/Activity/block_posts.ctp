<h2>Block Posts Requests</h2>
<?php
if(!empty($blockPostRequests)) {
?>
<table class="" width="100%">		
	<tbody>
	<?php
	$i=0;		
	foreach($blockPostRequests as $row) {
		$i++;
		$activityTime = $this->Time->timeAgoInWords($row['Activity']['created'], array('format'=>'F jS, Y', 'end'=>'+1 days'));	
		$count = 0;
		if(!empty($row['Post']['block_user_ids'])) {
			$users = explode(',', $row['Post']['block_user_ids']);
			$count = count($users);
		}		
		$reqVotesCount = Configure::read('PostBlockVotes');	
		$reqVotesToBlock = $reqVotesCount - $count;
		?>
		<tr>		
			<td style="vertical-align:top;">
				<span style="font-style:italic; font-size:90%; color:orange;"><?php echo $activityTime;?></span> <br>
				<a href="<?php echo $this->Html->url('/users/info/'.$row['User']['id']);?>" target="_blank"><?php echo $row['User']['name'];?></a>
				&nbsp; has requested to block a post titled "<?php echo $this->Html->link($row['Post']['title'], $row['Activity']['url'], array('target'=>'_blank'));?>" in "<?php echo $row['Category']['name'];?>" section. <br>
				<div style="margin-top:5px;">					
					<div style="font-style:italic; font-size:11px;">
						<span style="color:red;">Block Votes: <?php echo $count;?></span><br>
						<?php echo $reqVotesToBlock;?> Vote(s) needed to block this post.					
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