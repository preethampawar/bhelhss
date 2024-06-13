<?php
$blogID = $blogInfo['Blog']['id'];					
$blogTitle = $blogInfo['Blog']['title'];
$blogViews = $blogInfo['Blog']['views'];
$blogTitleSlug = Inflector::slug($blogTitle, '-');
$blogDesc = $blogInfo['Blog']['description'];
// $blogDesc = $this->Text->autoLinkUrls($blogDesc);
// $blogTime = $this->Time->timeAgoInWords($blogInfo['Blog']['created'], array('format'=>'F jS, Y', 'end'=>'+1 days'));
$blogTime = date('l, dS M Y', strtotime($blogInfo['Blog']['created']));

$userID = $blogInfo['User']['id'];
$userName = $blogInfo['User']['name'];

$userPost = false;
if($this->Session->read('User.id') == $userID) {
	$userPost = true;	
}
else {
	if($this->Session->read('User.admin') or $this->Session->read('User.moderator')) {
		$userPost = true;
	}
}

// Block post votes
$blockUserIDs = $blogInfo['Blog']['block_user_ids'];
$currentUserID = $this->Session->read('User.id');

$allowBlockVoting = true;
if($currentUserID == $blogInfo['Blog']['user_id']) {
	$allowBlockVoting = false;
}
elseif(!empty($blockUserIDs)) {
	$userIDsArray = explode(',',$blockUserIDs);			
	if(in_array($currentUserID, $userIDsArray)) {
		$allowBlockVoting = false;
	}
}

// get block count
$blockCount = 0;
if(!empty($blockUserIDs)) {
	$userIDsArray = explode(',',$blockUserIDs);			
	$blockCount = count($userIDsArray);
}

// max block count
$maxBlockCount = Configure::read('PostBlockVotes');

// required block votes
$requiredVotes = $maxBlockCount-$blockCount; 
?>

<?php
$metaDescription = Sanitize::stripTags($blogDesc, 'p', 'div', 'span', 'br', 'a', 'table', 'tr', 'td', 'colgroup', 'tbody', 'thead', 'tfooter', 'col', 'strong');
$this->set('title_for_layout', $blogTitle);
$this->Html->meta('keywords', $blogTitle, array('inline'=>false));
$this->Html->meta('description', $this->Text->truncate($metaDescription, 150), array('inline'=>false));
?>

<div style="text-align:justify;text-justify:inter-word;">
	<?php if($this->Session->check('User')) { ?>
	<div style="font-size:11px;">
		<?php echo $this->Html->image('block_icon.png', array('height'=>'15', 'class'=>'floatLeft', 'style'=>'margin-top:3px;'));?> 
		(<?php echo $blockCount;?>).
		<span style="font-style:italic;">
		<?php 
		if($allowBlockVoting) {
			echo $this->Html->link('Block', '/blog/block_post/'.$blogID, array('title'=>'Need '.$requiredVotes.' vote(s) to block this post.'));
		}
		else {
			echo '&nbsp;Need '.$requiredVotes.' vote(s) to block this post';
		}
		?>
		</span>
	</div>
	<br>
	<?php } ?>
	
	<div style="float:right" class="small button orange">Page views: <?php echo $blogViews;?></div>
	<?php
	if($userPost) {
	?>
	<div style="float:right">&nbsp;&nbsp;|&nbsp;&nbsp;</div>
	<div style="float:right"><?php echo $this->Html->link('Delete', '/blog/posts_delete/'.$blogID, array('class'=>'small button grey'), 'Are you sure you want to delete this post?');?></div>
	<div style="float:right">&nbsp;&nbsp;|&nbsp;&nbsp;</div>
	<div style="float:right"><?php echo $this->Html->link('Edit', '/blog/posts_edit/'.$blogID, array('class'=>'small button grey'));?></div>
	<?php
	}
	?>
	
	<h2><?php echo $this->Html->link($blogTitle, '/blog/posts_show/'.$blogID.'/'.$blogTitleSlug, array('title'=>$blogTitle));?></h2>
	<div style="float:left; width:500px;">		
		<span style="font-style:normal; font-size:100%; color:orange;"><?php echo $blogTime;?></span><br>
		<strong>By, <?php echo ($this->Session->check('User')) ? $this->Html->link($userName, '/users/info/'.$userID, array('title'=>'Click to see user information', 'target'=>'_blank')) : $userName;?></strong>
		
		<br>
		<?php echo $blogDesc;?>
		
	</div>
	<div style="float:left; width:380px; margin-left:30px;">
		<div id="fb-root"></div>
		<script>
		$(document).ready(function() {
			(function(d, s, id) {
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
		$image = $this->Html->url('/img/bhel_hss_logo.jpg', true);
		
$facebookMetaTags = <<<TAGS
<meta property="og:title" content="$blogTitle" />
<meta property="og:type" content="school" />
<meta property="og:url" content="$url" />
<meta property="og:image" content="" />
<meta property="og:image" content="$image" />
<meta property="og:site_name" content="http://$domain" />		
TAGS;
		$this->set('facebookMetaTags', $facebookMetaTags);
		?>
		<div class="fb-comments" data-href="<?php echo $url;?>" data-num-posts="10" data-width="350"></div>				
	</div>
	<div class="clear"></div>
</div>

