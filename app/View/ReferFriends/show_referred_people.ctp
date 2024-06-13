<div>
	<h2>Referred People List</h2>
	<?php
	if($referredPeople) {
		?>
		<table class="table">
			<thead>
				<tr>
					<th>Sl.no</th>
					<th>Name</th>
					<th>Email address</th>
					<th>Phone no.</th>
					<th>Referred by - Name</th>
					<th>Referred by - Email</th>
					<th>Added on</th>
				</tr>
			</thead>
			<tbody>
			<?php	
			$i=0;	
			foreach($referredPeople as $row) {
				$i++;
			?>
				<tr>
					<td><?php echo $i;?></td>
					<td><b><?php echo $row['ReferFriend']['name'];?></b></td>
					<td><b><?php echo $row['ReferFriend']['email'];?></b></td>
					<td><b><?php echo $row['ReferFriend']['phone'];?></b></td>
					<td><?php echo $row['ReferFriend']['referred_by_name'];?></td>
					<td><?php echo $row['ReferFriend']['referred_by_email'];?></td>
					<td><?php echo date('d-m-Y', strtotime($row['ReferFriend']['created']));?></td>
				</tr>
			<?php
			}
			?>
			</tbody>
		</table>
		
		<?php
	}
	else {
		echo 'No records found.';
	}
	?>	
</div>