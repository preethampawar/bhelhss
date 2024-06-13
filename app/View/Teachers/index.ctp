<?php 
echo $this->Html->link(" + Add Teacher's Contact Info", '/teachers/addInfo');
echo '<br><br>';
?>

<h2>Teacher's Contact Info</h2>
<?php
if(!empty($teachersInfo)) {
?>
	<table class="table" style="font-size:11px;">
		<thead>
			<tr>
				<th style="width:30px;">No.</th>
				<th>Name</th>
				<th style="width:130px;">Phone</th>
				<th style="width:180px;">Extra Info</th>
				<th style="width:150px;">Info Provided by</th>
				<th style="width:70px;">Date</th>
				<th style="width:120px;"></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			foreach($teachersInfo as $row) {
				$i++;
			?>
			<tr>
				<td style="text-align:center;"><?php echo $i;?>.</td>
				<td><?php echo $row['Teacher']['name'];?></td>
				<td style="text-align:center;"><?php echo $row['Teacher']['phone'];?></td>
				<td><?php echo $row['Teacher']['extra_info'];?></td>
				<td><?php echo $this->Html->link($row['User']['name'], '/users/info/'.$row['User']['id'], array('target'=>'_blank'));?></td>
				<td style="text-align:center;"><?php echo date('d-m-Y', strtotime($row['Teacher']['created']));?></td>
				<td style="text-align:center;">
					<?php echo $this->Html->link('Edit', '/teachers/editInfo/'.$row['Teacher']['id'], array('class'=>'button small grey'));?>
					&nbsp|&nbsp;
					<?php echo $this->Html->link('Delete', '/teachers/delete/'.$row['Teacher']['id'], array('class'=>'button small grey'), 'Are you sure you want to delete this contact?');?>
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>
		
	</table>
<?php
}
?>