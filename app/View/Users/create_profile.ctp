<?php 
echo $this->Html->css('smoothness/jquery-ui-1.8.18.custom'); 
echo $this->element('message');
?>
<script type="text/javascript">
function checkUserServicePeriod() {
	var fromYear = $('#UserServiceStartYear').val();
	var toYear = $('#UserServiceEndYear').val();			
	if(validateDate(fromYear, toYear) == false) {
		alert('To Year cannot be less than From Year');
		$('#UserServiceEndYear').val($('#UserServiceStartYear').val());
	}
}

function validateDate(fromYear, toYear) {
	if(fromYear>0) {
		if(toYear>0) {
			if(fromYear>toYear) {
				return false;
			}
		}
	}
	return true;
}
</script>
<div>	
	<div class='heading floatLeft'>Create Profile</div>
	<div class="clear"></div>
	
	<h1>School Information:</h1>
	<?php echo $this->Form->create(null, array('type'=>'file'));?>	
	<?php
		$userType = $this->Session->read('User.type');
		$yearOptions = array();
		for($i=1965; $i<=2002; $i++) {
			$yearOptions[$i] = $i;
		}
	?>
	<table width=''>		
		<tr>
			<td width='150'>Member Type *</td>
			<td><?php echo Configure::read('UserTypes.'.$userType); ?></td>
			<td><span class='note'>&nbsp;</span></td>
		</tr>
		<?php
		if($userType == 'student') {
		?>
		<tr>			
			<td>School Passout</td>
			<td colspan='2'>
				
				<?php echo $this->Form->input('User.passout_year', array('label'=>'Year ', 'div'=>false, 'options'=>$yearOptions, 'type'=>'select', 'style'=>'width:80px;', 'onchange'=>'setBatch()'));?>	
				&nbsp;&nbsp;&nbsp;
				<?php 
					$classOptions = Configure::read('ClassOptions');
					echo $this->Form->input('User.class', array('label'=>'Class ', 'div'=>false, 'options'=>$classOptions, 'type'=>'select', 'style'=>'width:80px;', 'onchange'=>'setBatch()', 'default'=>'10'));
				?>	
				&nbsp;&nbsp;&nbsp;
				<?php 
					$classSections = Configure::read('ClassSections');
					echo $this->Form->input('User.section', array('label'=>'Section ', 'div'=>false, 'options'=>$classSections, 'type'=>'select', 'style'=>'width:80px;'));
				?>	
			</td>			
		</tr>	
		<tr>
			<td>Batch (10th Class)</td>
			<td><?php echo $this->Form->input('User.batch', array('type'=>'text', 'label'=>false, 'readonly'=>true, 'style'=>'width:100px; background: transparent; border:0;'));?></td>
			<td><span class='note'>&nbsp;</span></td>			
		</tr>
		<?php
		}
		elseif(($userType=='teacher') or (($userType=='principal'))) {
		?>
		<tr>
			<td>Service Period</td>
			<td>
				From: <?php echo $this->Form->input('User.service_start_year', array('label'=>false, 'div'=>false, 'options'=>$yearOptions, 'type'=>'select', 'empty'=>false, 'onchange'=>'checkUserServicePeriod()'));?>	
				&nbsp;&nbsp;&nbsp;&nbsp;
				To: <?php echo $this->Form->input('User.service_end_year', array('label'=>false, 'div'=>false, 'options'=>$yearOptions, 'type'=>'select', 'empty'=>false, 'onchange'=>'checkUserServicePeriod()'));?>	
			</td>
			<td><span class='note'>&nbsp;</span></td>
		</tr>
		<tr>
			<td>Subjects Taught</td>
			<td>
				<?php echo $this->Form->input('User.subjects', array('label'=>false, 'type'=>'textarea', 'rows'=>'2', 'div'=>false, 'placeholder'=>'Enter subjects', 'style'=>'width:100%'));?>
			</td>
			<td><span class='note'>&nbsp;</span></td>
		</tr>
		<?php		
		}
		elseif($userType=='non_teaching_staff') {
		?>
		<tr>
			<td>Profession</td>
			<td>
				<?php echo $this->Form->input('User.profession', array('label'=>false, 'type'=>'text', 'div'=>false, 'placeholder'=>'Enter profession', 'style'=>'width:100%'));?>
			</td>
			<td><span class='note'>&nbsp;</span></td>
		</tr>
		<?php
		}
		?>
	</table>
	<br>
	<h2>Personal Information:</h2>
	<table width='500'>
		<tr>
			<td>My Photo</td>
			<td><?php echo $this->Form->input('Image.file', array('type'=>'file', 'label'=>false));	?></td>
			<td><span class='note'>(Private)</span></td>
		</tr>	
		<tr>
			<td width='150'>Name *</td>
			<td><?php echo $this->Form->input('User.name', array('label'=>false, 'type'=>'text', 'div'=>false, 'required'=>true, 'placeholder'=>'Enter Name', 'style'=>'width:100%'));?></td>
			<td><span class='note'>&nbsp;</span></td>
		</tr>
		<tr>
			<td>Phone No *</td>
			<td><?php echo $this->Form->input('User.phone', array('label'=>false, 'type'=>'number', 'div'=>false, 'required'=>true, 'placeholder'=>'Enter Phone No.', 'style'=>'width:100%'));?></td>
			<td><span class='note'>(Private)</span></td>
		</tr>		
		<tr>
			<td>Date of Birth</td>
			<td>
				<?php 
					$img = $this->Html->image('calendar.gif', array('onclick'=>"$('#datepicker').focus()"));
					echo $this->Form->input('User.dob', array('label'=>false, 'id'=>'datepicker', 'type'=>'text', 'required'=>false, 'after'=>'&nbsp;'.$img.'<input type="text" id="alternate" style="width:85%; border:0px solid #fff; color:#ff0000; background:transparent;">', 'readonly'=>true, 'placeholder'=>'Click to open calendar', 'style'=>'width:85%', 'div'=>false));	
				?>
			</td>
			<td><span class='note'>(Private)</span></td>
		</tr>		
		<tr>
			<td>Street Address</td>
			<td><?php echo $this->Form->input('User.address', array('label'=>false, 'type'=>'textarea','rows'=>'2', 'div'=>false, 'placeholder'=>'Enter Street Address', 'style'=>'width:100%'));?></td>
			<td><span class='note'>(Private)</span></td>
		</tr>
		<tr>
			<td>City</td>
			<td><?php echo $this->Form->input('User.city', array('label'=>false, 'type'=>'text', 'div'=>false, 'placeholder'=>'Enter City', 'style'=>'width:100%'));?></td>
			<td><span class='note'>(Private)</span></td>
		</tr>
		<tr>
			<td>State</td>
			<td><?php echo $this->Form->input('User.state', array('label'=>false, 'type'=>'text', 'div'=>false, 'placeholder'=>'Enter State', 'style'=>'width:100%'));?></td>
			<td><span class='note'>(Private)</span></td>
		</tr>
		<tr>
			<td>Country</td>
			<td>
				<?php 
				$selectedCountry=null;
				if(isset($this->data['User']['country'])) {
						$selectedCountry = $this->data['User']['country'];
				}
				echo $this->element('countries_select_box', array('selectedCountry'=>$selectedCountry));
				?>
			</td>
			<td><span class='note'>(Private)</span></td>
		</tr>
		<tr>
			<td>Pin Code</td>
			<td><?php echo $this->Form->input('User.pincode', array('label'=>false, 'type'=>'text', 'div'=>false, 'placeholder'=>'Enter pin code', 'style'=>'width:100%'));?></td>
			<td><span class='note'>(Private)</span></td>
		</tr>
		<tr>
			<td>Current Profession</td>
			<td><?php echo $this->Form->input('User.current_profession', array('label'=>false, 'type'=>'text', 'div'=>false, 'placeholder'=>'Enter Profession', 'style'=>'width:100%'));?></td>
			<td><span class='note'>&nbsp;</span></td>
		</tr>
		<tr>
			<td>Organization</td>
			<td><?php echo $this->Form->input('User.organization', array('label'=>false, 'type'=>'text', 'div'=>false, 'placeholder'=>'Enter Organization', 'style'=>'width:100%'));?></td>
			<td><span class='note'>&nbsp;</span></td>
		</tr>						
	</table>
	<br/>
	<h2>Extra Information:</h2>
	<table width='500'>
		<tr>
			<td width='150'>Blood Group</td>
			<td><?php echo $this->Form->input('User.blood_group', array('label'=>false, 'options'=>Configure::read('BloodGroup'), 'div'=>false, 'required'=>false, 'style'=>'width:100%'));?></td>
			<td><span class='note'>&nbsp;</span></td>
		</tr>
		<tr>
			<td width='150'>Food Preference</td>
			<td><?php echo $this->Form->input('User.is_vegetarian', array('label'=>'Vegetarian','options'=>array('1'=>'Vegetarian', '0'=>'Non Vegetarian'), 'type'=>'radio', 'div'=>false, 'required'=>false, 'separator'=>'&nbsp;&nbsp;&nbsp;&nbsp;'));?></td>
			<td><span class='note'>&nbsp;</span></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<br>
				<?php echo $this->Form->submit('Create Profile', array('escape'=>false, 'div'=>false, 'class'=>'button small green', 'style'=>'width:150px;'));?>	
			</td>
		</tr>
	</table>	
	<?php echo $this->Form->end();?>
	<br><br>
	<div class='notice'>Note*: By default your Photo, Phone Number, Email, Date of birth & Addresss will be set to private. Remaining fields are set to public. <br>
	You can change your privacy settings from your Profile Page.</div>
</div>

<script type="text/javascript">
setBatch();
$(function() {
	$( "#datepicker" ).datepicker({ altFormat: "yy-mm-dd", changeMonth: true, changeYear: true, yearRange: "1900:2010" });
	$( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd");
	$( "#datepicker" ).datepicker( "option", "altField", "#alternate");
	$( "#datepicker" ).datepicker( "option", "altFormat", "DD, d MM, yy");	
	//$( "#datepicker" ).datepicker( "option", "defaultDate", '' );
	<?php
	if(isset($this->data['User']['dob'])) {
	?>
		$( "#datepicker" ).attr( "value", "<?php echo $this->data['User']['dob'];?>" );
	<?php
	}
	else {
	?>
		$( "#datepicker" ).attr( "value", "1970-01-25" );
	<?php	
	}
	?>
});

</script>
<br><br>