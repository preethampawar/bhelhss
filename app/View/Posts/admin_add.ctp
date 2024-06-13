<?php 	
	echo $this->element('text_editor');
	echo $this->element('message');	
?>

<div id="adminAddContent">		
		<p>
		<?php 
		echo $this->Html->link('&laquo; Back', '/admin/posts/showPosts/'.$categoryInfo['Category']['id'], array('escape'=>false));		
		?>			
		</p>
		<h2><?php echo $categoryInfo['Category']['name'];?> &nbsp;&raquo;&nbsp; Create New Post</h2>		
		
		<?php
		
		if(!empty($categoryInfo)) {								
			
			echo $this->Form->create();
						
			echo $this->Form->input('Post.active', array('label'=>'Is Active', 'title'=>'Status Active', 'style'=>'width:10px; margin-right:5px;', 'after'=>'<br>'));			
			echo $this->Form->input('Post.allow_photo_sharing', array('label'=>'Allow Photo Sharing', 'title'=>'Allow Photo Sharing', 'style'=>'width:10px; margin-right:5px;', 'after'=>'<br>'));
			
			echo '<br><strong>Post Title</strong>';
			echo $this->Form->input('Post.title', array('label'=>false, 'title'=>'Add new product', 'style'=>'width:800px; margin-right:20px;'));
			
			echo '<br><strong>Post Description</strong>';
			echo $this->Form->input('Post.description', array('label'=>false, 'title'=>'Add new product', 'rows'=>'20', 'style'=>'width:800px; margin-right:20px;', 'class'=>'tinymce', 'type'=>'textarea'));
					
			echo '<br>';
			echo $this->Form->submit('Submit &raquo;', array('class'=>'floatLeft', 'escape'=>false));
			echo $this->Form->end();
		?>
		<div class='clear'>&nbsp;</div>
		
		<?php
		}
		else {
		?>
			You need to create a category before you add any product. click <?php echo $this->Html->Link('here', '/admin/categories/add', array('title'=>'Add new category'));?> to create a <?php echo $this->Html->Link('new category', '/admin/categories/add', array('title'=>'Add new category'));?>. 
		<?php
		}
		?>
	
</div>