<?php echo $this->element('message');?>
<p><?php echo $this->Html->link('&laquo; Back', '/admin/categories/', array('escape'=>false));?></p>
<div>	
	<section>
		<h2>Add New Category</h2>
		<?php
		//$sections = Configure::read('ContentSections');
		
		echo $this->Form->create();
		// echo 'Section: ';
		// echo $this->Form->input('Category.section', array('label'=>false, 'title'=>'Section', 'options'=>$sections, 'style'=>'width:300px;'));
		// echo '<br>';
		echo 'Category Name';
		echo $this->Form->input('Category.name', array('label'=>false, 'title'=>'Add new category', 'style'=>'width:300px; float:left; margin-right:20px;'));
		echo $this->Form->submit('+ Add', array('class'=>'floatLeft'));
		echo $this->Form->end();
		?>
		<div class='clear'>&nbsp;</div>
		<br><br>
		<div class='note'>Note*: Only alphanumeric characters are accepted. Special characters will be removed.</div>
	</section>
</div>