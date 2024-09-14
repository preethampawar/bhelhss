<div  class='content'>
	<span><?php echo $this->Html->link('&laquo; Back', '/admin/categories/', array('escape'=>false));?></span><br><br>
	<h2>Category: <?php echo $categoryInfo['Category']['name'];?></h2>
	<p><?php echo in_array($categoryInfo['Category']['id'], [8, 5]) ? $this->Html->Link('+ Add New Post', '/admin/posts/add/'.$categoryInfo['Category']['id']) : '';?></p>
	<div class='clear'></div>
	<?php
	if(!empty($posts)) {
	?>
		<table class='table'>
			<thead>
				<tr>
					<th style="width:20px;">Sl.No.</th>
					<th>Post Name</th>
					<th>Created On</th>
					<th style="width:120px;">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=0;
				$categoryID = $categoryInfo['Category']['id'];
				foreach($posts as $row) {
					$i++;
					$postID = $row['Post']['id'];
					$postActive = $row['Post']['active'];
					$postName = $row['Post']['title'];
					$postDate = date('d-m-Y', strtotime($row['Post']['created']));
					$postPhotoSharing = $row['Post']['allow_photo_sharing'];

				?>
				<tr>
					<td><?php echo $i;?></td>
					<td>
						<?php
							if($postActive){
								echo $this->Html->link($this->Html->image('round_button_green.jpg', array('alt'=>'active', 'title'=>'Click to deactivate', 'width'=>'16')), '/admin/posts/setInactive/'.$postID, array('style'=>'color:green;', 'escape'=>false), 'Are you sure you want to deactivate this post? Deactivating will hide this post from public.');
							}
							else {
								echo $this->Html->link($this->Html->image('red_button.png', array('alt'=>'active', 'title'=>'Click to activate', 'height'=>'12', 'width'=>'12')), '/admin/posts/setActive/'.$postID, array('escape'=>false, 'style'=>'color:red; margin:2px;'), 'Are you sure you want to activate this post? Activating will make this post available to public.');
							}
						?>
						&nbsp;
						<?php
						echo $this->Html->link($postName, '/admin/posts/edit/'.$postID.'/'.$categoryID, array('title'=>$postName));
						?>
					</td>
					<td><?php echo $postDate; ?></td>
					<td style="text-align:center;">
						<?php echo $this->Html->link('Edit', '/admin/posts/edit/'.$postID.'/'.$categoryID, array('title'=>'Edit Post: '.$postName));?>
						&nbsp;|&nbsp;
						<?php echo $this->Html->link('Images', '/admin/images/managePostImages/'.$postID.'/'.$categoryID, array('title'=>'Mange Post Images: '.$postName));?>
						<?php // echo $this->Html->link($this->Html->image('error.png', array('alt'=>'active', 'title'=>'Click to remove this post')), '/admin/posts/deletePost/'.$postID.'/'.$categoryID, array('escape'=>false, 'style'=>'color:red;', 'title'=>'Delete Post: '.$postName), 'Are you sure you want to delete this post - '.$postName.'?');?>
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
	<?php //debug($categoryProducts);?>

</div>
