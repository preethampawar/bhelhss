<?php
$categoryPosts = $this->requestAction('/posts/getSharedPhotosPostList');
?>
<h2>Photo Gallery</h2>
<ul>	
	<?php
	if(!empty($categoryPosts)) {
		foreach($categoryPosts as $row) {
			if(!empty($row['Post'])) {
				?>
				<li>
					<?php echo $row['Category']['name'];?>	
					<ul>
						<?php	
						App::uses('Image', 'Model');
						$this->Image = new Image;
						
						
						foreach($row['Post'] as $post) {							
							$conditions = array('Image.post_id'=>$post['id'], 'Image.shared_photo'=>'1');
							$this->Image->recursive = -1;
							$imageCount = $this->Image->find('count', array('conditions'=>$conditions));
							$imageCount = ($imageCount) ? ' ('.$imageCount.')' : '';
						?>
						<li>
							<?php 
							echo $this->Html->link($post['title'], '/images/showPostPhotoUploads/'.$post['id'], array('title'=>'Show '.$post['title'].' photo uploads'));
							echo $imageCount;
							?> 
						</li>
						<?php
						}
						?>
					</ul>
				</li>
				<?php	
			}
		}
	}
	?>
</ul>
<br>
