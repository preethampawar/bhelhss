<div>	
	<div class="floatRight button small orange" onclick="$('#uploadPostPhotoFormDiv').slideDown()"> + Share Photo</div>
	<div class='clear'></div>
	<div style="width:600px; margin-top:10px; display:none;" id="uploadPostPhotoFormDiv">
		<h3>Share this photo</h3>
		<?php 
		echo $this->Form->create(null, array('type'=>'file', 'url'=>'/images/uploadPostPhoto/'.$postInfo['Post']['id']));	
		?>
		<table style="width:100%;">
			<tr>
				<td style="width:120px;">Select Photo</td>
				<td>
					<?php echo $this->Form->input('Image.file', array('type'=>'file', 'label'=>false));?> 
					<span style="font-style:normal; font-size:10px;">Max. photo size <?php echo Configure::read('MaxImageSize');?> MB. Only JPEG, PNG & GIF format images are allowed.</span>
				</td>
			</tr>
			<tr>
				<td>Photo belongs to:</td>
				<td>
					<?php
						$yearOptions = array();
						for($i=2004; $i>=1963; $i--) {
							$yearOptions[$i] = $i;
						}
						
						echo $this->Form->input('Image.batch', array('label'=>'Batch(10th) ', 'div'=>false, 'options'=>$yearOptions, 'type'=>'select', 'style'=>'width:100px;', 'empty'=>'-None-'));
						echo '&nbsp;&nbsp;&nbsp;';				
					?>	
					<?php 
						$classOptions = Configure::read('ClassOptions');
						echo $this->Form->input('Image.class', array('label'=>'Class ', 'div'=>false, 'options'=>$classOptions, 'type'=>'select', 'style'=>'width:80px;', 'empty'=>'-None-'));
					?>	
					&nbsp;&nbsp;&nbsp;
					<?php 
						$classSections = Configure::read('ClassSections');
						echo $this->Form->input('Image.section', array('label'=>'Section ', 'div'=>false, 'options'=>$classSections, 'type'=>'select', 'style'=>'width:80px;', 'empty'=>'-None-'));
					?>	
				</td>
			</tr>		
			<tr>
				<td>Description</td>
				<td style="padding-top:10px;">
					<?php echo $this->Form->input('Image.caption', array('label'=>false, 'type'=>'textarea', 'rows'=>'2', 'style'=>'width:300px;'));;?>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					
					<?php echo $this->Form->submit('Upload &nbsp;&raquo;', array('escape'=>false, 'class'=>'button small green', 'div'=>false));?>		
					&nbsp;&nbsp;|&nbsp;&nbsp;
					<span style="color:#55ABDA; cursor:pointer;" onclick="$('#uploadPostPhotoFormDiv').slideUp()"> Cancel </span>	
				</td>
			</tr>
		</table>
		<?php	
		echo $this->Form->end();
		?>
		<div style="font-size:11px; color:grey; font-style:italic; margin-top:10px;">
			Note: Images containing explicit material, or content that is otherwise deemed explicit by the HSS team will be removed with out notice and the person who uploads such content will be banned permanantly from the group.
		</div>
	</div>	
	<br>
</div>
