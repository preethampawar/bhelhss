<?php
App::uses('Blog', 'Model');
$this->Blog = new Blog;
$categoryID = Configure::read('CategoryBlogID');
$conditions = array('Blog.active'=>'1', 'Blog.category_id'=>$categoryID);
$blogs = $this->Blog->find('all', array('conditions'=>$conditions, 'recursive'=>'0', 'limit'=>'11', 'order'=>'Blog.created DESC'));
?>

<h2>From the Blog</h2>

<a href="<?php echo $this->Html->url('/blog/posts_show_all/');?>" style="border:0px;" title="BHEL HSS Blog">
	<?php echo $this->Html->image('blog-banner_small.jpg', array('alt'=>'BHEL HSS Blog', 'style'=>'width:100%;'));?> 
</a>
<br><br>
<div id="blog">
  <ul style="margin:0; padding:0;">
	<?php		
	$categoryName = 'Blog';	
	if(!empty($blogs)) {
		$k = 0;
		foreach($blogs as $row) {
			$k++;
			if($k <= 10) {	
				$blogID = $row['Blog']['id'];
				$blogTitle = $row['Blog']['title'];
				$blogTitleSlug = Inflector::slug($blogTitle, '-');		
				$blogDesc = $row['Blog']['description'];				
				
				// $blogDesc = Sanitize::stripTags($row['Blog']['description'], 'p', 'div', 'span', 'br', 'a', 'table', 'tr', 'td', 'colgroup', 'tbody', 'thead', 'tfooter', 'col');		
				
				$blogDesc = Sanitize::html($blogDesc, array('remove'=>true));		
				$blogDesc = html_entity_decode($blogDesc);
				$blogDesc = $this->Text->truncate($blogDesc, 600);
				// $blogDesc = $this->Text->autoLinkUrls($blogDesc);
				$blogTime = date('l, dS F Y', strtotime($row['Blog']['created']));		
				$userID = $row['User']['id'];	
				$userName = $row['User']['name'];	
				?>
				<li class="clear" style="border-bottom:0px;">		
						
					<div style="text-align:justify; margin-top:5px;">
						<div style="margin-top:5px; background-color:#f3f3f3; padding:2px">
						<?php echo $this->Html->link($blogTitle, '/blog/posts_show/'.$blogID.'/'.$blogTitleSlug, array('title'=>$blogTitle, 'escape'=>false, 'style'=>'background-color:#f3f3f3'));?>
						</div>
						<div style="font-size:12px; padding:2px 2px;">					
							<span style="float:left; color:orange;"><?php echo $blogTime;?></span>
							<span style="float:right; color:#888;">By, <?php echo $userName;?></span>
							<div style="clear:both;"></div>
						</div>		
						<div style="margin-top:5px;">
							<?php echo $blogDesc;?>
							
							<div style="text-align:right;"><?php echo $this->Html->link('Read more...', '/blog/posts_show/'.$blogID.'/'.$blogTitleSlug, array('title'=>$blogTitle, 'escape'=>false));?></div>
							
						</div>
					</div>
				</li>
				<?php
			}
			else {
			?>
				<p>
				<?php
				echo $this->Html->link('Show all blog posts', '/blog/posts_show_all/', array('title'=>'Show all blog posts', 'escape'=>false));
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