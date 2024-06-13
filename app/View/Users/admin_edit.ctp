<?php echo $this->element('message');?>
<div>
	<h2>Edit User - <?php echo $this->data['User']['name'];?></h2>
	<div style="width:400px">
	<?php 
		echo $this->Form->create();
		echo $this->Form->input('User.name', array('label'=>'Name<br>', 'required'=>true, 'div'=>array('class'=>'required'), 'style'=>'width:90%; margin-bottom:10px;'));
		echo $this->Form->input('User.email', array('label'=>'Email Address<br>', 'required'=>true, 'style'=>'width:90%; margin-bottom:10px;'));		
		echo $this->Form->input('User.phone', array('label'=>'Phone No.<br>', 'required'=>false, 'style'=>'width:90%; margin-bottom:10px;'));
		
		
		$options=array('male'=>'Male','female'=>'Female');
		$attributes=array('legend'=>false,'label'=>false, 'div'=>false, 'separator'=>'&nbsp;&nbsp;&nbsp;', 'escape'=>false, 'style'=>'float:none;');
		echo '<div class="input text"><label>Gender</label><br>';							
		echo $this->Form->radio('User.gender',$options,$attributes);
		echo '</div><br>';
		
		echo $this->Form->input('User.active', array('label'=>'Active', 'required'=>false, 'default'=>'1'));
		echo $this->Form->input('User.registered', array('label'=>'Registered', 'required'=>false, 'default'=>'1'));
		echo '<br>';
		echo $this->Form->submit('Update Account', array('class'=>array('button small green')));
		echo $this->Form->end();								
		echo '<br><br>';
	?>
	</div>
</div>