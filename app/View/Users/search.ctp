<?php echo $this->element('message');?>
<div>
	<?php echo $this->Form->create();?>	
	<h1>Search</h1>
	<table width='400'>
		<tr>
			
		</tr>
	</table>
	<?php
		$userOptions = array('student'=>'Student', 'teacher'=>'Teacher', 'principal'=>'Principal', 'non_teaching_staff'=>'Non Teaching Staff');
		
		
		$yearOptions = array();
		for($i=2004; $i>=1963; $i--) {
			$yearOptions[$i] = $i;
		}
	?>
	<table>
		<tr>
			<td>
				Name <br/>
				<?php echo $this->Form->input('User.name', array('label'=>false, 'type'=>'text', 'div'=>false, 'required'=>true, 'placeholder'=>'Enter text here..', 'style'=>'width:200px;'));?>				
				
			</td>
			<td>&nbsp;</td>
			<td>
				Member Type <br>
				<?php echo $this->Form->input('User.type', array('label'=>false, 'empty'=>false, 'options'=>Configure::read('UserTypes'), 'div'=>false, 'required'=>true, 'style'=>'width:100%'));?>
			</td>
			<td>&nbsp;</td>
			<td>
				Batch <span style="font-style:italic; font-size:90%;">(10th class)</span> <br>
				<?php
				echo $this->Form->input('User.batch', array('label'=>false, 'div'=>false, 'options'=>$yearOptions, 'type'=>'select', 'style'=>'width:150px;', 'empty'=>'--Any--'));
				?>				
			</td>	
			<td>&nbsp;</td>
			<td>	
				<br>
				<?php echo $this->Form->submit('Search &nbsp;&raquo;', array('escape'=>false, 'div'=>false, 'class'=>'button small grey', 'style'=>'width:120px;'));?>	
			</td>
		</tr>
		
	</table>
	<?php echo $this->Form->end();?>
</div>
<br><br>
<section>
	<header>
		<h2>Search Results</h2>
	</header>
	
	<div>		
		<?php
		if(isset($users)) {
			
			if(!empty($users)) {
				
		?>
			<table class="table" style="font-size:12px;">
				<thead>
					<tr>
						<th style="width:40px;">No.</th>
						<th>Name</th>
						<th>Email Address</th>
						<?php if($type == 'student') { ?>
						<th style="width:50px;">Batch</th>
						<th style="width:100px;">Passout</th>
						<?php } else { ?>
						<th style="width:120px;">Service Period</th>
						<?php }?>						
						<th style="width:150px;"></th>
					</tr>
				</thead>
				<tbody>
				<?php
				$i=0;	
				foreach($users as $row) {
					$i++;
					$userID = $row['User']['id'];
				?>
					<tr>
						<td align='center'><?php echo $i;?>.</td>
						<td valign='top'>
							<?php
							$imageID = 0;
							if($row['PrivacySetting']['show_profile_image']) {
								$imageID = $row['User']['image_id'];
							}
							?>
							<div style="float:left;">
								<?php //$this->Img->showImage('img/images/'.$imageID, array('height'=>'60','width'=>'60','type'=>'crop'));?>
							</div>
							<div style="float:left; margin-left:5px;">
								<?php echo $row['User']['name'];?>
								<?php
								if(!$row['User']['registered']) {
									echo '<span style="font-size:85%; font-style:italic; color:red;">(Account Not Confirmed)</span>';
								}
								?>
							</div>
							<div style="clear:both"></div>
						</td>
						<td align='center' width="220">
							<span style="font-size:12px;"><?php echo ($row['PrivacySetting']['show_email']) ? $row['User']['email'] : '-';?></span>
						</td>
						<?php if($type == 'student') { ?>
						<td align='center'>
							<?php echo $row['User']['batch'];?> 
						</td>	
						<td align='center'>
							<?php
							if($row['User']['batch']) {
							?>
							<?php echo $row['User']['passout_year'];?>, 
							<?php echo  Configure::read('ClassOptions.'.$row['User']['class']);?>&nbsp;-&nbsp;<?php echo  Configure::read('ClassSections.'.$row['User']['section']);?> 
							<?php
							}
							?>
						</td>
						<?php } else { ?>
						<td align='center'><?php echo $row['User']['service_start_year'].' - '.$row['User']['service_end_year'];?></td>
						
						<?php } ?>						
						<td align='center'>
							<?php
							if($row['User']['batch']) {
							?>
							<?php echo $this->Html->link('Send Message', array('controller'=>'users', 'action'=>'sendMessage', $userID));?>
							&nbsp;|&nbsp;
							<?php echo $this->Html->link('Details', array('controller'=>'users', 'action'=>'info', $userID));?>
							<?php 
							}
							else {
								echo $this->Html->link('Send Message', array('controller'=>'users', 'action'=>'sendMessage', $userID));
							}
							?>
						</td>
					</tr>
				<?php
				}
				?>				
				</tbody>
			</table>
			
		<?php
			}
			else {
				echo ' - No Records Found';
			}
		}
		?>
		
	</div>
</section>
