<?php 	
	echo $this->element('text_editor');
	echo $this->element('message');	
?>

<div id="adminAddContent">		
		<p>
		<?php 
		echo $this->Html->link('&laquo; Back', '/blog/posts_show_all', array('escape'=>false));		
		?>			
		</p>
		<h2>Create New Post</h2>		
		
		<?php			
			echo $this->Form->create();						
			
			echo '<strong>Title</strong>';
			echo $this->Form->input('Blog.title', array('label'=>false, 'title'=>'Add new product', 'style'=>'width:500px; margin-right:20px;'));
			
			echo '<br><strong>Description</strong>';
			echo $this->Form->input('Blog.description', array('label'=>false, 'title'=>'Add new product', 'rows'=>'20', 'style'=>'width:800px; margin-right:20px;', 'class'=>'tinymce', 'type'=>'textarea'));
					
			echo '<br>';
			//echo $this->Form->input('Blog.allow_member_comments', array('label'=>'Allow comments from bhelhss.com members', 'title'=>'Only BHEL HSS members can comment on this post.', 'style'=>'width:10px; margin-right:5px;', 'after'=>'<br>'));			
			
			echo $this->Form->input('Blog.allow_facebook_comments', array('label'=>'Allow comments from social network(facebook, yahoo, hotmail, etc) users', 'title'=>'Facebook users can comment on this post.', 'style'=>'width:10px; margin-right:5px;', 'after'=>'<br>'));
			echo '<br>';
			echo $this->Form->submit('Save &amp; Publish &raquo;', array('class'=>'floatLeft', 'escape'=>false));
			echo $this->Form->end();
		?>
		<div class='clear'>&nbsp;</div>
</div>