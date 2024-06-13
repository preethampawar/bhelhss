<?php echo $this->element('message');?>
<div>
	<?php echo $this->Form->create();?>	
	
	<?php
		
		$yearOptions = array();
		for($i=1965; $i<=2002; $i++) {
			$yearOptions[$i] = $i;
		}
	?>
	<h1>Refer Your School Friend</h1>
	<table width='500'>
		
		<tr>
			<td width='120'>Name *</td>
			<td><?php echo $this->Form->input('ReferFriend.name', array('label'=>false, 'type'=>'text', 'div'=>false, 'required'=>true, 'placeholder'=>'Name of the person being referred', 'style'=>'width:100%'));?></td>
		</tr>
		<tr>
			<td width='120'></td>
			<td>
			<?php echo $this->Form->input('ReferFriend.batch', array('label'=>'Batch ', 'div'=>false, 'options'=>$yearOptions, 'type'=>'select', 'style'=>'width:80px;'));?><br><br>
			</td>
		</tr>
		<tr>
			<td>Email Address</td>
			<td><?php echo $this->Form->input('ReferFriend.email', array('label'=>false, 'type'=>'email', 'div'=>false, 'placeholder'=>'Email address of the person being referred', 'style'=>'width:100%'));?></td>
		</tr>
		<tr>
			<td>Phone no.</td>
			<td><?php echo $this->Form->input('ReferFriend.phone', array('label'=>false, 'type'=>'phone', 'div'=>false, 'placeholder'=>'Phone no. of the person being referred', 'style'=>'width:100%'));?></td>
		</tr>
		
		<tr>
			<td valign='top'>Message</td>
			<td><?php echo $this->Form->input('ReferFriend.message', array('label'=>false, 'div'=>false, 'type'=>'textarea', 'rows'=>'3', 'placeholder'=>'Your message  goes here..', 'style'=>'width:100%'));?></td>
		</tr>		
		<tr>
			<td>&nbsp;</td>
			<td>
				<?php 
					echo $this->Form->submit('Submit', array('escape'=>false, 'div'=>false, 'class'=>'button small green'));
				
					if($this->Session->check('ReferFriend')) { 
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						echo $this->Html->link('Cancel', '/', array('escape'=>false, 'class'=>''));				
					}
				?>				
			</td>
		</tr>		
	</table>
	<?php echo $this->Form->end();?>
</div>