<?php
$pSettings = $this->Session->read('PrivacySetting');
?>
<div>	
	<div class='heading floatLeft'>My Profile</div>
	<?php echo '&nbsp;'.$this->Html->link('Change Privacy Settings', '/users/changePrivacySettings', array('escape'=>false, 'class'=>'button small grey floatRight'));?>	
	<div class="floatRight" style="width:15px;">&nbsp;</div>
	<?php echo '&nbsp;'.$this->Html->link('Edit Profile', '/users/editProfile', array('escape'=>false, 'class'=>'button small grey floatRight'));?>
	<div class="clear"></div>
	<br/>
	<h1>School Information:</h1>	
	<?php
		$yearOptions = array();
		for($i=1965; $i<=2002; $i++) {
			$yearOptions[$i] = $i;
		}
	?>
	<table width='' class="floatLeft">
		<tr>
			<td width='125'>Member Type</td>
			<td width='20'>:</td>
			<td>
				<?php echo Configure::read('UserTypes.'.$userInfo['User']['type']);?>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Email Address </td>
			<td>:</td>
			<td><?php echo $userInfo['User']['email'];?></td>
			<td>
				<?php 
					$type = ($pSettings['show_email']) ? '(Public)' : '(Private)';
					echo $this->Html->link($type, '/users/changePrivacySettings');
				?>			
			</td>
		</tr>
		<?php
		if($userInfo['User']['type'] == 'student') {
		?>
		<tr>			
			<td>School Passout</td>
			<td>:</td>
			<td>
				<?php echo  $userInfo['User']['passout_year'];?>,    
				<?php echo  Configure::read('ClassOptions.'.$userInfo['User']['class']);?>&nbsp;-&nbsp;<?php echo  Configure::read('ClassSections.'.$userInfo['User']['section']);?> 
			</td>	
			<td>&nbsp;</td>			
		</tr>
		<tr>
			<td>Batch</td>
			<td>:</td>
			<td>
				<?php echo $userInfo['User']['batch'];?>
			</td>
			<td>&nbsp;</td>		
		</tr>
		<?php
		}
		else {
		?>
		<tr class='UserRow'>
			<td>Service Period</td>
			<td>:</td>
			<td>From <?php echo ($userInfo['User']['service_start_year']) ? $userInfo['User']['service_start_year'] : '-';?> to <?php echo ($userInfo['User']['service_end_year']) ? $userInfo['User']['service_end_year'] : '-';?></td>
			<td>&nbsp;</td>			
		</tr>
		<?php
		}
		if($userInfo['User']['type'] == 'teacher') {				
		?>
			<tr class='UserRow'>
				<td>Subjects Taught</td>
				<td>:</td>
				<td><?php echo ($userInfo['User']['subjects']) ? '<pre>'.$userInfo['User']['subjects'].'</pre>' : '-'; ?></td>
				<td>&nbsp;</td>
			</tr>		
		<?php
		}
		if($userInfo['User']['type'] == 'non_teaching_staff') {
		?>		
		<tr class='UserRow'>
			<td>Profession</td>
			<td>:</td>
			<td>
				<?php echo ($userInfo['User']['profession']) ? $userInfo['User']['profession'] : '-';?> 
			</td>
			<td>&nbsp;</td>
		</tr>
		<?php
		}
		?>
	</table>
	<div class="floatRight" style="margin-right:50px; text-align:center;">		
		<?php
		$image_id = $userInfo['User']['image_id'];
		if($image_id) {
			echo $this->Img->showImage('img/images/'.$image_id, array('height'=>'150','width'=>'150','type'=>'crop'), array('style'=>'border:1px solid #ccc;', 'alt'=>''));
		}
		else {
			echo $this->Img->showImage('img/noimage.jpg', array('height'=>'150','width'=>'150','type'=>'crop'), array('style'=>'border:1px solid #ccc;', 'alt'=>''));
		}
		?>
		<?php echo ($this->Session->read('User.image_id')) ? '<br/>'.$this->Html->link('Remove Photo', '/users/removePhoto', array(), 'Are you sure you want to remove your photo?') : '';?>
		<br>
		<?php 
			$type = ($pSettings['show_profile_image']) ? '(Public)' : '(Private)';
			echo $this->Html->link($type, '/users/changePrivacySettings');
		?>
	</div>
	<div class='clear'></div>
	<br>
	<h2>Personal Information:</h2>
	<table width='500'>
		<tr>
			<td width='125'>Name</td>
			<td width='20'>:</td>
			<td><?php echo $userInfo['User']['name'];?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Date of Birth</td>
			<td>:</td>
			<td><?php echo ($userInfo['User']['dob']) ? date('d-M-Y', strtotime($userInfo['User']['dob'])) : '-';?></td>
			<td>
				<?php 
					$type = ($pSettings['show_dob']) ? '(Public)' : '(Private)';
					echo $this->Html->link($type, '/users/changePrivacySettings/edit');
				?>			
			</td>
		</tr>
		<tr>
			<td>Phone No.</td>
			<td>:</td>			
			<td><?php echo($userInfo['User']['phone']) ? $userInfo['User']['phone'] : '-';?></td>
			<td>
				<?php 
					$type = ($pSettings['show_phone']) ? '(Public)' : '(Private)';
					echo $this->Html->link($type, '/users/changePrivacySettings/edit');
				?>			
			</td>
		</tr>
		<tr>
			<td colspan='3' style="font-weight:bold;font-style:italic;"><br/>Address:</td>
			<td><br/>
				<?php 
				$type = ($pSettings['show_email']) ? '(Public)' : '(Private)';
				echo $this->Html->link($type, '/users/changePrivacySettings/edit');
				?>
			</td>
		</tr>
		<tr>
			<td width='125'>Street Address</td>
			<td width='20'>:</td>
			<td><?php echo ($userInfo['User']['address']) ? $userInfo['User']['address'] : '-';?></td>		
			<td>&nbsp;</td>			
		</tr>		
		<tr>
			<td>City</td>
			<td>:</td>
			<td><?php echo ($userInfo['User']['city']) ? $userInfo['User']['city'] : '-';?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>State</td>
			<td>:</td>
			<td><?php echo ($userInfo['User']['state']) ? $userInfo['User']['state'] : '-';?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Country</td>
			<td>:</td>
			<td><?php echo ($userInfo['User']['country']) ? $userInfo['User']['country'] : '-';?></td>
			<td>&nbsp;</td>
		</tr>		
		<tr>
			<td>Pin Code</td>
			<td>:</td>
			<td><?php echo ($userInfo['User']['pincode']) ? $userInfo['User']['pincode'] : '-';?></td>
			<td>&nbsp;</td>
		</tr>	
		<tr>			
			<td colspan='4'>&nbsp;</td>
		</tr>
		<tr>
			<td width='125'>Profession</td>
			<td width='20'>:</td>
			<td><?php echo ($userInfo['User']['current_profession']) ? $userInfo['User']['current_profession'] : '-';?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Organization</td>
			<td>:</td>
			<td><?php echo ($userInfo['User']['organization']) ? $userInfo['User']['organization'] : '-';?></td>
			<td>&nbsp;</td>
		</tr>			
	</table>
	<br/>
	<h2>Extra Information</h2>
	<table width='500'>
		<tr>
			<td width='125'>Blood Group</td>
			<td width='20'>:</td>
			<td><?php echo $userInfo['User']['blood_group'];?></td>
		</tr>
		<tr>
			<td width='125'>Food Preference</td>
			<td width='20'>:</td>
			<td><?php echo ($userInfo['User']['is_vegetarian']) ? 'Vegetarian' : 'Non Vegetarian';?></td>
		</tr>
	</table>
	
</div>

<br><br>