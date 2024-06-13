<?php 
if($this->Session->read('User.moderator') or $this->Session->read('User.admin')) {
	echo $this->Html->link('Members List', '/users/membersList');
	echo '<br><br>';
}
?>

<h2>Students Directory</h2>
<div>
	<?php
		$defaultBatch = $this->Session->read('User.batch');
		$yearOptions = array();
		for($i=2004; $i>=1963; $i--) {
			$yearOptions[$i] = $i;
		}
	?>
	<?php
	echo $this->Form->create();		
	?>
	<strong>Batch </strong><span style="font-style:italic; font-size:90%;">(10th class)</span>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<?php
	echo $this->Form->input('User.batch', array('label'=>false, 'div'=>false, 'options'=>$yearOptions, 'type'=>'select', 'style'=>'width:100px; padding:4px 5px;', 'default'=>$defaultBatch));
	?>	
	&nbsp;&nbsp;&nbsp;&nbsp;
	
	<?php
	echo $this->Form->submit('Search &nbsp;&raquo;', array('class'=>'button small grey', 'div'=>false, 'escape'=>false));		
	?>
	<br><br>
	<?php
	if(isset($users)) {
		?><strong>Batch: <?php echo $batch;?></strong><?php
		if(!empty($users)) {
			
	?>
		<table class="table">
			<thead>
				<tr>
					<th style="width:50px;">Sl.No.</th>
					<th>Name</th>
					<th style="width:250px;">Email Address</th>
					<th style="width:100px;">Passout</th>
					<th style="width:150px;"></th>
				</tr>
			</thead>
			<tbody>
			<?php
			$i=0;	
			foreach($users as $row) {
				$i++;
				$userID = $row['User']['id'];
			?>
				<tr>
					<td align='center'><?php echo $i;?>.</td>
					<td><?php echo $row['User']['name'];?></td>
					<td align='center'>
							<span style="font-size:12px;"><?php echo ($row['PrivacySetting']['show_email']) ? $row['User']['email'] : '-';?></span>
						</td>
					<td align='center'>
						<?php echo $row['User']['passout_year'];?>, 
						<?php echo  Configure::read('ClassOptions.'.$row['User']['class']);?>&nbsp;-&nbsp;<?php echo  Configure::read('ClassSections.'.$row['User']['section']);?> 
					</td>
					<td align='center'>
						<?php echo $this->Html->link('Send Message', array('controller'=>'users', 'action'=>'sendMessage', $userID));?>
						&nbsp;|&nbsp;
						<?php echo $this->Html->link('Details', array('controller'=>'users', 'action'=>'info', $userID));?>
					</td>
				</tr>
			<?php
			}
			?>				
			</tbody>
		</table>
		
	<?php
		}
		else {
			echo '<br><br>- Students Not Found';
		}
	}
	?>
	
</div>