<?php echo $this->element('message');?>
<div id="manageImages">
	<section>		
		<p>
			<?php 
			if(!empty($categoryID)) {
				echo $this->Html->link('&laquo; Back', '/posts/show/'.$categoryID.'/'.$postInfo['Post']['id'].'/'.Inflector::slug(ucwords($postInfo['Category']['name']), '-').'/'.Inflector::slug(ucwords($postInfo['Post']['title']), '-'), array('escape'=>false));
			}
			else {
				echo $this->Html->link('&laquo; Back', '/', array('escape'=>false));
			}
			?>	
		</p>
		<br>
		<header>
			<h2>Manage Images: <?php echo $postInfo['Post']['title'];?></h2>
		</header>
		<div style="width:600px;">
		<?php 
		echo $this->Form->create(null, array('type'=>'file'));
		echo $this->Form->input('Image.file', array('type'=>'file', 'label'=>'Select Image'));
		echo '<br>';
		
		echo $this->Form->input('Image.caption', array('label'=>'Caption<br>', 'type'=>'textarea', 'rows'=>'2', 'style'=>'width:500px;'));
		echo '<br>';
		echo $this->Form->submit('Upload &nbsp;&raquo;', array('escape'=>false));
		echo $this->Form->end();
		?>
		</div>	
	</section>
	<br><hr><br>
	<section>
		<header><h2><?php echo $postInfo['Post']['title'];?>: Image List</h2></header>
		<div>			
			<?php 
			if(!empty($postImages)) {
				?>
				<table class='table'>
					<thead>
						<tr>
							<th style='width:30px;'>Sl.No.</th>
							<th style='width:150px;'>Image</th>
							<th>Caption</th>
							<th style='width:130px;'>Actions</th>
						</tr>
					</thead>
					<tbody>
				<?php
				$i=0;
				foreach($postImages as $row) {
					$i++;
					$imageID = $row['Image']['id'];
					$imageCaption = $row['Image']['caption'];					
					$postID = $row['Post']['id'];
					$postTitle = $row['Post']['title'];
					?>
					<tr>
						<td><?php echo $i;?>.</td>
						<td>
							<?php echo $this->Img->showImage('img/images/'.$imageID, array('height'=>'150','width'=>'150','type'=>'crop'), array('style'=>'', 'alt'=>''));?>
						</td>
						<td style="vertical-align:top; padding-left:20px;">
							<p><strong>Caption:</strong></p>
							<p><?php echo $imageCaption;?></p>
						</td>
						<td style="text-align:center;">
							<?php							
							echo $this->Html->link('Delete', '/images/deletePostImage/'.$imageID, array(), 'Are you sure you want to delete this image?');							
							?>
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
				echo 'No Images Found';
			}
			
			?> 
		</div>
	</section>
</div>