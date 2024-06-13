<?php echo $this->element('message');?>
<div>
	<?php 
	if($this->Session->read('User.moderator') or $this->Session->read('User.admin')) {
		echo $this->Html->link('Teachers Contact List', '/teachers/');
		echo '<br><br>';
	}
	?>
	
	<?php echo $this->Form->create();?>	
	<h1>Submit Teacher's Contact Information</h1>
	<table width='500'>
		
		<tr>
			<td width='120'>Name *</td>
			<td><?php echo $this->Form->input('Teacher.name', array('label'=>false, 'type'=>'text', 'div'=>false, 'required'=>true, 'placeholder'=>'Enter Full Name', 'style'=>'width:100%'));?></td>
		</tr>
		<tr>
			<td>Phone No. *</td>
			<td><?php echo $this->Form->input('Teacher.phone', array('label'=>false, 'div'=>false, 'required'=>true, 'placeholder'=>'Enter Phone No.', 'style'=>'width:100%'));?></td>
		</tr>
		
		<tr>
			<td valign='top'>Extra Information</td>
			<td><?php echo $this->Form->input('Teacher.extra_info', array('label'=>false, 'div'=>false, 'type'=>'textarea', 'rows'=>'3', 'required'=>false, 'placeholder'=>'Eg: Subjects taught, Email, Address..', 'style'=>'width:100%'));?></td>
		</tr>		
		<tr>
			<td>&nbsp;</td>
			<td>
				<?php 
					echo $this->Form->submit('Submit', array('escape'=>false, 'div'=>false, 'class'=>'button small green'));
					echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					echo $this->Html->link('Cancel', '/', array('escape'=>false, 'class'=>''));			
				?>				
			</td>
		</tr>		
	</table>
	<?php echo $this->Form->end();?>
</div>