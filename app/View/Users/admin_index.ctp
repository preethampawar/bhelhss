<?php echo $this->element('message');?>
<h1>Users List</h1>
<?php
if(!empty($users)) {
?>
	Total: <?php echo $totalUsers;?><br>
	Active: <?php echo $activeUsers;?><br> Not Confirmed: <?php echo $notRegisteredUsers;?><br> Inactive/Blocked: <?php echo $inactiveUsers;?>
	<table cellspacing='1' cellpadding='1' class="table"  style="font-size:11px; margin-top:10px;">
		<thead>
			<tr>
				<th width='20'>No.</th>
				<th width='200'>Name</th>
				<th width='40'>Batch<br>(10th)</th>
				<th width='120'>Phone</th>
				<th width='200'>Email Address</th>
				<th width='50'>Status</th>				
				<th width='80'>Account<br>Confirmed?</th>				
				<th width='50'>Registered<br>Date</th>
				<th width='50'>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=0;
			foreach($users as $row) {
				$i++;				
			?>
			<tr>
				<td><?php echo $i;?></td>
				<td>
					<a href="<?php echo $this->Html->url('/users/info/'.$row['User']['id']);?>" target="_blank">
						<?php echo $row['User']['name'];?>
					</a>
				</td>
				<td style="text-align:center;" ><?php echo $row['User']['batch'];?></td>
				<td><?php echo $row['User']['phone'];?></td>
				<td><?php echo $row['User']['email'];?></td>
				<td style="text-align:center; font-size:90%"><?php echo ($row['User']['active']) ? '<span style="color:green;">Active</span>' : '<span style="color:red;">InActive</span>';?></td>								
				<td style="text-align:center; font-size:90%"><?php echo ($row['User']['registered']) ? '<span style="color:green;">Yes</span>' : '<span style="color:red;">No</span>';?></td>								
				<td style="text-align:center;"><?php echo date('d-m-Y', strtotime($row['User']['created']));?></td>						
				<td style="text-align:center;">
					<?php
					echo $this->Html->link('Edit', array('controller'=>'users', 'action'=>'edit/'.$row['User']['id']), array('class'=>'button small grey', 'title'=>$row['User']['name'], 'style'=>'font-size:10px;'));
					// echo '&nbsp;&nbsp;&nbsp;&nbsp;';
					// echo $this->Html->link('Delete', array('controller'=>'users', 'action'=>'delete/'.$row['User']['id']), array('class'=>'button small grey'), 'Deleting a User Account will delete all user registered companies and all the information(Sales, Purchases, Cash records, Inventory, Groups, .. etc.) associated with the User Account. This action is irreversable. Are you sure you want to delete this record. "'.$row['User']['name'].'" ?');
					?>
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
	<br>

<?php	
}
else {
	echo 'No User Records <br> <br>';
}
?>
