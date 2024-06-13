<?php 
if($this->Session->read('User.moderator') or $this->Session->read('User.admin')) {
	echo $this->Html->link('+ Add New Post', '/posts/add/'.$categoryInfo['Category']['id'], array('class'=>'small button grey'));
	echo '<br><br>';
}
?>

<div>
  <h2><?php echo $categoryInfo['Category']['name'];?></h2>
  <ul style="margin:0; padding:0;">
	<?php	
	$categoryID = $categoryInfo['Category']['id'];
	$categoryName = $categoryInfo['Category']['name'];
	$categoryNameSlug = Inflector::slug($categoryName, '-');
	?>
	
	<?php
	if($categoryID == 5) {
		echo $this->Html->image('news_and_events.jpg', array('alt'=>'latest news and events', 'style'=>'width:100%; margin-bottom:5px;'));		
	?>
		<li class="clear" style="border-bottom:1px dotted #aaa;">&nbsp;</li>
	<?php	
	}
	?>
	
	<?php
	if(!empty($posts)) {	
		foreach($posts as $row) {		
			 	
			$postID = $row['Post']['id'];
			$postTitle = $row['Post']['title'];
			$postTitleSlug = Inflector::slug($postTitle, '-');
			$postDesc = $row['Post']['description'];

			$postDesc = Sanitize::html($row['Post']['description'], array('remove'=>true));
			$postDesc = html_entity_decode($postDesc);				
			$postDesc = $this->Text->truncate($postDesc, 400);
			
			$postTime = date('dS M Y', strtotime($row['Post']['created']));
						
			$postDesc.='<p style="text-align:right;">'.$this->Html->link('Details...', '/posts/show/'.$categoryID.'/'.$postID.'/'.$postTitleSlug, array('title'=>$postTitle, 'escape'=>false)).'</p>';
			
			$imageID = (isset($row['Image']['0']['id']) and !empty($row['Image']['0']['id'])) ? $row['Image']['0']['id'] : null;						
						
			?>
			<li class="clear" style="border-bottom:1px dotted #aaa;">
				<div class="floatLeft" style="width:250px;">
					<?php echo $this->Html->link($postTitle, '/posts/show/'.$categoryID.'/'.$postID.'/'.$categoryNameSlug.'/'.$postTitleSlug, array('title'=>$postTitle, 'escape'=>false));?>
					<br>
					<div style="font-style:normal; font-size:90%; color:orange;">- <time><?php echo $postTime;?></time></div>
				</div>
				
				<div class="floatLeft" style="margin-left:20px; width:620px; text-align:justify;">	
					<div class="" style="text-align:justify;">
						<?php 
						if($this->Session->read('User.moderator') or $this->Session->read('User.admin')) {
							echo '<p>';
							echo ($row['Post']['active']) ? '<span class="small button green">Active</span>' : '<span class="small button red">InActive</span>';
							// echo '&nbsp;&nbsp;|&nbsp;&nbsp;';
							// echo $this->Html->link('Edit Post', '/posts/edit/'.$postID.'/'.$categoryID, array('class'=>'small button grey'));
							// echo '&nbsp;&nbsp;|&nbsp;&nbsp;';
							// echo $this->Html->link('Delete Post', '/posts/deleteUserPost/'.$postID.'/'.$categoryID, array('class'=>'small button grey'), 'Are you sure you want to delete this post?');
							// echo '&nbsp;&nbsp;|&nbsp;&nbsp;';
							// echo $this->Html->link('Manage Images', '/images/managePostImages/'.$postID.'/'.$categoryID, array('title'=>'Mange Post Images: '.$postTitle, 'class'=>'small button grey'));
							echo '</p>';
						}
						?>
					</div>
					<?php
					if($imageID) {
					?>
						<div class="imgl">					
						<?php echo $this->Img->showImage('img/images/'.$imageID, array('height'=>'150','width'=>'150','type'=>'crop'), array('style'=>'border:1px solid #ccc;', 'alt'=>'', 'width'=>'125', 'height'=>'125'));?>
						</div>					
					<?php
					}	
					?>			  
					<?php echo $postDesc;?>
				</div>
				<div style="clear:both;"></div>
				
			
				
			</li>
			<?php
		}		
	}
	else {
		?>
		<li class="clear">
			<p>No news or events as of now.</p>
		</li>
		<?php
	}
	?>	
  </ul>
</div>
<br><br>