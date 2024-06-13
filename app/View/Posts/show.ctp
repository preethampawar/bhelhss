<div>
<?php 
if($this->Session->read('User.moderator') or $this->Session->read('User.admin')) {
	echo ($postInfo['Post']['active']) ? '<span class="small button green">Active</span>' : '<span class="small button red">InActive</span>';
	echo '&nbsp;&nbsp;|&nbsp;&nbsp;';
	echo $this->Html->link('Edit Post', '/posts/edit/'.$postInfo['Post']['id'].'/'.$categoryInfo['Category']['id'], array('class'=>'small button grey'));
	echo '&nbsp;&nbsp;|&nbsp;&nbsp;';
	echo $this->Html->link('Manage Images', '/images/managePostImages/'.$postInfo['Post']['id'].'/'.$categoryInfo['Category']['id'], array('title'=>'Mange Post Images: '.$postInfo['Post']['title'], 'class'=>'small button grey'));
	echo '&nbsp;&nbsp;|&nbsp;&nbsp;';
	echo $this->Html->link('Delete Post', '/posts/deleteUserPost/'.$postInfo['Post']['id'].'/'.$categoryInfo['Category']['id'], array('class'=>'small button grey'), 'Are you sure you want to delete this post?');
	echo '<br><br>';
}
?>
</div>

<?php 
echo $this->Html->css('jquery.lightbox-0.5'); // jQuery Light box
echo $this->Html->script('jquery.lightbox-0.5'); // jQuery Light box	
?>

<?php //debug($postInfo);?>
<?php
	$categoryID = $categoryInfo['Category']['id'];
	$categoryName = $categoryInfo['Category']['name'];
	$categoryNameSlug = Inflector::slug($categoryName, '-');

	$postID = $postInfo['Post']['id'];
	$postTitle = $postInfo['Post']['title'];
	$postTitleSlug = Inflector::slug($postTitle, '-');
	$postDesc = $postInfo['Post']['description'];	
	$postViews = $postInfo['Post']['views'];	
	
?>
	
<span class="floatRight button orange small" title="Page views: <?php echo $postViews;?>">Page Views: <?php echo $postViews;?></span>
<div class='clear'>
	<?php echo $this->Html->link($categoryName, '/posts/showAll/'.$categoryID.'/'.$categoryNameSlug);?> &nbsp;&raquo;&nbsp; <?php echo $this->Html->link($postTitle, '/posts/show/'.$categoryID.'/'.$postID.'/'.$categoryNameSlug.'/'.$postTitleSlug);?>
	
	
	<br><br>
	
	<h2><?php echo $postTitle;?></h2>		
	<div style="float:left; width:500px;">			
		<?php
		$postImages = $postInfo['Image'];
		if(!empty($postImages)) {
		?>
		<script type="text/javascript">
			$(function() {
				$('#postImages a').lightBox();
			});
			</script>
		<div id="postImages">	
			<?php 
			foreach($postImages as $row) { 
				$imageID = $row['id'];
				$imageCaption = ($row['caption']) ? $row['caption'] : $postTitle;
				
				$imageUrl = $this->Img->showImage('img/images/'.$imageID, array('height'=>'600','width'=>'600','type'=>'original'), array('style'=>'', 'alt'=>$postTitle, 'title'=>$imageCaption), true);
			?>
			<div style="float:left; border:0px solid #fff; width:auto; padding:2px;">
				<a href="<?php echo $imageUrl;?>" title='<?php echo $imageCaption;?>'>
					<?php 
					echo $this->Img->showImage('img/images/'.$imageID, array('height'=>'150','width'=>'150','type'=>'crop'), array('style'=>'', 'alt'=>$postTitle, 'title'=>$imageCaption));
					?>			
				</a>
			</div>	
			<?php } ?>
			<div class='clear'></div>	
			<br>
		</div	>
		<?php
		}
		?>
		<div  style="text-align:justify;"><?php echo $postDesc;?></div>
	</div>
	
	<div style="float:left; width:380px; margin-left:30px;">
		<div id="fb-root"></div>
		<script>
		$(document).ready(function() {(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		});
		</script>
		<div class="fb-like" data-send="true" data-width="350" data-show-faces="true"></div>
		<div class="clear"></div>
		<br>		
		<?php 
		$uri = $this->request->here();
		$domain = $this->request->domain();
		$url = 'http://'.$domain.$uri;
		
$facebookMetaTags = <<<TAGS
<meta property="og:title" content="$postTitle" />
<meta property="og:type" content="blog" />
<meta property="og:url" content="$url" />
<meta property="og:image" content="" />
<meta property="og:site_name" content="http://$domain" />		
TAGS;
		$this->set('facebookMetaTags', $facebookMetaTags);
		?>
		<div class="fb-comments" data-href="<?php echo $url;?>" data-num-posts="10" data-width="350"></div>	
	</div>
	<div class="clear"></div>
	
</div> 