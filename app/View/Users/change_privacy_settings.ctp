<div class="heading floatLeft">Change Privacy Settings</div>
<?php echo '&nbsp;'.$this->Html->link('Cancel', '/users/viewProfile', array('escape'=>false, 'class'=>'button small red floatRight'));?>
<div class="clear"></div>

<?php echo $this->Form->create();?>
<table width='500'>
	<tr>
		<td width='100'>Email Address</td>
		<td width='20'>:</td>
		<td>	
			<?php echo $this->Form->input('PrivacySetting.show_email', array('label'=>' Public (Everyone can see it)', 'div'=>false));?>	
		</td>
	</tr>
	<tr>
		<td>Date of Birth</td>
		<td width='20'>:</td>
		<td>	
			<?php echo $this->Form->input('PrivacySetting.show_dob', array('label'=>' Public (Everyone can see it)', 'div'=>false));?>	
		</td>
	</tr>
	<tr>
		<td>Phone No.</td>
		<td width='20'>:</td>
		<td>	
			<?php echo $this->Form->input('PrivacySetting.show_phone', array('label'=>' Public (Everyone can see it)', 'div'=>false));?>	
		</td>
	</tr>
	<tr>
		<td>Address</td>
		<td width='20'>:</td>
		<td>	
			<?php echo $this->Form->input('PrivacySetting.show_address', array('label'=>' Public (Everyone can see it)', 'div'=>false));?>	
		</td>
	</tr>
	<tr>
		<td>Profile Image</td>
		<td width='20'>:</td>
		<td>	
			<?php echo $this->Form->input('PrivacySetting.show_profile_image', array('label'=>' Public (Everyone can see it)', 'div'=>false));?>	
		</td>
	</tr>
	<tr>
		<td colspan='2'>&nbsp;</td>
		<td>	
			<br/><?php echo $this->Form->submit('Save Changes &nbsp;&raquo;', array('class'=>'button small green', 'escape'=>false));?>			
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>