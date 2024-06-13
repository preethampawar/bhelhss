<?php echo $this->element('message');?>
<div>
	<?php echo $this->Form->create();?>	
	<h1>Send Message:</h1>
	
	<table width='500'>		
		<tr>
			<td>To</td>
			<td><?php echo $userInfo['User']['name'];?></td>
		</tr>
		<tr>
			<td valign='top'>Message</td>
			<td><?php echo $this->Form->input('User.message', array('label'=>false, 'div'=>false, 'type'=>'textarea', 'rows'=>'3', 'required'=>true, 'placeholder'=>'Your message  goes here..', 'style'=>'width:100%'));?></td>
		</tr>		
		<tr>
			<td>&nbsp;</td>
			<td>
				<?php 
					echo $this->Form->submit('Submit', array('escape'=>false, 'div'=>false, 'class'=>'button small green'));
				
					if($this->Session->check('User')) { 
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						echo $this->Html->link('Cancel', '/', array('escape'=>false, 'class'=>''));				
					}
				?>				
			</td>
		</tr>
		<tr>
			<td colspan='2'>
				<br>
				<?php 
					if(!$this->Session->check('User')) {
						echo $this->Html->link('Need an account? Click here to Register', '/users/register', array('style'=>'text-decoration:none;', 'escape'=>false)); 
					} 
					else { 
					?>
						Click <?php echo $this->Html->link('here', '/');?> to visit <?php echo $this->Html->link('home page', '/');?>.
					<?php 
					} 
					?>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end();?>
</div>