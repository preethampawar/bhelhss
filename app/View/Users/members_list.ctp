<?php 
echo $this->Html->link('Students Directory', '/users/studentsDirectory');
echo '<br><br>';
?>

<h2>Bhelhss.com Members List</h2>
<div style="width:920px; overflow:auto;">	
		<table class="table">
			<thead>
				<tr>
					<th style="width:30px;">No.</th>
					<th>Name</th>
					<th style="width:70px;">Type</th>
					<th style="width:180px;">Email Address</th>
					<th style="width:120px;">Phone</th>
					<th style="width:180px;">Address</th>
					<th style="width:100px;">Passout</th>
					
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
					<td><?php echo $this->Html->link($row['User']['name'], array('controller'=>'users', 'action'=>'info', $userID));?></td>
					<td align='center'><?php echo $row['User']['type'];?></td>
					<td align='center'><?php echo $row['User']['email'];?></td>
					<td align='center'><?php echo $row['User']['phone'];?></td>
					<td align='center'><?php echo $row['User']['address'].', '.$row['User']['city'].', '.$row['User']['state'].', '.$row['User']['country'];?></td>
					<td align='center'>
						<?php echo $row['User']['passout_year'];?>, 
						<?php echo  Configure::read('ClassOptions.'.$row['User']['class']);?>&nbsp;-&nbsp;<?php echo  Configure::read('ClassSections.'.$row['User']['section']);?> 
					</td>
				</tr>
			<?php
			}
			?>				
			</tbody>
		</table>
		
	
	
</div>