<div class='content'>		
	<?php 
	if($this->Session->read('User')) {
		echo $this->Html->Link('+ Add New Post', '/blog/posts_create', array('class'=>'floatRight small button grey'));
	}
	?>
	<h2>BHEL HSS Blog</h2>
	<?php echo $this->Html->image('blog-banner.jpg', array('alt'=>'BHEL HSS Blog', 'style'=>'width:100%; margin-bottom:5px;')); ;?>

	<div class="clear" style="border-bottom:1px dotted #aaa;">&nbsp;</div>
	
	<div class='clear'></div>
	<div>
	<?php
	if(!empty($blogs)) {
	?>
		
		<?php
		$i=0;
		foreach($blogs as $row) {
			$i++;
			$blogID = $row['Blog']['id'];					
			$blogTitle = $row['Blog']['title'];
			$blogViews = $row['Blog']['views'];
			$blogTitleSlug = Inflector::slug($blogTitle, '-');
			
			$blogDesc = Sanitize::html($row['Blog']['description'], array('remove'=>true));
			$blogDesc = html_entity_decode($blogDesc);
			$blogDesc = $this->Text->truncate($blogDesc, 400);
			//$blogDesc = $this->Text->autoLinkUrls($blogDesc);
			// $blogTime = $this->Time->timeAgoInWords($row['Blog']['created'], array('format'=>'F jS, Y', 'end'=>'+1 days'));
			$blogTime = date('dS M Y', strtotime($row['Blog']['created']));
			
			$userID = $row['User']['id'];
			$userName = $row['User']['name'];
			
			
			// Block post votes
			$blockUserIDs = $row['Blog']['block_user_ids'];
			$currentUserID = $this->Session->read('User.id');			
			// get block count
			$blockCount = 1;
			if(!empty($blockUserIDs)) {
				$userIDsArray = explode(',',$blockUserIDs);			
				$blockCount = count($userIDsArray);
			}
			// max block count
			$maxBlockCount = Configure::read('PostBlockVotes');
			// required block votes
			$requiredVotes = $maxBlockCount-$blockCount; 
			
		?>
		<div>
			<div class="floatLeft" style="width:250px;">
				<div class=" "><?php echo $this->Html->link($blogTitle, '/blog/posts_show/'.$blogID.'/'.$blogTitleSlug, array('title'=>$blogTitle));?></div>	
				<div style="font-style:normal; font-size:90%; color:orange;"><time><?php echo $blogTime;?></time>. Views: <?php echo $blogViews;?></div>
				<?php
				if($blockCount and $this->Session->check('User')) {
				?>
					<div title="<?php echo $blockCount;?> vote(s) added to block this post."><?php echo $this->Html->image('block_icon.png', array('height'=>'15', 'class'=>'', 'style'=>'margin-top:3px;'));?> 
			(<?php echo $blockCount;?>)</div>	
				<?php
				}
				?>
			
					
				By, <?php echo ($this->Session->check('User')) ? $this->Html->link($userName, '/users/info/'.$userID, array('title'=>'Click to see user information', 'target'=>'_blank')) : $userName;?>
				
			</div>
			<div class="floatLeft" style="margin-left:20px; width:620px; text-align:justify;">				
				<?php echo $blogDesc;?><br>			
				<span class="more floatRight" ><?php echo $this->Html->link('Read more...', '/blog/posts_show/'.$blogID.'/'.$blogTitleSlug, array('title'=>$blogTitle));?></span>
			</div>
			<div style="clear:both;"></div>
		</div>					
		<div style="border-bottom:1px dotted #aaa; margin:5px 0 10px 0; "></div>
		<?php
		}
		?>
			
	<?php
	}
	else {
	?>
		No posts found.
	<?php
	}
	?>
	<?php //debug($categoryProducts);?>					
	</div>	
</div>