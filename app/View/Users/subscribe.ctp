<?php echo $this->element('message');?>
<div>
	<?php echo $this->Form->create();?>	
	<h1>Subscribe/Unsubscibe from our mailing list</h1>
	<div class="note" style="font-size:11px;">
	Uncheck the boxes below, if you don't want to receive mails from bhelhss.com.
	</div>
	<table width='500'>		
		<tr>
			<td width='20'><?php echo $this->Form->input('User.subscribe_to_notifications', array('label'=>false, 'type'=>'checkbox', 'div'=>false, 'value'=>'1'));?></td>
			<td><label for="UserSubscribeToNotifications">Receive Notifications (Photo uploads, New Registrations)</label></td>
		</tr>
		<tr>
			<td><?php echo $this->Form->input('User.subscribe_to_news_letters', array('label'=>false, 'type'=>'checkbox', 'div'=>false, 'value'=>'1'));?></td>
			<td><label for="UserSubscribeToNewsLetters">Receive News Letters (News, Events, Blog posts)</label></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<br>
				<?php 
					echo $this->Form->submit('Update &raquo;', array('escape'=>false, 'div'=>false, 'class'=>'button small green'));
					echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					echo $this->Html->link('Cancel', '/', array('escape'=>false, 'class'=>''));				
				?>				
			</td>
		</tr>		
	</table>
	<?php echo $this->Form->end();?>
</div>
