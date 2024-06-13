<?php echo $this->element('message');?>
<div>
	<?php echo $this->Form->create();?>	
	<h1>Log in</h1>
	<table width='400' cellpadding='5' cellspacing='10'>
		<tr>
			<td width='110'>Email Address</td>
			<td><?php echo $this->Form->input('User.email', array('label'=>false, 'type'=>'email', 'div'=>false, 'required'=>true, 'placeholder'=>'Enter Email Address', 'style'=>'width:100%'));?></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><?php echo $this->Form->input('User.password', array('label'=>false, 'div'=>false, 'type'=>'password', 'required'=>true, 'placeholder'=>'Enter Password', 'style'=>'width:100%'));?></td>
		</tr>		
		<tr>
			<td>&nbsp;</td>
			<td>
				
				<?php echo $this->Form->submit('Log In &nbsp;&raquo;', array('escape'=>false, 'div'=>false, 'class'=>'button small green'));?>	
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php echo '&nbsp;'.$this->Html->link('Cancel &nbsp;&nbsp;&nbsp;', '/', array('escape'=>false));	?>
			</td>
		</tr>
		<tr>
			<td colspan='2'>
				<br>
				<?php echo $this->Html->link('Forgot your password?', '/users/forgotpassword', array('style'=>'text-decoration:none;')); ?>		
				<br><br>
				Need an account? Click here to <?php echo $this->Html->link('Register', '/users/register', array('style'=>'text-decoration:none;', 'escape'=>false)); ?>.				
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end();?>
</div>