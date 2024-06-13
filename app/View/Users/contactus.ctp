<?php echo $this->element('message');?>
<div>
	<?php echo $this->Form->create();?>	
	<h1>Contact Us</h1>
	
	<div>
		Mobile: <span style="border-bottom:1px dotted #aaa; font-weight:bold;">+91 9493692233</span> <br>
		Email: <span style="border-bottom:1px dotted #aaa; font-weight:bold;">bhelhssaa@gmail.com</span> <br>
		<span><a href="https://www.facebook.com/groups/296465983802820/">Follow us on Facebook</a></span>
	</div>
	<br>	
	<span style="font-weight:bold;">(OR)</span>
	<br><br>	

	<h3>Drop a message</h3>	
	<table width='500'>
		<?php if(!$this->Session->check('User')) { ?>
		<tr>
			<td width='120'>Name</td>
			<td><?php echo $this->Form->input('User.name', array('label'=>false, 'type'=>'text', 'div'=>false, 'required'=>true, 'placeholder'=>'Enter Full Name', 'style'=>'width:100%'));?></td>
		</tr>
		<tr>
			<td>Email Address</td>
			<td><?php echo $this->Form->input('User.email', array('label'=>false, 'type'=>'email', 'div'=>false, 'required'=>true, 'placeholder'=>'Enter Email Address', 'style'=>'width:100%'));?></td>
		</tr>
		<?php } ?>
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