<?php echo $this->element('message');?>

<div>	
	<h1>Register your account</h1>
	<?php echo $this->Form->create();?>	
	<table width='400'>
		<tr>
			<td>Member Type *</td>
			<td><?php echo $this->Form->input('User.type', array('label'=>false, 'options'=>Configure::read('UserTypes'), 'div'=>false, 'required'=>true, 'style'=>'width:100%'));?></td>
			
		</tr>
		<tr>
			<td width='150'>Name *</td>
			<td><?php echo $this->Form->input('User.name', array('label'=>false, 'type'=>'text', 'div'=>false, 'required'=>true, 'placeholder'=>'Enter Name', 'style'=>'width:100%'));?></td>
			<td><span class='note'>&nbsp;</span></td>
		</tr>
		<tr>
			<td width='150'>Email Address *</td>
			<td><?php echo $this->Form->input('User.email', array('label'=>false, 'type'=>'email', 'div'=>false, 'required'=>true, 'placeholder'=>'Enter Email Address', 'style'=>'width:100%'));?></td>
		</tr>
		<tr>
			<td>Password *</td>
			<td><?php echo $this->Form->input('User.password', array('label'=>false, 'div'=>false, 'type'=>'password', 'required'=>true, 'placeholder'=>'Enter Password', 'style'=>'width:100%'));?></td>
		</tr>
		<tr>
			<td>Confirm Password *</td>
			<td><?php echo $this->Form->input('User.confirm_password', array('label'=>false, 'div'=>false, 'type'=>'password', 'required'=>true, 'placeholder'=>'Confirm Your Password', 'style'=>'width:100%'));?></td>
		</tr>
		<tr>
			<td>Phone No *</td>
			<td><?php echo $this->Form->input('User.phone', array('label'=>false, 'type'=>'number', 'div'=>false, 'required'=>true, 'placeholder'=>'Enter Phone No.', 'style'=>'width:100%'));?></td>
			
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td>
				<br/>
				<?php echo $this->Form->submit('Register &nbsp;&raquo;', array('escape'=>false, 'div'=>false, 'class'=>'button small green'));?>	
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php echo '&nbsp;'.$this->Html->link('Cancel &nbsp;&nbsp;&nbsp;', '/', array('escape'=>false));	?>
			</td>
		</tr>
		<tr>
			<td colspan='2'>
				<br>
				<?php //echo $this->Html->link('Forgot your password?', '/users/forgotpassword', array('style'=>'text-decoration:none;')); ?>				
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end();
	?>
</div>
<br><br>