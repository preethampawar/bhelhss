<div>
	<?php echo $this->Html->link('Block Photo Requests', '/admin/activity/blockRequests/photos');?>
	&nbsp;&nbsp;|&nbsp;&nbsp;
	<?php echo $this->Html->link('Block Comment Requests', '/admin/activity/blockRequests/comments');?>
</div>
<br>
<?php if($type == 'photos') { ?>
	<h2>Block Photo Requests</h2>
	<?php
	if(!empty($blockPhotoRequests)) {
	?>
	<table class="table" width="100%">
		<thead>
			<tr>
				<th style="width:50px;">Sl.No.</th>
				<th style="width:100px;">Image</th>
				<th>Description</th>
				<th style="width:120px;">Block Requests</th>
				<th style="width:100px;">Date</th>
				<th style="width:100px;">Action</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$i=0;		
		foreach($blockPhotoRequests as $row) {
			$i++;
		?>
			<tr>
				<td style="text-align:center;"><?php echo $i;?></td>
				<td style="text-align:center;">
					<?php
						$imageID = $row['Activity']['image_id'];						
					?>				
					<a href="<?php echo $this->Html->url($row['Activity']['url']);?>" target="_blank">
						<?php $this->Img->showImage('img/images/'.$imageID, array('height'=>'75','width'=>'75','type'=>'crop'));?>
					</a>
					
				</td>
				<td>
					<?php echo $row['Activity']['title'];?>
					<br><br>
					By, 
					<a href="<?php echo $this->Html->url('/users/info/'.$row['User']['id']);?>" target="_blank">
						<?php echo $row['User']['name'];?>
					</a>
				</td>
				<td style="text-align:center;">
					<?php
					if(!empty($row['Image']) and !empty($row['Image']['block_user_ids'])) {
						$users = explode(',', $row['Image']['block_user_ids']);
						$count = count($users);
						echo $count;
					}					
					?>
				</td>
				<td style="text-align:center;"><?php echo date('d-m-Y', strtotime($row['Activity']['created']));?></td>	
				<td style="text-align:center;">
					<a href="<?php echo $this->Html->url($row['Activity']['url']);?>" target="_blank">
						Details
					</a>
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
		echo 'No Requests';
	}
	?>
<?php } ?>

<?php if($type == 'comments') { ?>
	<h2>Block Comment Requests</h2>
	<?php
	if(!empty($blockCommentRequests)) {
	?>
	<table class="table" width="100%">
		<thead>
			<tr>
				<th style="width:50px;">Sl.No.</th>			
				<th>Description</th>
				<th style="width:120px;">Block Requests</th>
				<th style="width:100px;">Date</th>
				<th style="width:100px;">Action</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$i=0;		
		foreach($blockCommentRequests as $row) {
			$i++;
		?>
			<tr>
				<td style="text-align:center;"><?php echo $i;?></td>				
				<td>
					<?php echo $row['Comment']['name'];?>
					<br><br>
					By, 
					<a href="<?php echo $this->Html->url('/users/info/'.$row['User']['id']);?>" target="_blank">
						<?php echo $row['User']['name'];?>
					</a>
				</td>
				<td style="text-align:center;">
					<?php
					if(!empty($row['Comment']) and !empty($row['Comment']['block_user_ids'])) {
						$users = explode(',', $row['Comment']['block_user_ids']);
						$count = count($users);
						echo $count;
					}
					?>
				</td>
				<td style="text-align:center;"><?php echo date('d-m-Y', strtotime($row['Activity']['created']));?></td>	
				<td style="text-align:center;">
					<a href="<?php echo $this->Html->url($row['Activity']['url']);?>" target="_blank">
						Details
					</a>
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
		echo 'No Requests';
	}
	?>
<?php } ?>



