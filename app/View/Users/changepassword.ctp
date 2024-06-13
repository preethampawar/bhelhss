<?php echo $this->element('message');?>

<div>
	<?php echo $this->Form->create();?>
	<h2>Change Password</h2>
	
	<table width='400'>
		<tr>
			<td width='130'>Old Password</td>			
			<td><?php echo $this->Form->input('User.password', array('label'=>false, 'div'=>false, 'required'=>true, 'placeholder'=>'Enter Old Password', 'style'=>'width:100%'));?></td>
		</tr>
		<tr>
			<td>New Password</td>			
			<td><?php echo $this->Form->input('User.new_password', array('label'=>false, 'div'=>false, 'type'=>'password', 'required'=>true, 'placeholder'=>'Enter New Password', 'style'=>'width:100%'));?></td>
		</tr>
		<tr>
			<td>Confirm Password</td>			
			<td><?php echo $this->Form->input('User.confirm_password', array('label'=>false, 'div'=>false, 'type'=>'password', 'required'=>true, 'placeholder'=>'Confirm New Password', 'style'=>'width:100%'));?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<br>
				<?php echo $this->Form->submit('Save Changes &nbsp;&raquo;', array('escape'=>false, 'div'=>false, 'class'=>'button small green'));?>	
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php echo '&nbsp;'.$this->Html->link('Cancel &nbsp;&nbsp;&nbsp;', '/', array('escape'=>false));	?>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end();?>
</div>
<br><br>