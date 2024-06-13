<h2>New Posts</h2>
<?php
if(!empty($newPostRequests)) {
?>
<table width="100%">		
	<tbody>
	<?php
	foreach($newPostRequests as $row) {
		$activityTime = $this->Time->timeAgoInWords($row['Activity']['created'], array('format'=>'F jS, Y', 'end'=>'+1 days'));	
	?>
		<tr>			
			<td style="vertical-align:top;">
				<span style="font-style:italic; font-size:90%; color:orange;"><?php echo $activityTime;?></span> <br>
				
				<div style="margin-top:5px;">
					<a href="<?php echo $this->Html->url('/users/info/'.$row['User']['id']);?>" target="_blank"><?php echo $row['User']['name'];?></a>
					has added a new post titled 
					"<?php echo $this->Html->link($row['Post']['title'], $row['Activity']['url'], array('target'=>'_blank'));?>" in "<?php echo $row['Category']['name'];?>" section.
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
	echo 'No recent activity';
}
?>