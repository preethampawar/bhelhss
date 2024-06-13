<?php
App::uses('Post', 'Model');
$this->Post = new Post;

$conditions = array('Post.active'=>'1', 'Post.category_id'=>'5');
$posts = $this->Post->find('all', array('conditions'=>$conditions, 'recursive'=>'-1', 'limit'=>'5', 'order'=>'Post.created DESC'));

App::uses('Image', 'Model');
$this->Image = new Image;		
?>
		
<div id="latestnews">	
	<h2>News &amp; Events</h2>
	<a href="<?php echo $this->Html->url('/posts/showAll/5/News-And-Events');?>" style="border:0px;" title="News & events">
		<?php echo $this->Html->image('news_and_events_400.jpg', array('alt'=>'news and events', 'style'=>'width:100%;'));?> 
	</a>
	<br>
	
	<ul>
	<?php	
	$categoryID = '5';
	$categoryName = 'Latest News And Events';
	$categoryNameSlug = Inflector::slug($categoryName, '-');	
	if(!empty($posts)) {
		$k = 0;
		foreach($posts as $row) {
			$k++;
			if($k <= 4) {	
				$postID = $row['Post']['id'];
				$postTitle = $row['Post']['title'];
				$postTitleSlug = Inflector::slug($postTitle, '-');
				$postDesc = $row['Post']['description'];				
				
				
				//$postDesc = Sanitize::stripTags($postDesc, 'p', 'div', 'span', 'br', 'a');
				$postDesc = Sanitize::html($postDesc, array('remove'=>true));	
				$postDesc = html_entity_decode($postDesc);
				$postDesc = $this->Text->truncate($postDesc, 300);
				// $postDesc = $this->Text->autoLinkUrls($postDesc);
				$postDesc.='<p style="text-align:right; margin:0;">'.$this->Html->link('Read more...', '/posts/show/'.$categoryID.'/'.$postID.'/'.$categoryNameSlug.'/'.$postTitleSlug, array('title'=>$postTitle, 'escape'=>false)).'</p>';
				$postTime = date('dS F Y', strtotime($row['Post']['created']));		
				
				$imageID = null;
				$imageConditions = array('Image.post_id'=>$postID, 'shared_photo NOT'=>'1');
				$postImage = $this->Image->find('first', array('conditions'=>$imageConditions, 'order'=>'Image.created desc', 'limit'=>'1'));
				if(!empty($postImage)) {				
					$imageID = $postImage['Image']['id'];						
				}		
				
				?>
				<li class="clear">
					<?php
					if($imageID) {
					?>
						<div class="imgl">					
						<?php echo $this->Img->showImage('img/images/'.$imageID, array('height'=>'150','width'=>'150','type'=>'crop'), array('style'=>'border:1px solid #ccc;', 'alt'=>'', 'width'=>'125', 'height'=>'125'));?>
						</div>					
					<?php
					}	
					?>			  
					<div <?php if($imageID) { ?> class="latestnews" <?php } ?> style="text-align:justify;">
						<div style="margin-top:5px; background-color:#f3f3f3; padding:2px"><?php echo $this->Html->link($postTitle, '/posts/show/'.$categoryID.'/'.$postID.'/'.$categoryNameSlug.'/'.$postTitleSlug, array('title'=>$postTitle, 'escape'=>false, 'style'=>'background-color:#f3f3f3;'));?></div>
						<div style="text-align:left; color:orange;">- <?php echo $postTime;?></div>
						<?php echo $postDesc;?>
					</div>
				</li>
				<?php
			}
			else {
			?>
				<p style="text-align:right">
				<?php
				echo $this->Html->link('&raquo; Show all '.($categoryName), '/posts/showAll/'.$categoryID.'/'.$categoryNameSlug, array('title'=>'Show all latest news and events', 'escape'=>false));
				?>
				</p>	
			<?php
			}
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
